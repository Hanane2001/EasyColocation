<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colocation;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(Request $request, Colocation $colocation){
        if ($colocation->owner_id !== auth()->id()) {
            abort(403);
        }
        $request->validate(['name' => 'required|string|max:255']);
        $colocation->categories()->create(['name' => $request->name]);
        return back()->with('success', 'Catégorie ajoutée');
    }

    public function destroy(Colocation $colocation, Category $category){
        if ($colocation->owner_id !== auth()->id()) {
            abort(403);
        }
        $category->delete();
        return back()->with('success', 'Catégorie supprimée');
    }
}
