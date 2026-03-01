<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'EasyColoc') - Gestion de colocation</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    @stack('styles')
</head>
<body class="bg-[#F8FAFC] font-sans antialiased text-slate-700">

    <div class="flex min-h-screen">
        @auth
            <aside class="w-64 bg-white border-r border-gray-100 flex flex-col p-6 fixed inset-y-0 left-0 z-20">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-10">
                        <a href="{{ url('/') }}" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                            <div class="bg-indigo-600 p-1.5 rounded-lg text-white">
                                <i class="fas fa-home text-sm"></i>
                            </div>
                            <span class="text-xl font-bold text-indigo-900 tracking-tight">EasyColoc</span>
                        </a>
                    </div>

                    <nav class="space-y-1">
                        <a href="{{ url('/') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->is('/') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-400 hover:bg-gray-50 hover:text-gray-600' }} rounded-xl font-medium transition-all">
                            <i class="fas fa-home w-5"></i>
                            <span>Accueil</span>
                        </a>

                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-400 hover:bg-gray-50 hover:text-gray-600' }} rounded-xl font-medium transition-all">
                            <i class="fas fa-th-large w-5"></i>
                            <span>Dashboard</span>
                        </a>
                        
                        <a href="{{ route('colocations.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('colocations.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-400 hover:bg-gray-50 hover:text-gray-600' }} rounded-xl font-medium transition-all">
                            <i class="fas fa-users w-5"></i>
                            <span>Colocations</span>
                        </a>

                        @if(auth()->user() && auth()->user()->role === 'admin')
                            <div class="text-[10px] font-bold text-gray-300 uppercase tracking-widest px-4 mt-8 mb-2">Administration</div>
                            
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-400 hover:bg-gray-50 hover:text-gray-600' }} rounded-xl font-medium transition-all">
                                <i class="fas fa-shield-alt w-5"></i>
                                <span>Panel Admin</span>
                            </a>
                        @endif
                        
                        <div class="text-[10px] font-bold text-gray-300 uppercase tracking-widest px-4 mt-8 mb-2">Compte</div>
                        
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('profile.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-400 hover:bg-gray-50 hover:text-gray-600' }} rounded-xl font-medium transition-all">
                            <i class="fas fa-user-circle w-5"></i>
                            <span>Profil</span>
                        </a>
                    </nav>
                </div>

                <div class="space-y-4">
                    @php
                        $userReputation = auth()->user()->reputation ?? 0;
                        $reputationPercent = min(max(($userReputation + 10) * 5, 0), 100);
                        $reputationColor = $userReputation >= 0 ? 'bg-emerald-500' : 'bg-rose-500';
                    @endphp
                    
                    <div class="bg-[#0F172A] rounded-2xl p-5 text-white shadow-lg shadow-slate-200">
                        <div class="text-[9px] uppercase text-slate-400 font-bold mb-1 tracking-wider">Votre réputation</div>
                        <div class="text-lg font-bold mb-3">{{ $userReputation }} points</div>
                        <div class="w-full bg-slate-800 h-1.5 rounded-full overflow-hidden">
                            <div class="{{ $reputationColor }} h-full" style="width: {{ $reputationPercent }}%"></div>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-gray-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-rose-400 hover:bg-rose-50 hover:text-rose-600 rounded-xl font-bold transition-all group">
                                <i class="fas fa-sign-out-alt w-5 transition-transform group-hover:-translate-x-1"></i>
                                <span>Déconnexion</span>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>
        @else
            <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 fixed w-full z-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex justify-between items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                        <div class="bg-indigo-600 p-1.5 rounded-lg text-white">
                            <i class="fas fa-home text-sm"></i>
                        </div>
                        <span class="text-xl font-bold text-indigo-900 tracking-tight">EasyColoc</span>
                    </a>

                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" 
                           class="text-sm font-bold text-slate-400 hover:text-indigo-600 transition-colors px-3 py-2">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" 
                           class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 hover:shadow-xl transition-all">
                            S'inscrire
                        </a>
                    </div>
                </div>
            </nav>
            <div class="h-20"></div>
        @endauth

        <main class="flex-1 {{ Auth::check() ? 'ml-64' : '' }}">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>