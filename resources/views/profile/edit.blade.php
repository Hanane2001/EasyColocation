@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="p-8 max-w-4xl mx-auto">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Mon Profil</h1>
        <p class="text-sm text-gray-400">Gérez vos informations personnelles</p>
    </div>

    @if(session('status') === 'profile-updated')
        <div class="bg-emerald-100 text-emerald-700 p-4 rounded-xl mb-6 flex items-center gap-3">
            <i class="fas fa-check-circle text-emerald-600"></i>
            <span class="font-medium">Profil mis à jour avec succès !</span>
        </div>
    @endif

    @if(session('status') === 'password-updated')
        <div class="bg-emerald-100 text-emerald-700 p-4 rounded-xl mb-6 flex items-center gap-3">
            <i class="fas fa-check-circle text-emerald-600"></i>
            <span class="font-medium">Mot de passe mis à jour avec succès !</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-1">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sticky top-24">
                <div class="flex flex-col items-center text-center">
                    {{-- Avatar avec initiales --}}
                    <div class="w-24 h-24 bg-indigo-600 rounded-2xl flex items-center justify-center text-white font-bold text-3xl mb-4 shadow-lg shadow-indigo-100">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    
                    <h2 class="text-xl font-bold text-slate-800">{{ auth()->user()->name }}</h2>
                    <p class="text-sm text-gray-400 mb-4">{{ auth()->user()->email }}</p>
                    
                    <div class="flex gap-2 mb-4">
                        @if(auth()->user()->role === 'admin')
                            <span class="bg-purple-100 text-purple-600 text-xs font-black px-3 py-1 rounded-full uppercase tracking-wider">
                                <i class="fas fa-crown mr-1"></i> Admin
                            </span>
                        @endif
                        
                        @if(auth()->user()->is_banned)
                            <span class="bg-rose-100 text-rose-600 text-xs font-black px-3 py-1 rounded-full uppercase tracking-wider">
                                <i class="fas fa-ban mr-1"></i> Banni
                            </span>
                        @endif
                    </div>
                    
                    <div class="w-full bg-gray-50 rounded-xl p-4">
                        <div class="text-[10px] uppercase text-gray-400 font-bold mb-1">Réputation</div>
                        <div class="text-2xl font-bold text-slate-800">{{ auth()->user()->reputation ?? 0 }} points</div>
                        <div class="w-full bg-gray-200 h-2 rounded-full mt-2 overflow-hidden">
                            @php
                                $repPercent = min(max((auth()->user()->reputation + 5) * 10, 0), 100);
                            @endphp
                            <div class="bg-emerald-500 h-full" style="width: {{ $repPercent }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:col-span-2 space-y-6">

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <i class="fas fa-user-circle text-indigo-600"></i>
                    Informations personnelles
                </h3>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf
                    @method('patch')

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nom complet</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                               class="w-full border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition" 
                               required autofocus>
                        @error('name')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Adresse email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                               class="w-full border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition" 
                               required>
                        @error('email')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                            <i class="fas fa-save mr-2"></i>
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <i class="fas fa-lock text-indigo-600"></i>
                    Changer le mot de passe
                </h3>

                <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                    @csrf
                    @method('put')

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Mot de passe actuel</label>
                        <input type="password" name="current_password" 
                               class="w-full border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition" 
                               required>
                        @error('current_password', 'updatePassword')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nouveau mot de passe</label>
                        <input type="password" name="password" 
                               class="w-full border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition" 
                               required>
                        @error('password', 'updatePassword')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" 
                               class="w-full border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition" 
                               required>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                            <i class="fas fa-key mr-2"></i>
                            Changer le mot de passe
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl border border-rose-100 shadow-sm p-6">
                <h3 class="text-lg font-bold text-rose-600 mb-6 flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle"></i>
                    Zone dangereuse
                </h3>

                <p class="text-sm text-gray-500 mb-4">
                    Une fois votre compte supprimé, toutes vos données seront définitivement effacées. 
                    Cette action est irréversible.
                </p>

                <button onclick="document.getElementById('deleteModal').classList.remove('hidden')" 
                        class="bg-rose-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-rose-600 transition">
                    <i class="fas fa-trash-alt mr-2"></i>
                    Supprimer mon compte
                </button>
            </div>
        </div>
    </div>
</div>

<div id="deleteModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white p-8 rounded-2xl w-96 max-w-md">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-rose-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-triangle text-rose-500 text-2xl"></i>
            </div>
            <h2 class="text-xl font-bold text-slate-800 mb-2">Confirmer la suppression</h2>
            <p class="text-sm text-gray-500">
                Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.
            </p>
        </div>

        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2 text-left">Mot de passe</label>
                <input type="password" name="password" 
                       class="w-full border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition" 
                       placeholder="Entrez votre mot de passe" 
                       required>
                @error('password', 'userDeletion')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="button" 
                        onclick="document.getElementById('deleteModal').classList.add('hidden')"
                        class="flex-1 bg-gray-100 text-gray-700 px-4 py-3 rounded-xl font-bold hover:bg-gray-200 transition">
                    Annuler
                </button>
                <button type="submit" 
                        class="flex-1 bg-rose-500 text-white px-4 py-3 rounded-xl font-bold hover:bg-rose-600 transition">
                    Supprimer
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    });

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
</script>

@endsection