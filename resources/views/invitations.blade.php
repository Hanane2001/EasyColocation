<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyColoc - Invitation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-gray-50 flex flex-col items-center justify-center min-h-screen p-4">
    <div class="flex items-center gap-2 mb-8">
        <div class="bg-indigo-600 p-1.5 rounded-lg text-white">
            <i class="fas fa-home text-sm"></i>
        </div>
        <span class="text-xl font-bold text-indigo-900 tracking-tight">EasyColoc</span>
    </div>

    <div class="w-full max-w-md bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-gray-50 p-10 flex flex-col items-center text-center">
        
        <div class="relative mb-8">
            <div class="absolute inset-0 bg-indigo-500 blur-2xl opacity-20 rounded-full"></div>
            <div class="relative bg-indigo-600 w-16 h-16 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg shadow-indigo-200">
                <i class="fas fa-envelope-open-text"></i>
            </div>
        </div>

        <h2 class="text-xl font-extrabold text-slate-800 mb-2">Invitation colocation</h2>
        <p class="text-gray-400 text-sm leading-relaxed mb-8">
            Vous êtes invité à rejoindre <br>
            <span class="text-indigo-600 font-bold">{{ $invitation->colocation->name }}</span>
        </p>

        <div class="w-full space-y-3">
            <!-- Form accepter -->
            <form action="{{ route('invitations.accept', $invitation->token) }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-2xl transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-indigo-100">
                    Accepter l'invitation
                </button>
            </form>

            <!-- Form décliner -->
            <form action="{{ route('invitations.decline', $invitation->token) }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-transparent text-gray-400 hover:text-gray-600 font-semibold py-2 text-sm transition-colors">
                    Décliner
                </button>
            </form>
        </div>
    </div>
</body>
</html>