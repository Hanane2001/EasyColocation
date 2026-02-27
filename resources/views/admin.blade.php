<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyColoc - Tableau de bord</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-[#F8FAFC] font-sans text-slate-700">

<div class="flex min-h-screen">
    <aside class="w-64 bg-[#0F172A] flex flex-col p-6">
        <div class="flex items-center gap-2 mb-10">
            <div class="text-indigo-400">
                <i class="fas fa-screwdriver-wrench text-xl"></i>
            </div>
            <span class="text-xl font-bold text-white tracking-tight">Admin</span>
        </div>

        <nav class="space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-indigo-600 text-white rounded-xl font-medium transition-all">
                <i class="fas fa-chart-line w-5 text-sm"></i>
                <span>Statistiques</span>
            </a>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white transition-all font-medium mt-4">
                <i class="fas fa-arrow-left w-5 text-sm"></i>
                <span>Retour app</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1">
        <header class="bg-white border-b border-gray-100 px-8 py-5 flex justify-between items-center">
            <h1 class="text-sm font-black text-slate-800 uppercase italic tracking-widest">Supervision Globale</h1>
            
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <div class="text-[10px] font-bold text-slate-800 uppercase leading-none">Admin</div>
                    <div class="text-[10px] font-bold text-emerald-500 uppercase leading-none mt-1">En ligne</div>
                </div>
                <div class="w-10 h-10 bg-slate-900 rounded-xl flex items-center justify-center text-white font-bold border-2 border-slate-200">
                    <i class="fas fa-user-shield text-xs"></i>
                </div>
            </div>
        </header>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-[1.5rem] border border-gray-100 shadow-sm">
                    <div class="text-[10px] font-bold text-slate-300 uppercase tracking-widest mb-2">Utilisateurs</div>
                    <div class="text-4xl font-bold text-slate-800 mb-3">{{ $users->count() }}</div>
                    <span class="bg-emerald-50 text-emerald-600 text-[10px] px-2 py-1 rounded font-bold">Total</span>
                </div>

                <div class="bg-white p-6 rounded-[1.5rem] border border-gray-100 shadow-sm">
                    <div class="text-[10px] font-bold text-slate-300 uppercase tracking-widest mb-2">Colocations</div>
                    <div class="text-4xl font-bold text-slate-800 mb-3">{{ $colocations->count() }}</div>
                    <span class="bg-indigo-50 text-indigo-600 text-[10px] px-2 py-1 rounded font-bold">Actives</span>
                </div>

                <div class="bg-white p-6 rounded-[1.5rem] border border-gray-100 shadow-sm">
                    <div class="text-[10px] font-bold text-slate-300 uppercase tracking-widest mb-2">Dépenses</div>
                    <div class="text-4xl font-bold text-slate-800 mb-3">{{ $expenses->sum('amount') }}</div>
                    <span class="bg-blue-50 text-blue-600 text-[10px] px-2 py-1 rounded font-bold">Total cumulé</span>
                </div>

                <div class="bg-white p-6 rounded-[1.5rem] border border-gray-100 shadow-sm">
                    <div class="text-[10px] font-bold text-slate-300 uppercase tracking-widest mb-2">Bannis</div>
                    <div class="text-4xl font-bold text-rose-500 mb-3">{{ $users->where('is_banned', true)->count() }}</div>
                    <span class="bg-rose-50 text-rose-500 text-[10px] px-2 py-1 rounded font-bold">À surveiller</span>
                </div>
            </div>

            <div class="bg-white rounded-[1.5rem] border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 flex justify-between items-center">
                    <h2 class="font-bold text-slate-800 text-lg">Gestion des Utilisateurs</h2>
                    
                    <div class="flex gap-2">
                        <form method="GET" action="{{ route('admin.dashboard') }}">
                            <input type="text" name="search" placeholder="Rechercher un email..." value="{{ request('search') }}" class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 w-64">
                            <button type="submit" class="bg-[#0F172A] text-white p-2 rounded-lg w-10 h-10 flex items-center justify-center">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="px-6 pb-6">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] uppercase text-slate-300 font-bold border-b border-gray-50">
                                <th class="pb-4 font-black">ID</th>
                                <th class="pb-4 font-black">Utilisateur</th>
                                <th class="pb-4 font-black">Email</th>
                                <th class="pb-4 font-black text-center">Réputation</th>
                                <th class="pb-4 font-black text-center">Statut</th>
                                <th class="pb-4 text-right font-black">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($users as $user)
                            <tr class="group hover:bg-gray-50/50 transition-colors">
                                <td class="py-6 text-xs text-slate-300 font-medium">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="py-6 font-bold text-slate-700">{{ $user->name }}</td>
                                <td class="py-6 text-sm text-slate-400 italic">{{ $user->email }}</td>
                                <td class="py-6 text-center">
                                    <span class="text-emerald-500 font-bold text-sm">{{ $user->reputation }} pts</span>
                                </td>
                                <td class="py-6">
                                    <div class="flex items-center justify-center gap-2">
                                        <div class="w-2 h-2 rounded-full {{ $user->is_banned ? 'bg-rose-500' : 'bg-emerald-500' }}"></div>
                                        <span class="{{ $user->is_banned ? 'text-rose-500' : 'text-emerald-500' }} font-bold text-xs italic">{{ $user->is_banned ? 'Banni' : 'Actif' }}</span>
                                    </div>
                                </td>
                                <td class="py-6 text-right">
                                    @if(auth()->user()->id !== $user->id)
                                        <form method="POST" action="{{ $user->is_banned ? route('admin.unban', $user->id) : route('admin.ban', $user->id) }}">
                                            @csrf
                                            <button type="submit" class="bg-gray-100 text-slate-400 text-[10px] font-black uppercase px-4 py-1.5 rounded-md hover:bg-gray-200 transition-all">
                                                {{ $user->is_banned ? 'Débannir' : 'Bannir' }}
                                            </button>
                                        </form>
                                    @else
                                        <button class="bg-gray-100 text-slate-400 text-[10px] font-black uppercase px-4 py-1.5 rounded-md">Protégé</button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="mt-6 pt-6 border-t border-gray-50">
                        <div class="text-[10px] font-black text-slate-300 uppercase">
                            Affichage de {{ $users->count() }} utilisateurs
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

</body>
</html>