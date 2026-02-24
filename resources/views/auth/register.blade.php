<x-guest-layout>
    <div class="space-y-6">
        <!-- En-tête -->
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-900">Créez votre compte</h2>
            <p class="text-sm text-gray-600 mt-1">Rejoignez la communauté EasyColoc</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            <!-- Nom -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-user mr-2 text-indigo-500"></i>Nom complet
                </label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors @error('name') border-red-500 @enderror"
                    placeholder="Jean Dupont">
                @error('name')
                    <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-envelope mr-2 text-indigo-500"></i>Email
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors @error('email') border-red-500 @enderror"
                    placeholder="votre@email.com">
                @error('email')
                    <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Mot de passe -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-lock mr-2 text-indigo-500"></i>Mot de passe
                </label>
                <div class="relative">
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors @error('password') border-red-500 @enderror"
                        placeholder="••••••••">
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
                
                <!-- Indicateur de force du mot de passe -->
                <div class="mt-2">
                    <p class="text-xs text-gray-500 mt-1" id="passwordStrengthText">Minimum 8 caractères</p>
                </div>
            </div>

            <!-- Confirmation du mot de passe -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-lock mr-2 text-indigo-500"></i>Confirmer le mot de passe
                </label>
                <div class="relative">
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors"
                        placeholder="••••••••">
                </div>
            </div>

            <!-- Bouton d'inscription -->
            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-blue-600 text-white py-3 px-4 rounded-lg font-medium hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform transition-all duration-200 hover:scale-[1.02]">
                <i class="fas fa-user-plus mr-2"></i>S'inscrire
            </button>
        </form>

        <!-- Lien de connexion -->
        <p class="text-center text-sm text-gray-600">
            Déjà inscrit ?
            <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-700 hover:underline">
                Connectez-vous
            </a>
        </p>
    </div>
</x-guest-layout>