<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Colocation;
use App\Models\Expense;

class AdminController extends Controller
{
    public function dashboard(Request $request) {
        $users = User::query();
        if ($request->has('search') && !empty($request->search)) {
            $users = $users->where('email', 'like', '%' . $request->search . '%');
        }
        $users = $users->get();
        $colocations = Colocation::all();
        $expenses = Expense::all();
        return view('admin', compact('users', 'colocations', 'expenses'));
    }
    public function ban(User $user): RedirectResponse{
        if(auth()->user()->id !== $user->id) { 
            $user->update(['is_banned' => true]);
            return redirect()->route('admin.dashboard')->with('success', 'Utilisateur banni avec succès');
        }
        return redirect()->route('admin.dashboard')->with('error', 'Vous ne pouvez pas vous bannir vous-même');
    }

    public function unban(User $user): RedirectResponse {
        $user->update(['is_banned' => false]);
        return redirect()->route('admin.dashboard')->with('success', 'utilisateur est débanné');
    }
}
