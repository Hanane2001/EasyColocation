<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colocation;
use App\Models\Invitation;
use Illuminate\Support\Str;
use App\Mail\InvitationMail;
use Illuminate\Support\Facades\Mail;


class InvitationController extends Controller
{
    public function show($token){
        $invitation = Invitation::where('token', $token)->where('status', 'pending')->firstOrFail();
        if ($invitation->expires_at && $invitation->expires_at < now()) {
            return redirect()->route('dashboard')->with('error', 'Invitation expirée.');
        }
        return view('invitations', compact('invitation'));
    }
    public function store(Request $request, Colocation $colocation){
        if ($colocation->owner_id !== auth()->id()) {
            abort(403);
        }
        $request->validate(['email' => 'required|email']);
        $invitation = Invitation::create([
            'email' => $request->email,
            'token' => Str::uuid(),
            'sender_id' => auth()->id(),
            'colocation_id' => $colocation->id,
            'expires_at' => now()->addDays(2)
        ]);
        Mail::to($request->email)->send(new InvitationMail($invitation));
        return back()->with('success', 'Invitation envoyée par email.');
    }

    public function accept($token){
        $invitation = Invitation::where('token', $token)->where('status', 'pending')->firstOrFail();
        if ($invitation->expires_at && $invitation->expires_at < now()) {
            return redirect()->route('dashboard')->with('error', 'Invitation expirée.');
        }
        $hasActive = auth()->user()->colocations()->wherePivotNull('left_at')->where('statusColocation', 'active')->exists();
        if ($hasActive) {
            return redirect()->route('dashboard')->with('error', 'Vous avez déjà une colocation active.');
        }
        $invitation->update(['status' => 'accepted']);
        $invitation->colocation->users()->syncWithoutDetaching([auth()->id() => ['joined_at' => now()]]);
        return redirect()->route('colocations.index')->with('success', 'Vous avez rejoint la colocation.');
    }

    public function decline($token) {
        $invitation = Invitation::where('token', $token)->where('status', 'pending')->firstOrFail();
        $invitation->update(['status' => 'refused']);
        return redirect()->route('dashboard')->with('success', 'Invitation refusée.');
    }

    public function generateTokenLink(Colocation $colocation){
        if ($colocation->owner_id !== auth()->id()) {
            abort(403);
        }
        $invitation = Invitation::create([
            'token' => Str::uuid(),
            'sender_id' => auth()->id(),
            'colocation_id' => $colocation->id,
            'expires_at' => now()->addDays(2),
            'email' => null,
            'status' => 'pending'
        ]);
        return back()->with('token_link', url('/join/'.$invitation->token));
    }

    public function join($token){
        $invitation = Invitation::where('token', $token)->where('status', 'pending')->firstOrFail();
        if ($invitation->expires_at && $invitation->expires_at < now()) {
            return redirect()->route('dashboard')->with('error', 'Invitation expirée.');
        }
        if (!auth()->check()) {
            session(['join_token' => $token]);
            return redirect()->route('login');
        }
        $user = auth()->user();
        $colocation = $invitation->colocation;
        $hasActive = $user->colocations()->wherePivotNull('left_at')->where('statusColocation', 'active')->exists();
        if ($hasActive) {
            return redirect()->route('dashboard')->with('error', 'Vous avez déjà une colocation active.');
        }
        if ($colocation->users()->where('user_id', $user->id)->wherePivotNull('left_at')->exists()) {

            return redirect()->route('colocations.index')->with('info', 'Vous êtes déjà membre.');
        }
        $existing = $colocation->users()->where('user_id', $user->id)->first();
        if ($existing) {
            $colocation->users()->updateExistingPivot($user->id,['joined_at' => now(), 'left_at' => null]);
        } else {
            $colocation->users()->attach($user->id,['joined_at' => now()]);
        }
        $invitation->update(['status' => 'accepted']);
        return redirect()->route('colocations.index')->with('success', 'Vous avez rejoint la colocation.');
    }
}
