@extends('layouts.app')

@section('title', 'EasyColoc - Gérez votre colocation simplement')

@section('content')
<div class="min-h-screen bg-white">
    <div class="relative pt-16 pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest bg-indigo-50 text-indigo-600 mb-8 italic">
                    🚀 Simplifiez votre vie commune
                </span>
                
                <h1 class="text-5xl md:text-7xl font-black text-slate-900 tracking-tighter mb-6 italic uppercase">
                    La vie en coloc' <br>
                    <span class="text-indigo-600">enfin simplifiée.</span>
                </h1>
                
                <p class="mt-6 max-w-2xl mx-auto text-lg text-slate-400 font-medium leading-relaxed">
                    Gérez vos dépenses communes, répartissez automatiquement les dettes et vivez une colocation sans stress avec notre interface moderne et intuitive.
                </p>
                @auth 
                    <div class="mt-12 flex flex-col sm:flex-row justify-center gap-4">
    
                        <a href="{{ route('dashboard') }}" 
                        class="inline-flex items-center px-8 py-4 bg-emerald-600 text-white text-lg font-bold rounded-2xl shadow-xl shadow-emerald-100 hover:bg-emerald-700 hover:-translate-y-1 transition-all">
                            Accéder à mon espace
                            <i class="fas fa-arrow-right ml-3 text-sm"></i>
                        </a>

                        <a href="{{ route('colocations') }}" 
                        class="inline-flex items-center px-8 py-4 bg-white text-slate-600 text-lg font-bold rounded-2xl border border-slate-100 hover:bg-slate-50 transition-all">
                            Voir ma colocation
                        </a>

                    </div>
                @else
                    <div class="mt-12 flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-indigo-600 text-white text-lg font-bold rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:-translate-y-1 transition-all">
                            Commencer gratuitement
                            <i class="fas fa-arrow-right ml-3 text-sm"></i>
                        </a>
                        <a href="#features" class="inline-flex items-center px-8 py-4 bg-white text-slate-600 text-lg font-bold rounded-2xl border border-slate-100 hover:bg-slate-50 transition-all">
                            Découvrir les outils
                        </a>
                    </div>
                @endauth
            </div>
        </div>

        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[1000px] bg-indigo-50/50 rounded-full blur-3xl -z-10"></div>
    </div>

    <div id="features" class="py-24 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-10 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all group">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <i class="fas fa-wallet text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-4">Gestion des dépenses</h3>
                    <p class="text-slate-400 text-sm font-medium leading-relaxed">
                        Ajoutez vos dépenses communes, catégorisez-les et suivez votre budget en temps réel avec des graphiques clairs.
                    </p>
                </div>

                <div class="bg-white p-10 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all group">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-500 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <i class="fas fa-calculator text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-4">Répartition automatique</h3>
                    <p class="text-slate-400 text-sm font-medium leading-relaxed">
                        Plus besoin de calculatrices. Nous calculons automatiquement qui doit quoi à qui pour des comptes toujours justes.
                    </p>
                </div>

                <div class="bg-white p-10 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all group">
                    <div class="w-14 h-14 bg-slate-900 text-white rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <i class="fas fa-chart-pie text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-4">Tableau de bord pro</h3>
                    <p class="text-slate-400 text-sm font-medium leading-relaxed">
                        Visualisez toutes vos statistiques et l'évolution de vos dépenses mensuelles sur une interface ultra-moderne.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection