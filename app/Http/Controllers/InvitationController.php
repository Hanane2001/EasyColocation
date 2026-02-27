<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colocation;
use App\Models\Invitation;
use Illuminate\Support\Str;


class InvitationController extends Controller
{
    public function store(Request $request, Colocation $colocation){
        Invitation::create([
            'email' => $request->email,
            'token' => Str::uuid(),
            'sender_id' => auth()->id(),
            'colocation_id' => $colocation->id,
            'expires_at' => now()->addDays(2)
        ]);
        return back();
    }

    public function accept($token) {
        $invitation = Invitation::where('token', $token)->firstOrFail();
        $invitation->update(['status' => 'accepted']);
        $invitation->colocation->users()->attach(auth()->id());
        return redirect()->route('colocations.index')->with('success', 'Vous avez rejoint la colocation.');
    }

    public function decline($token) {
        $invitation = Invitation::where('token', $token)->firstOrFail();
        $invitation->update(['status' => 'refused']);
        return redirect()->route('dashboard')->with('error', 'Vous avez décliné l\'invitation.');
    }
}
