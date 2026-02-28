<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colocation;
use App\Models\User;

class ColocationController extends Controller
{
    public function index(){
        $colocations = auth()->user()->colocations()->withPivot('joined_at', 'left_at')
            ->withCount(['users as active_users_count' => function ($q) {
                $q->whereNull('membership.left_at');
            }])->withSum('expenses', 'amount')->get();
        return view('colocations', compact('colocations'));
    }
    public function show(Colocation $colocation){
        $isMember = $colocation->users()->where('user_id', auth()->id())->wherePivotNull('left_at')->exists();
        if (!$isMember) {
            abort(403);
        }
        $colocation->load(['owner', 'users' => function ($query) {
                $query->wherePivotNull('left_at');
            },
            'expenses.user']);
        $expensesSum = $colocation->expenses->sum('amount');
        return view('colocations.show', compact('colocation', 'expensesSum'));
    }
    public function store(Request $request){
        $hasActive = auth()->user()->colocations()->wherePivotNull('left_at')->where('statusColocation', 'active')->exists();
        if($hasActive){
            return back()->with('error', 'Déja une colocation active');
        }
        $colocation = Colocation::create(['name'=>$request->name, 'owner_id'=>auth()->id()]);
        $colocation->users()->attach(auth()->id(), ['joined_at'=>now()]);
        return redirect()->route('colocations.index');
    }
    public function leave(Colocation $colocation){
        if($colocation->owner_id == auth()->id()){
            return back()->with('error', 'Transférez la propriété avant');
        }
        $user = auth()->user();
        $balance = $this->calculateUserBalance($colocation, $user);

        if($balance < 0){
            $user->decrement('reputation');
        } else {
            $user->increment('reputation');
        }
        $colocation->users()->updateExistingPivot($user->id, ['left_at'=>now()]);
        return back();
    }
    public function cancel(Colocation $colocation){
        if($colocation->owner_id !== auth()->id()){
            abort(403);
        }
        $users = $colocation->activeUsers()->get();
        foreach($users as $user){
            $balance = $colocation->calculateUserBalance($user);
            if($balance < 0){
                $user->decrement('reputation');
            } else {
                $user->increment('reputation');
            }
        }
        $colocation->update(['statusColocation'=>'cancelled']);
        return back();
    }
    public function transfer(Request $request, Colocation $colocation){
        if ($colocation->owner_id !== auth()->id()) {
            abort(403);
        }
        $colocation->update(['owner_id' => $request->new_owner_id]);
        return back();
    }

    public function kickMember(Colocation $colocation, User $user){
        if($colocation->owner_id !== auth()->id()){
            abort(403, 'just owner possible kick un membre.');
        }
        if($user->id === auth()->id()){
            return back()->with('error', 'Vous ne pouvez pas vous retirer en tant qu’owner.');
        }
        $isMember = $colocation->users()->where('user_id', $user->id)->wherePivotNull('left_at')->exists();
        if(!$isMember){
            return back()->with('error', 'Cet utilisateur n’est pas membre actif.');
        }
        $balance = $colocation->calculateUserBalance($user);
        $owner = $colocation->owner;
        if($balance < 0){
            $user->decrement('reputation');
            $colocation->payments()->create(['amount' => abs($balance),'payer_id' => $owner->id,'receiver_id' => $user->id,'paid_at' => now()]);
        } else {
            $user->increment('reputation');
        }
        $colocation->users()->updateExistingPivot($user->id, ['left_at' => now()]);
        return back()->with('success', 'Membre retiré avec succès.');
    }

    public function balances(Colocation $colocation){
        if (!$colocation->activeUsers()->where('user_id', auth()->id())->exists()) {
            abort(403);
        }
        $users = $colocation->activeUsers()->get();
        $totalExpenses = $colocation->expenses()->sum('amount');
        $memberCount = $users->count();
        $individualShare = $memberCount > 0 ? $totalExpenses / $memberCount : 0;
        $balances = [];
        foreach ($users as $user) {
            $totalPaid = $colocation->expenses()->where('user_id', $user->id)->sum('amount');
            $totalReceived = $colocation->payments()->where('receiver_id', $user->id)->sum('amount');
            $totalSent = $colocation->payments()->where('payer_id', $user->id)->sum('amount');
            $balance = $totalPaid - $individualShare + $totalReceived - $totalSent;
            $balances[] = ['user' => $user,'paid' => $totalPaid,'share' => $individualShare,'balance' => $balance,];
        }
        $creditors = collect($balances)->filter(fn($b) => $b['balance'] > 0)->values();
        $debtors = collect($balances)->filter(fn($b) => $b['balance'] < 0)->values();
        $transactions = [];
        foreach ($debtors as $debtor) {
            $debt = abs($debtor['balance']);
            foreach ($creditors as &$creditor) {
                if ($debt <= 0) break;
                if ($creditor['balance'] <= 0) continue;
                $amount = min($debt, $creditor['balance']);
                $transactions[] = ['from' => $debtor['user']->name,'from_id' => $debtor['user']->id,'to' => $creditor['user']->name,'to_id' => $creditor['user']->id,'amount' => $amount,];
                $debt -= $amount;
                $creditor['balance'] -= $amount;
            }
        }
        return view('colocations.balances', compact('colocation','balances','transactions','totalExpenses','individualShare'));
    }
}
