<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colocation;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(Colocation $colocation, Request $request){
        if (!$colocation->activeUsers()->where('user_id', Auth::id())->exists()) {
            abort(403, 'Accès interdit');
        }
        $query = $colocation->expenses()->with(['user', 'category']);
        if ($request->month) {
            [$year, $month] = explode('-', $request->month);
            $query->whereMonth('expense_date', $month)->whereYear('expense_date', $year);
        }
        $expenses = $query->orderBy('expense_date', 'desc')->get();
        $statsByCategory = $colocation->expenses()->selectRaw('category_id, SUM(amount) as total')->groupBy('category_id')->get()->load('category');
        $statsByMonth = $colocation->expenses()->selectRaw('EXTRACT(MONTH FROM expense_date) as month, SUM(amount) as total')->groupBy('month')->orderBy('month')->get();
        return view('expenses.index', compact('colocation','expenses','statsByCategory','statsByMonth'));
    }

    public function create(Colocation $colocation){
        if (!$colocation->activeUsers()->where('user_id', Auth::id())->exists()) {
            abort(403, 'Accès interdit');
        }
        $categories = $colocation->categories;
        $users = $colocation->activeUsers()->get();
        return view('expenses.create', compact('colocation', 'categories', 'users'));
    }
    public function store(Request $request, Colocation $colocation){
        if (!$colocation->activeUsers()->where('user_id', Auth::id())->exists()) {
            abort(403, 'Accès interdit');
        }
        $request->validate([
            'title'        => 'required|string|max:255',
            'amount'       => 'required|numeric|min:0.01',
            'category_id'  => 'required|exists:categories,id',
            'expense_date' => 'required|date',
            'user_id'      => 'required|exists:users,id',
        ]);
        $isActive = $colocation->activeUsers()->where('user_id', $request->user_id)->exists();
        if (!$isActive) {
            return back()->withErrors(['user_id' => 'Cet utilisateur n’est pas membre actif.']);
        }
        if (!$colocation->categories()->where('id', $request->category_id)->exists()) {
            return back()->withErrors(['category_id' => 'Catégorie invalide.']);
        }
        $colocation->expenses()->create([
            'title'         => $request->title,
            'amount'        => $request->amount,
            'category_id'   => $request->category_id,
            'expense_date'  => $request->expense_date,
            'user_id'       => $request->user_id,
        ]);
        return redirect()->route('expenses.index', $colocation->id)->with('success', 'Dépense ajoutée avec succès.');
    }
    public function destroy(Colocation $colocation, Expense $expense){
        if (!$colocation->activeUsers()->where('user_id', Auth::id())->exists()) {
            abort(403);
        }
        if ($expense->colocation_id !== $colocation->id) {
            abort(403);
        }
        $expense->delete();
        return back()->with('success', 'Dépense supprimée.');
    }
}
