@extends('layouts.app')

@section('content')
<div class="p-8 max-w-2xl mx-auto">

    <h2 class="text-2xl font-bold text-slate-800 mb-6">
        Ajouter une dépense pour {{ $colocation->name }}
    </h2>

    @if(session('success'))
        <div class="bg-emerald-100 text-emerald-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Errors --}}
    @if($errors->any())
        <div class="bg-rose-100 text-rose-600 p-3 rounded mb-4">
            <ul class="text-sm">
                @foreach($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('expenses.store', $colocation) }}" class="bg-white p-6 rounded-2xl shadow space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-bold mb-1">Titre</label>
            <input type="text" name="title" value="{{ old('title') }}"
                   class="w-full border rounded-lg p-2" required>
        </div>

        <div>
            <label class="block text-sm font-bold mb-1">Montant</label>
            <input type="number" step="0.01" min="0.01" name="amount"
                   value="{{ old('amount') }}"
                   class="w-full border rounded-lg p-2" required>
        </div>

        <div>
            <label class="block text-sm font-bold mb-1">Date</label>
            <input type="date" name="expense_date"
                   value="{{ old('expense_date', now()->toDateString()) }}"
                   class="w-full border rounded-lg p-2" required>
        </div>

        <div>
            <label class="block text-sm font-bold mb-1">Catégorie</label>
            <select name="category_id" class="w-full border rounded-lg p-2" required>
                <option value="">-- Sélectionner --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold mb-1">Payeur</label>
            <select name="user_id" class="w-full border rounded-lg p-2" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}"
                        {{ old('user_id', auth()->id()) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('expenses.index', $colocation) }}"
               class="px-4 py-2 bg-gray-200 rounded-lg">
                Annuler
            </a>

            <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg font-bold">
                Ajouter
            </button>
        </div>

    </form>
</div>
@endsection