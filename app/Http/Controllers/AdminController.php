<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    public function dashboard(){
        $users = User::all();
        return view('admin', compact('users'));
    }
    public function ban(User $user): RedirectResponse {
        if(auth()->user()->id !== $user->id) { 
            $user->update(['is_banned' => true]);
        }
        return redirect()->route('admin.dashboard')->with('success', 'utilisateur est banné');
    }

    public function unban(User $user): RedirectResponse {
        $user->update(['is_banned' => false]);
        return redirect()->route('admin.dashboard')->with('success', 'utilisateur est débanné');
    }
}
