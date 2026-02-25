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
            <aside class="w-64 bg-white border-r border-gray-100 flex flex-col p-6 fixed h-full z-20">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-10">
                        <div class="bg-indigo-600 p-1.5 rounded-lg text-white">
                            <i class="fas fa-home text-sm"></i>
                        </div>
                        <span class="text-xl font-bold text-indigo-900 tracking-tight">EasyColoc</span>
                    </div>

                    <nav class="space-y-1">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-400 hover:bg-gray-50' }} rounded-xl font-medium transition-all">
                            <i class="fas fa-th-large w-5"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('colocations') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('colocations.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-400 hover:bg-gray-50' }} rounded-xl font-medium transition-all">
                            <i class="fas fa-users w-5"></i>
                            <span>Colocations</span>
                        </a>
                        
                        <div class="text-[10px] font-bold text-gray-300 uppercase tracking-widest px-4 mt-8 mb-2">Admin</div>
                        
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('profile.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-400 hover:bg-gray-50' }} rounded-xl font-medium transition-all">
                            <i class="fas fa-user-circle w-5"></i>
                            <span>Profile</span>
                        </a>
                    </nav>
                </div>

                <div class="space-y-4">
                    <!-- <div class="bg-[#0F172A] rounded-2xl p-5 text-white shadow-lg shadow-slate-200">
                        <div class="text-[9px] uppercase text-slate-400 font-bold mb-1 tracking-wider">Votre réputation</div>
                        <div class="text-lg font-bold mb-3">+{{-- Auth::user()->reputation ?? 0 --}} points</div>
                        <div class="w-full bg-slate-800 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-emerald-500 h-full w-1/4"></div>
                        </div>
                    </div> -->

                    <div class="pt-2 border-t border-gray-50">
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
                <div class="max-w-7xl mx-auto px-8 h-20 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <div class="bg-indigo-600 p-1.5 rounded-lg text-white">
                            <i class="fas fa-home text-sm"></i>
                        </div>
                        <span class="text-xl font-bold text-indigo-900 tracking-tight">EasyColoc</span>
                    </div>
                    <div class="flex items-center gap-6">
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-400 hover:text-indigo-600 transition-colors">Connexion</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all">
                            S'inscrire
                        </a>
                    </div>
                </div>
            </nav>
        @endauth

        <main class="flex-1 {{ Auth::check() ? 'ml-64' : 'pt-20' }}">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>