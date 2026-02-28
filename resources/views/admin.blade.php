@extends('layouts.app')

@section('title', 'Administration - EasyColoc')

@section('content')
<div class="p-6 max-w-7xl mx-auto">

    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-100 rounded-xl p-4 flex items-center gap-3">
            <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
            <span class="text-emerald-700 text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-rose-50 border border-rose-100 rounded-xl p-4 flex items-center gap-3">
            <div class="w-2 h-2 rounded-full bg-rose-500"></div>
            <span class="text-rose-700 text-sm font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Administration</h1>
        <p class="text-sm text-gray-500 mt-1">Supervision globale de la plateforme</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users"></i>
                </div>
                <span class="text-xs font-medium text-gray-400">Total</span>
            </div>
            <div class="text-2xl font-bold text-slate-800 mb-1">{{ $users->count() }}</div>
            <div class="text-xs text-gray-500">Utilisateurs inscrits</div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-home"></i>
                </div>
                <span class="text-xs font-medium text-gray-400">Actives</span>
            </div>
            <div class="text-2xl font-bold text-slate-800 mb-1">{{ $colocations->count() }}</div>
            <div class="text-xs text-gray-500">Colocations</div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-coins"></i>
                </div>
                <span class="text-xs font-medium text-gray-400">Total</span>
            </div>
            <div class="text-2xl font-bold text-slate-800 mb-1">{{ number_format($expenses->sum('amount'), 2) }} DH</div>
            <div class="text-xs text-gray-500">Dépenses cumulées</div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-rose-100 text-rose-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-ban"></i>
                </div>
                <span class="text-xs font-medium text-gray-400">Bannis</span>
            </div>
            <div class="text-2xl font-bold text-slate-800 mb-1">{{ $users->where('is_banned', true)->count() }}</div>
            <div class="text-xs text-gray-500">Utilisateurs bannis</div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h2 class="text-lg font-semibold text-slate-800">Utilisateurs</h2>
            
            <form method="GET" action="{{ route('admin.dashboard') }}" class="flex gap-2">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" 
                           name="search" 
                           placeholder="Rechercher un email..." 
                           value="{{ request('search') }}" 
                           class="pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 w-full sm:w-64">
                </div>
                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    Rechercher
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.dashboard') }}" 
                       class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        Reset
                    </a>
                @endif
            </form>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500">
                    <tr>
                        <th class="px-6 py-4 text-left">ID</th>
                        <th class="px-6 py-4 text-left">Utilisateur</th>
                        <th class="px-6 py-4 text-left">Email</th>
                        <th class="px-6 py-4 text-center">Rôle</th>
                        <th class="px-6 py-4 text-center">Réputation</th>
                        <th class="px-6 py-4 text-center">Statut</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-gray-400 font-mono">#{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-lg flex items-center justify-center font-bold text-xs shadow-sm">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-slate-700">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($user->role === 'admin')
                                <span class="bg-purple-100 text-purple-600 text-xs font-medium px-2.5 py-1 rounded-full">
                                    <i class="fas fa-crown text-[10px] mr-1"></i>
                                    Admin
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-600 text-xs font-medium px-2.5 py-1 rounded-full">
                                    <i class="fas fa-user text-[10px] mr-1"></i>
                                    User
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-mono font-medium 
                                {{ $user->reputation > 0 ? 'text-emerald-600' : ($user->reputation < 0 ? 'text-rose-600' : 'text-gray-400') }}">
                                {{ $user->reputation > 0 ? '+' : '' }}{{ $user->reputation }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($user->is_banned)
                                <span class="inline-flex items-center gap-1.5 text-rose-600 text-xs font-medium">
                                    <i class="fas fa-circle text-[6px]"></i>
                                    Banni
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-emerald-600 text-xs font-medium">
                                    <i class="fas fa-circle text-[6px]"></i>
                                    Actif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if(auth()->id() !== $user->id)
                                <form method="POST" action="{{ $user->is_banned ? route('admin.unban', $user) : route('admin.ban', $user) }}" 
                                      onsubmit="return confirm('{{ $user->is_banned ? 'Débannir' : 'Bannir' }} cet utilisateur ?')">
                                    @csrf
                                    <button type="submit" 
                                            class="text-xs font-medium px-3 py-1.5 rounded-lg transition-colors inline-flex items-center gap-1
                                            {{ $user->is_banned 
                                                ? 'bg-emerald-50 text-emerald-600 hover:bg-emerald-100' 
                                                : 'bg-rose-50 text-rose-600 hover:bg-rose-100' }}">
                                        <i class="fas fa-{{ $user->is_banned ? 'unlock' : 'ban' }} text-[10px]"></i>
                                        {{ $user->is_banned ? 'Débannir' : 'Bannir' }}
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400 bg-gray-50 px-3 py-1.5 rounded-lg inline-flex items-center gap-1">
                                    <i class="fas fa-shield-alt text-[10px]"></i>
                                    Vous
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                            <i class="fas fa-search text-3xl mb-3 text-gray-300"></i>
                            <p class="text-sm">Aucun utilisateur trouvé</p>
                            @if(request('search'))
                                <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 text-xs hover:underline mt-2 inline-block">
                                    Réinitialiser la recherche
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex justify-between items-center">
            <div class="text-xs text-gray-500">
                <i class="fas fa-users mr-1"></i>
                Affichage de {{ $users->count() }} utilisateur(s)
            </div>
            <div class="text-xs text-gray-400">
                Dernière mise à jour : {{ now()->format('d/m/Y H:i') }}
            </div>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 sm:grid-cols-1 gap-4">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-sm font-semibold text-slate-800 mb-4">Statistiques rapides</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-500">Moyenne dépenses/colocation</span>
                    <span class="font-medium text-slate-700">
                        {{ $colocations->count() > 0 ? number_format($expenses->sum('amount') / $colocations->count(), 2) : 0 }} DH
                    </span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-500">Utilisateurs par colocation</span>
                    <span class="font-medium text-slate-700">
                        {{ $colocations->count() > 0 ? number_format($users->count() / $colocations->count(), 1) : 0 }}
                    </span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-500">Taux d'activité</span>
                    <span class="font-medium text-emerald-600">
                        {{ $users->count() > 0 ? round((($users->count() - $users->where('is_banned', true)->count()) / $users->count()) * 100, 1) : 0 }}%
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-indigo-600 transition-colors inline-flex items-center gap-2">
            <i class="fas fa-arrow-left text-xs"></i>
            Retour au tableau de bord
        </a>
    </div>

</div>
@endsection