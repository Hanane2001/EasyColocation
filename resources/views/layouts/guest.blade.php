<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'EasyColoc' }} - Gestion de colocation</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-indigo-50 via-white to-blue-50">
        <!-- Logo et lien retour -->
        <div class="w-full sm:max-w-md mb-6 px-4">
            <a href="/" class="flex items-center space-x-2 text-indigo-600 hover:text-indigo-700 transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
                <span class="text-sm font-medium">Retour à l'accueil</span>
            </a>
        </div>
        
        <!-- Logo et nom de l'application -->
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center justify-center space-x-2">
                <div class="bg-gradient-to-r from-indigo-600 to-blue-600 p-3 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
                <span class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-blue-600 bg-clip-text text-transparent">EasyColoc</span>
            </a>
            <p class="text-gray-500 text-sm mt-2">Gérez votre colocation en toute simplicité</p>
        </div>
        <div class="w-full sm:max-w-md px-6 py-8 bg-white/80 backdrop-blur-lg shadow-xl rounded-2xl border border-gray-100">
            {{ $slot }}
        </div>
        
        <!-- Footer -->
        <p class="text-center text-gray-400 text-xs mt-8">
            &copy; {{ date('Y') }} EasyColoc. Tous droits réservés.
        </p>
    </div>

    <!-- Scripts supplémentaires -->
    @isset($scripts)
        {{ $scripts }}
    @endisset
</body>
</html>