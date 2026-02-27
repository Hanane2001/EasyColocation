<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colocation;

class ColocationController extends Controller
{
    // public function index(){
    //     $colocations = auth()->user()->colocations()->withPivot('joined_at', 'left_at')->get();
    //     return view('colocations', compact('colocations'));
    // }
    // public function show(Colocation $colocation){
    //     $colocations = $colocation->load(['users','expenses']);//, 'expenses'
    //     return view('colocations', compact('colocations'));
    // }

public function index()
{
    $colocations = auth()->user()
        ->colocations()
        ->withPivot('joined_at', 'left_at')
        ->withCount(['users as active_users_count' => function ($q) {
            $q->whereNull('membership.left_at');
        }])
        ->withSum('expenses', 'amount')
        ->get();

    return view('colocations', compact('colocations'));
}
    public function show(Colocation $colocation)
{
    // 1️⃣ Authorization: خاص يكون عضو
    $isMember = $colocation->users()
        ->where('user_id', auth()->id())
        ->wherePivotNull('left_at')
        ->exists();

    if (!$isMember) {
        abort(403);
    }

    // 2️⃣ Load relations
    $colocation->load([
        'owner',
        'users' => function ($query) {
            $query->wherePivotNull('left_at');
        },
        'expenses.user'
    ]);

    // 3️⃣ Calcul somme dépenses
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
        $colocation->users()->updateExistingPivot(auth()->id(), ['left_at'=>now()]);
        return back();
    }
    public function cancel(Colocation $colocation){
        if($colocation->owner_id !== auth()->id()){
            abort(403);
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
}
