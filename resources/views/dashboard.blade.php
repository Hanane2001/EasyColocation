@extends('layouts.app')

@section('title', 'Tableau de bord - EasyColoc')

@section('content')
<div class="p-8">
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4 flex items-center gap-3 mb-6">
            <div class="w-2 h-2 rounded-full bg-emerald-500 ml-2"></div>
            <span class="text-emerald-700 text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 border border-rose-100 rounded-2xl p-4 flex items-center gap-3 mb-6">
            <div class="w-2 h-2 rounded-full bg-rose-500 ml-2"></div>
            <span class="text-rose-700 text-sm font-bold">{{ session('error') }}</span>
        </div>
    @endif

    @php
        $activeColocation = auth()->user()->colocations()
            ->wherePivotNull('left_at')
            ->where('statusColocation', 'active')
            ->first();
    @endphp

    @if(!$activeColocation)
        <div class="mb-8 bg-gradient-to-r from-indigo-50 to-blue-50 rounded-3xl p-6 border border-indigo-100">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-black text-indigo-900 uppercase tracking-wider">👋 Bienvenue {{ auth()->user()->name }} !</h2>
                    <p class="text-sm text-indigo-600 mt-1">Vous n'avez pas encore de colocation active.</p>
                </div>
                <button onclick="document.getElementById('newColocModal').classList.remove('hidden')" 
                        class="bg-indigo-600 text-white px-6 py-3 rounded-xl text-sm font-bold flex items-center gap-2 shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all">
                    <i class="fas fa-plus text-xs"></i>
                    Créer ma première colocation
                </button>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-[2.5rem] border border-gray-50 shadow-sm">
            <div class="bg-emerald-50 text-emerald-500 w-10 h-10 rounded-xl flex items-center justify-center mb-4">
                <i class="fas fa-medal"></i>
            </div>
            <div class="text-gray-400 text-sm font-medium">Ma réputation</div>
            <div class="text-4xl font-bold text-slate-800">{{ auth()->user()->reputation ?? 0 }}</div>
            <div class="mt-2 text-xs text-gray-400">
                @if(auth()->user()->reputation > 0)
                    <span class="text-emerald-500">👍 Membre fiable</span>
                @elseif(auth()->user()->reputation < 0)
                    <span class="text-rose-500">👎 Améliorations possibles</span>
                @else
                    <span class="text-gray-400">🆕 Nouveau membre</span>
                @endif
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2.5rem] border border-gray-50 shadow-sm">
            <div class="bg-indigo-50 text-indigo-500 w-10 h-10 rounded-xl flex items-center justify-center mb-4">
                <i class="fas fa-coins"></i>
            </div>
            <div class="text-gray-400 text-sm font-medium">Total dépensé (toutes coloc)</div>
            <div class="text-4xl font-bold text-slate-800">
                {{ number_format(auth()->user()->colocations()->with('expenses')->get()->pluck('expenses')->flatten()->sum('amount'), 2) }} €
            </div>
        </div>
    </div>

    @if($activeColocation)
        @php
            $activeColocation->load(['users' => function($q) {
                $q->wherePivotNull('left_at');
            }, 'expenses' => function($q) {
                $q->latest()->limit(5);
            }, 'expenses.user', 'expenses.category']);
            
            $totalExpenses = $activeColocation->expenses()->sum('amount');
            $memberCount = $activeColocation->users->count();
            $userBalance = $activeColocation->calculateUserBalance(auth()->user());
            $recentExpenses = $activeColocation->expenses()->with(['user', 'category'])->latest()->limit(5)->get();
        @endphp

        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-xl font-black text-slate-800 uppercase tracking-wider">
                Colocation active : <span class="text-indigo-600">{{ $activeColocation->name }}</span>
            </h2>
            <a href="{{ route('colocations.show', $activeColocation) }}" 
               class="text-indigo-600 text-sm font-bold hover:underline flex items-center gap-1">
                Voir détails <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-[2rem] border border-gray-50 shadow-sm">
                <div class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-1">Mon solde</div>
                @if($userBalance > 0)
                    <div class="text-2xl font-black text-emerald-500">+{{ number_format($userBalance, 2) }} €</div>
                    <div class="text-xs text-emerald-600 mt-1">On vous doit</div>
                @elseif($userBalance < 0)
                    <div class="text-2xl font-black text-rose-500">{{ number_format($userBalance, 2) }} €</div>
                    <div class="text-xs text-rose-600 mt-1">Vous devez</div>
                @else
                    <div class="text-2xl font-black text-gray-400">0 €</div>
                    <div class="text-xs text-gray-400 mt-1">Équilibré</div>
                @endif
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-gray-50 shadow-sm">
                <div class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-1">Membres</div>
                <div class="text-2xl font-black text-slate-800">{{ $memberCount }}</div>
                <div class="text-xs text-gray-400 mt-1">Actifs</div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-gray-50 shadow-sm">
                <div class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-1">Total dépenses</div>
                <div class="text-2xl font-black text-slate-800">{{ number_format($totalExpenses, 2) }} €</div>
                <div class="text-xs text-gray-400 mt-1">{{ now()->format('F Y') }}</div>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-8">
            <div class="col-span-2 bg-white rounded-[2.5rem] border border-gray-50 shadow-sm overflow-hidden">
                <div class="p-8 flex justify-between items-center border-b border-gray-50">
                    <h3 class="font-bold text-slate-800 text-lg">Dépenses récentes</h3>
                    <a href="{{ route('expenses.index', $activeColocation) }}" 
                       class="text-indigo-600 text-xs font-bold hover:underline">
                        Voir tout
                    </a>
                </div>
                
                @if($recentExpenses->count() > 0)
                    <div class="px-8 pb-8">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] uppercase text-gray-300 font-bold border-b border-gray-50">
                                    <th class="pb-4">Titre / Catégorie</th>
                                    <th class="pb-4 text-center">Payeur</th>
                                    <th class="pb-4 text-center">Montant</th>
                                    <th class="pb-4 text-right">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($recentExpenses as $expense)
                                <tr class="group">
                                    <td class="py-5">
                                        <div class="font-bold text-slate-700">{{ $expense->title }}</div>
                                        @if($expense->category)
                                            <div class="text-[10px] text-gray-300 bg-gray-50 px-2 py-0.5 rounded w-fit mt-1">
                                                {{ $expense->category->name }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-5 text-center">
                                        <span class="bg-indigo-50 text-indigo-600 text-[10px] font-bold w-6 h-6 inline-flex items-center justify-center rounded-full"
                                              title="{{ $expense->user->name }}">
                                            {{ strtoupper(substr($expense->user->name, 0, 1)) }}
                                        </span>
                                    </td>
                                    <td class="py-5 text-center font-bold text-slate-700">
                                        {{ number_format($expense->amount, 2) }} €
                                    </td>
                                    <td class="py-5 text-right text-xs text-gray-300">
                                        {{ $expense->expense_date->format('d/m') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="text-gray-300 text-sm mb-2">Aucune dépense pour le moment</div>
                        <a href="{{ route('expenses.create', $activeColocation) }}" 
                           class="text-indigo-600 text-xs font-bold hover:underline inline-flex items-center gap-1">
                            <i class="fas fa-plus"></i> Ajouter une dépense
                        </a>
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                <div class="bg-[#0F172A] rounded-[2rem] p-6 text-white">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-sm tracking-tight">Membres actifs</h3>
                        <span class="bg-slate-800 text-[9px] px-2 py-1 rounded text-gray-400 font-bold uppercase">
                            {{ $memberCount }}
                        </span>
                    </div>
                    <div class="space-y-3">
                        @foreach($activeColocation->users as $member)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-300">
                                    {{ $member->name }}
                                    @if($member->id === $activeColocation->owner_id)
                                        <span class="text-orange-400 text-[9px] ml-1">(Owner)</span>
                                    @endif
                                </span>
                                <span class="{{ $member->reputation > 0 ? 'text-emerald-500' : ($member->reputation < 0 ? 'text-rose-500' : 'text-gray-500') }} font-bold">
                                    {{ $member->reputation }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="bg-white rounded-[2rem] border border-gray-50 shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-slate-800 text-sm">Catégories</h3>
                        @if(auth()->id() === $activeColocation->owner_id)
                            <button onclick="document.getElementById('newCategoryModal').classList.remove('hidden')"
                                    class="bg-indigo-600 text-white text-[10px] px-3 py-1.5 rounded-lg font-bold flex items-center gap-1 hover:bg-indigo-700 transition-colors">
                                <i class="fas fa-plus text-[8px]"></i> Ajouter
                            </button>
                        @endif
                    </div>
                    
                    @if($activeColocation->categories->count() > 0)
                        <div class="space-y-2">
                            @foreach($activeColocation->categories as $category)
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl group hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-tag text-indigo-300 text-xs"></i>
                                        <span class="text-sm font-bold text-slate-600">{{ $category->name }}</span>
                                    </div>
                                    @if(auth()->id() === $activeColocation->owner_id)
                                        <form action="{{ route('categories.destroy', [$activeColocation, $category]) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Supprimer cette catégorie ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-400 opacity-0 group-hover:opacity-100 transition-opacity hover:text-rose-600">
                                                <i class="fas fa-trash-alt text-xs"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 text-xs text-center py-4">Aucune catégorie</p>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

<div id="newColocModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white p-8 rounded-xl w-96">
        <h2 class="text-lg font-bold mb-4">Créer une nouvelle colocation</h2>
        <form method="POST" action="{{ route('colocations.store') }}">
            @csrf
            <input type="text" name="name" placeholder="Nom de la colocation" 
                   required class="w-full border p-2 rounded mb-4">
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('newColocModal').classList.add('hidden')" 
                        class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 transition-colors">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 rounded bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition-colors">
                    Créer
                </button>
            </div>
        </form>
    </div>
</div>

@if($activeColocation)
<div id="newCategoryModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white p-8 rounded-xl w-96">
        <h2 class="text-lg font-bold mb-4">Nouvelle catégorie</h2>
        <form method="POST" action="{{ route('categories.store', $activeColocation) }}">
            @csrf
            <input type="text" name="name" placeholder="Nom de la catégorie" 
                   required class="w-full border p-2 rounded mb-4">
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('newCategoryModal').classList.add('hidden')" 
                        class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 transition-colors">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 rounded bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition-colors">
                    Ajouter
                </button>
            </div>
        </form>
    </div>
</div>
@endif

@push('scripts')
<script>
    window.onclick = function(event) {
        const modals = ['newColocModal', 'newCategoryModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });
    }
</script>
@endpush
@endsection