@extends('layouts.app')

@section('title', 'EasyColoc - Gérez votre colocation simplement')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 to-indigo-700">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="text-center">
                <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                    <span class="block">EasyColoc</span>
                    <span class="block text-2xl md:text-3xl mt-3 text-blue-100">La vie en coloc' simplifiée</span>
                </h1>
                <p class="mt-6 max-w-md mx-auto text-base text-blue-100 md:max-w-3xl md:text-lg">
                    Gérez vos dépenses communes, répartissez automatiquement les dettes et vivez une colocation sans stress.
                </p>
                <div class="mt-10 flex justify-center gap-4">
                    <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-white hover:bg-gray-50 md:px-8 md:py-4 md:text-lg">
                        Commencer gratuitement
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Wave separator -->
        <div class="absolute bottom-0 w-full">
            <svg viewBox="0 0 1440 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
                <path d="M0 100L60 91.7C120 83.3 240 66.7 360 66.7C480 66.7 600 83.3 720 87.5C840 91.7 960 83.3 1080 75C1200 66.7 1320 58.3 1380 54.2L1440 50V100H1380C1320 100 1200 100 1080 100C960 100 840 100 720 100C600 100 480 100 360 100C240 100 120 100 60 100H0Z" fill="white"/>
            </svg>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Tout ce dont vous avez besoin pour votre coloc'
                </h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                    Une solution complète pour gérer votre colocation en toute sérénité
                </p>
            </div>

            <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Feature 1: Dépenses -->
                <div class="relative bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Gestion des dépenses</h3>
                    <p class="text-gray-600">
                        Ajoutez vos dépenses communes, catégorisez-les et suivez votre budget en temps réel.
                    </p>
                </div>

                <!-- Feature 2: Répartition automatique -->
                <div class="relative bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Répartition des dettes</h3>
                    <p class="text-gray-600">
                        Calculez automatiquement qui doit quoi à qui et simplifiez les remboursements.
                    </p>
                </div>

                <!-- Feature 3: Dashboard -->
                <div class="relative bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Tableau de bord</h3>
                    <p class="text-gray-600">
                        Visualisez toutes vos statistiques et l'évolution de vos dépenses mensuelles.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection