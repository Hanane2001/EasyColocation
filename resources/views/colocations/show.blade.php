@extends('layouts.app')

@section('content')
<div class="p-8 max-w-7xl mx-auto">
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-2xl p-4 flex items-center gap-3">
            <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
            <span class="text-emerald-700 text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-rose-50 border border-rose-200 rounded-2xl p-4 flex items-center gap-3">
            <div class="w-2 h-2 rounded-full bg-rose-500"></div>
            <span class="text-rose-700 text-sm font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-[2rem] p-8 mb-8 text-white shadow-xl">
        <div class="flex justify-between items-start">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <div class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                        {{ $colocation->statusColocation }}
                    </div>
                    @if($colocation->owner_id === auth()->id())
                        <div class="bg-amber-400/20 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider flex items-center gap-1">
                            <i class="fas fa-crown text-amber-300 text-[10px]"></i>
                            <span>Owner</span>
                        </div>
                    @endif
                </div>
                <h1 class="text-4xl font-black mb-2 tracking-tight">{{ $colocation->name }}</h1>
                <p class="text-indigo-100 text-sm flex items-center gap-2">
                    <i class="fas fa-user-circle"></i>
                    Créée par {{ $colocation->owner->name }} · {{ $colocation->created_at->format('d/m/Y') }}
                </p>
            </div>

            <div class="flex gap-6">
                <div class="text-right">
                    <div class="text-3xl font-black">{{ $colocation->activeUsers()->count() }}</div>
                    <div class="text-indigo-200 text-xs uppercase tracking-wider">Membres</div>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-black">{{ number_format($expensesSum, 0) }}</div>
                    <div class="text-indigo-200 text-xs uppercase tracking-wider">Dépenses</div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex gap-3 mb-8">
        @if($colocation->owner_id === auth()->id())
            <form method="POST" action="{{ route('colocations.cancel', $colocation) }}" 
                  onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette colocation ? Cette action est irréversible.')">
                @csrf
                <button class="bg-white border border-rose-200 text-rose-500 px-6 py-3 rounded-xl text-sm font-bold hover:bg-rose-50 hover:border-rose-300 transition-all flex items-center gap-2">
                    <i class="fas fa-ban"></i>
                    Annuler la colocation
                </button>
            </form>
        @else
            <form method="POST" action="{{ route('colocations.leave', $colocation) }}"
                  onsubmit="return confirm('Êtes-vous sûr de vouloir quitter cette colocation ?')">
                @csrf
                <button class="bg-white border border-rose-200 text-rose-500 px-6 py-3 rounded-xl text-sm font-bold hover:bg-rose-50 hover:border-rose-300 transition-all flex items-center gap-2">
                    <i class="fas fa-sign-out-alt"></i>
                    Quitter la colocation
                </button>
            </form>
        @endif
        
        <a href="{{ route('colocations.balances', $colocation) }}" 
           class="bg-white border border-emerald-200 text-emerald-600 px-6 py-3 rounded-xl text-sm font-bold hover:bg-emerald-50 hover:border-emerald-300 transition-all flex items-center gap-2">
            <i class="fas fa-scale-balanced"></i>
            Voir les balances
        </a>
    </div>

    <div class="grid grid-cols-3 gap-8">
        <div class="col-span-1 space-y-6">
            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-50">
                    <h2 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-users text-indigo-500"></i>
                        Membres actifs
                        <span class="ml-auto bg-indigo-50 text-indigo-600 text-xs px-2 py-1 rounded-full font-bold">
                            {{ $colocation->users->count() }}
                        </span>
                    </h2>
                </div>
                
                <div class="divide-y divide-gray-50">
                    @foreach($colocation->users as $member)
                        @php
                            $balance = $colocation->calculateUserBalance($member);
                        @endphp
                        <div class="p-4 hover:bg-gray-50/50 transition-colors">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-xs">
                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-sm text-slate-700">{{ $member->name }}</span>
                                        @if($member->id === $colocation->owner_id)
                                            <span class="ml-2 text-amber-500 text-[10px] font-bold uppercase">Owner</span>
                                        @endif
                                    </div>
                                </div>
                                <span class="text-xs font-bold {{ $member->reputation > 0 ? 'text-emerald-500' : ($member->reputation < 0 ? 'text-rose-500' : 'text-gray-300') }}">
                                    {{ $member->reputation }} pts
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-400 text-xs">Membre depuis {{ \Carbon\Carbon::parse($member->pivot->joined_at)->format('d/m/Y') }}</span>
                                
                                @if($balance > 0)
                                    <span class="text-emerald-600 font-bold text-xs">+{{ number_format($balance, 2) }} DH</span>
                                @elseif($balance < 0)
                                    <span class="text-rose-600 font-bold text-xs">{{ number_format($balance, 2) }} DH</span>
                                @else
                                    <span class="text-gray-300 text-xs">0 DH</span>
                                @endif
                            </div>

                            @if($colocation->owner_id === auth()->id() && $member->id !== auth()->id())
                                <div class="mt-2 flex justify-end gap-2">
                                    <button onclick="openTransferModal({{ $member->id }}, '{{ $member->name }}')"
                                            class="text-indigo-400 hover:text-indigo-600 text-[10px] font-bold uppercase tracking-wider flex items-center gap-1">
                                        <i class="fas fa-crown"></i>
                                        Transférer propriété
                                    </button>
                                    
                                    <form action="{{ route('colocations.kick', [$colocation, $member]) }}" method="POST"
                                          onsubmit="return confirm('Retirer {{ $member->name }} de la colocation ?')">
                                        @csrf
                                        <button class="text-rose-400 hover:text-rose-600 text-[10px] font-bold uppercase tracking-wider flex items-center gap-1">
                                            <i class="fas fa-user-minus"></i>
                                            Retirer
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            @if($colocation->owner_id === auth()->id())
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-6">
                    <h2 class="font-bold text-slate-800 flex items-center gap-2 mb-4">
                        <i class="fas fa-envelope text-indigo-500"></i>
                        Inviter des membres
                    </h2>
                    
                    <form method="POST" action="{{ route('invitations.store', $colocation) }}" class="mb-4">
                        @csrf
                        <div class="flex gap-2">
                            <input type="email" name="email" required placeholder="Email du membre"
                                   class="flex-1 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                            <button class="bg-indigo-600 text-white px-4 py-3 rounded-xl text-sm font-bold hover:bg-indigo-700 transition-colors">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('invitations.generateToken', $colocation) }}">
                        @csrf
                        <button class="w-full bg-gray-50 text-gray-600 px-4 py-3 rounded-xl text-sm font-bold hover:bg-gray-100 transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-link"></i>
                            Générer un lien d'invitation
                        </button>
                    </form>

                    @if(session('token_link'))
                        <div class="mt-3 bg-gray-50 p-3 rounded-xl text-xs">
                            <div class="font-bold text-gray-600 mb-1">Lien d'invitation :</div>
                            <div class="flex items-center gap-2">
                                <input type="text" value="{{ session('token_link') }}" 
                                       class="flex-1 bg-white border border-gray-200 p-2 rounded-lg text-xs" readonly>
                                <button onclick="navigator.clipboard.writeText('{{ session('token_link') }}')"
                                        class="bg-indigo-600 text-white px-3 py-2 rounded-lg text-xs font-bold hover:bg-indigo-700">
                                    Copier
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="col-span-2 space-y-6">
            @if($colocation->owner_id === auth()->id() || $colocation->categories->count() > 0)
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="font-bold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-tags text-indigo-500"></i>
                            Catégories
                        </h2>
                        
                        @if($colocation->owner_id === auth()->id())
                            <button onclick="document.getElementById('newCategoryModal').classList.remove('hidden')"
                                    class="bg-indigo-50 text-indigo-600 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-indigo-100 transition-colors flex items-center gap-1">
                                <i class="fas fa-plus"></i>
                                Nouvelle catégorie
                            </button>
                        @endif
                    </div>

                    @if($colocation->categories->count() > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach($colocation->categories as $category)
                                <div class="group bg-gray-50 px-4 py-2 rounded-full text-sm flex items-center gap-2">
                                    <span class="font-medium text-slate-600">{{ $category->name }}</span>
                                    @if($colocation->owner_id === auth()->id())
                                        <form action="{{ route('categories.destroy', [$colocation, $category]) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Supprimer la catégorie {{ $category->name }} ?')"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-300 hover:text-rose-500 transition-colors">
                                                <i class="fas fa-times text-xs"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 text-sm text-center py-4">
                            Aucune catégorie pour le moment
                        </p>
                    @endif
                </div>
            @endif

            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                    <h2 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-receipt text-indigo-500"></i>
                        Dernières dépenses
                    </h2>
                    
                    <a href="{{ route('expenses.index', $colocation) }}" 
                       class="text-indigo-600 text-sm font-bold hover:underline flex items-center gap-1">
                        Voir tout
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>

                @php
                    $recentExpenses = $colocation->expenses()->with(['user', 'category'])->latest()->limit(3)->get();
                @endphp

                @if($recentExpenses->count() > 0)
                    <div class="divide-y divide-gray-50">
                        @foreach($recentExpenses as $expense)
                            <div class="p-4 hover:bg-gray-50/50 transition-colors">
                                <div class="flex justify-between items-start mb-1">
                                    <div>
                                        <span class="font-bold text-slate-700">{{ $expense->title }}</span>
                                        @if($expense->category)
                                            <span class="ml-2 text-[10px] bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">
                                                {{ $expense->category->name }}
                                            </span>
                                        @endif
                                    </div>
                                    <span class="font-black text-indigo-600">{{ number_format($expense->amount, 2) }} DH</span>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-gray-400">
                                        <i class="fas fa-user-circle mr-1"></i>
                                        {{ $expense->user->name }}
                                    </span>
                                    <span class="text-gray-300">
                                        {{ $expense->expense_date->format('d/m/Y') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="text-gray-300 text-sm mb-3">Aucune dépense pour le moment</div>
                        <a href="{{ route('expenses.create', $colocation) }}" 
                           class="inline-flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-indigo-700 transition-colors">
                            <i class="fas fa-plus"></i>
                            Ajouter une dépense
                        </a>
                    </div>
                @endif

                <div class="p-4 bg-gray-50/50 border-t border-gray-50">
                    <a href="{{ route('expenses.create', $colocation) }}" 
                       class="flex items-center justify-center gap-2 text-indigo-600 text-sm font-bold hover:text-indigo-700 transition-colors">
                        <i class="fas fa-plus-circle"></i>
                        Nouvelle dépense
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="newCategoryModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white p-8 rounded-2xl w-96">
        <h3 class="text-lg font-bold mb-4">Nouvelle catégorie</h3>
        <form method="POST" action="{{ route('categories.store', $colocation) }}">
            @csrf
            <input type="text" name="name" placeholder="Nom de la catégorie" 
                   required class="w-full border border-gray-200 rounded-xl p-3 mb-4 focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('newCategoryModal').classList.add('hidden')" 
                        class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 font-bold hover:bg-gray-200 transition-colors">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition-colors">
                    Ajouter
                </button>
            </div>
        </form>
    </div>
</div>

<div id="transferModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white p-8 rounded-2xl w-96 max-w-md">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-crown text-indigo-600 text-2xl"></i>
            </div>
            <h2 class="text-xl font-bold text-slate-800 mb-2">Transférer la propriété</h2>
            <p class="text-sm text-gray-500">
                Vous êtes sur le point de transférer la propriété à <span id="transferMemberName" class="font-bold text-indigo-600"></span>
            </p>
        </div>

        <form method="POST" action="{{ route('colocations.transfer', $colocation) }}" id="transferForm">
            @csrf
            <input type="hidden" name="new_owner_id" id="newOwnerId">
            
            <div class="mb-6">
                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" name="leave_after_transfer" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <span>Quitter la colocation après le transfert</span>
                </label>
                <p class="text-xs text-gray-400 mt-1 ml-6">
                    Si coché, vous quitterez automatiquement la colocation
                </p>
            </div>

            <div class="flex gap-3">
                <button type="button" 
                        onclick="document.getElementById('transferModal').classList.add('hidden')"
                        class="flex-1 bg-gray-100 text-gray-700 px-4 py-3 rounded-xl font-bold hover:bg-gray-200 transition">
                    Annuler
                </button>
                <button type="submit" 
                        class="flex-1 bg-indigo-600 text-white px-4 py-3 rounded-xl font-bold hover:bg-indigo-700 transition">
                    Confirmer
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    window.onclick = function(event) {
        const categoryModal = document.getElementById('newCategoryModal');
        const transferModal = document.getElementById('transferModal');
        
        if (event.target === categoryModal) {
            categoryModal.classList.add('hidden');
        }
        if (event.target === transferModal) {
            transferModal.classList.add('hidden');
        }
    }

    function openTransferModal(userId, userName) {
        document.getElementById('newOwnerId').value = userId;
        document.getElementById('transferMemberName').textContent = userName;
        document.getElementById('transferModal').classList.remove('hidden');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('newCategoryModal').classList.add('hidden');
            document.getElementById('transferModal').classList.add('hidden');
        }
    });
</script>
@endpush
@endsection