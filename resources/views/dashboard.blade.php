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
        <aside class="w-64 bg-white border-r border-gray-100 flex flex-col p-6 fixed h-full">
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-10">
                    <div class="bg-indigo-600 p-1.5 rounded-lg text-white">
                        <i class="fas fa-home text-sm"></i>
                    </div>
                    <span class="text-xl font-bold text-indigo-900 tracking-tight">EasyColoc</span>
                </div>

                <nav class="space-y-1">
                    <a href="#" class="flex items-center gap-3 px-4 py-3 bg-indigo-50 text-indigo-700 rounded-xl font-medium transition-all">
                        <i class="fas fa-th-large w-5"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-gray-50 rounded-xl font-medium transition-all">
                        <i class="fas fa-users w-5"></i>
                        <span>Colocations</span>
                    </a>
                    
                    <div class="text-[10px] font-bold text-gray-300 uppercase tracking-widest px-4 mt-8 mb-2">Admin</div>
                    
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-gray-50 rounded-xl font-medium transition-all">
                        <i class="fas fa-user-circle w-5"></i>
                        <span>Profile</span>
                    </a>
                </nav>
            </div>

            <div class="space-y-4">
                <div class="bg-[#0F172A] rounded-2xl p-5 text-white shadow-lg shadow-slate-200">
                    <div class="text-[9px] uppercase text-slate-400 font-bold mb-1 tracking-wider">Votre réputation</div>
                    <div class="text-lg font-bold mb-3">+0 points</div>
                    <div class="w-full bg-slate-800 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full w-1/4"></div>
                    </div>
                </div>

                <div class="pt-2 border-t border-gray-50">
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-rose-400 hover:bg-rose-50 hover:text-rose-600 rounded-xl font-bold transition-all group">
                        <i class="fas fa-sign-out-alt w-5 transition-transform group-hover:-translate-x-1"></i>
                        <span>Déconnexion</span>
                    </a>
                </div>
            </div>
        </aside>

        <main class="flex-1 ml-64">
            <header class="bg-white border-b border-gray-100 px-8 py-4 flex justify-between items-center sticky top-0 z-10">
                <div class="flex items-center gap-6">
                    <h1 class="text-lg font-black text-slate-800 uppercase italic tracking-widest">Residence "Coloc 3"</h1>
                    <button class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 shadow-lg shadow-indigo-100">
                        <i class="fas fa-plus text-xs"></i>
                        Nouvelle colocation
                    </button>
                </div>
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <div class="text-[10px] font-bold text-emerald-500 uppercase leading-none">User 2</div>
                        <div class="text-[10px] font-bold text-gray-300 uppercase leading-none mt-1">En ligne</div>
                    </div>
                    <div class="w-10 h-10 bg-[#0F172A] rounded-xl flex items-center justify-center text-white font-bold">U</div>
                </div>
            </header>

            <div class="p-8 space-y-8">
                <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4 flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 ml-2"></div>
                    <span class="text-emerald-700 text-sm font-bold">Categorie ajoutee.</span>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-[2.5rem] border border-gray-50 shadow-sm">
                        <div class="bg-emerald-50 text-emerald-500 w-10 h-10 rounded-xl flex items-center justify-center mb-4">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="text-gray-400 text-sm font-medium">Mon score réputation</div>
                        <div class="text-4xl font-bold text-slate-800">0</div>
                    </div>
                    <div class="bg-white p-6 rounded-[2.5rem] border border-gray-50 shadow-sm">
                        <div class="bg-indigo-50 text-indigo-500 w-10 h-10 rounded-xl flex items-center justify-center mb-4">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="text-gray-400 text-sm font-medium">Dépenses Globales (Feb)</div>
                        <div class="text-4xl font-bold text-slate-800">389,00 €</div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-8">
                    <div class="col-span-2 bg-white rounded-[2.5rem] border border-gray-50 shadow-sm overflow-hidden">
                        <div class="p-8 flex justify-between items-center">
                            <h2 class="font-bold text-slate-800 text-lg">Dépenses récentes</h2>
                            <a href="#" class="text-indigo-600 text-xs font-bold hover:underline">Voir tout</a>
                        </div>
                        <div class="px-8 pb-8">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-[10px] uppercase text-gray-300 font-bold border-b border-gray-50">
                                        <th class="pb-4">Titre / Catégorie</th>
                                        <th class="pb-4 text-center">Payeur</th>
                                        <th class="pb-4 text-center">Montant</th>
                                        <th class="pb-4 text-right">Coloc</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    <tr class="group">
                                        <td class="py-5">
                                            <div class="font-bold text-slate-700">facture wifi</div>
                                            <div class="text-[10px] text-gray-300 bg-gray-50 px-2 py-0.5 rounded w-fit mt-1">Internet</div>
                                        </td>
                                        <td class="py-5 text-center">
                                            <span class="bg-indigo-50 text-indigo-600 text-[10px] font-bold w-6 h-6 inline-flex items-center justify-center rounded-full">A</span>
                                        </td>
                                        <td class="py-5 text-center font-bold text-slate-700">90,00 €</td>
                                        <td class="py-5 text-right text-xs text-gray-300">coloc 1</td>
                                    </tr>
                                    <tr class="group">
                                        <td class="py-5">
                                            <div class="font-bold text-slate-700">facture electricité</div>
                                            <div class="text-[10px] text-gray-300 bg-gray-50 px-2 py-0.5 rounded w-fit mt-1">Electricite</div>
                                        </td>
                                        <td class="py-5 text-center">
                                            <span class="bg-indigo-50 text-indigo-600 text-[10px] font-bold w-6 h-6 inline-flex items-center justify-center rounded-full">U</span>
                                        </td>
                                        <td class="py-5 text-center font-bold text-slate-700">50,00 €</td>
                                        <td class="py-5 text-right text-xs text-gray-300">coloc 1</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-[#0F172A] rounded-[2rem] p-6 text-white">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="font-bold text-sm tracking-tight">Membres de la coloc</h3>
                                <span class="bg-slate-800 text-[9px] px-2 py-1 rounded text-gray-400 font-bold uppercase">Actifs</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-400">user 2 (Owner)</span>
                                <span class="text-emerald-500 font-bold">0</span>
                            </div>
                        </div>

                        <div class="bg-white rounded-[2rem] border border-gray-50 shadow-sm p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="font-bold text-slate-800 text-sm">Catégories</h3>
                                <button class="bg-indigo-600 text-white text-[10px] px-3 py-1.5 rounded-lg font-bold flex items-center gap-1">
                                    <i class="fas fa-plus text-[8px]"></i> Ajouter
                                </button>
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl group hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-tag text-indigo-300 text-xs"></i>
                                        <span class="text-sm font-bold text-slate-600">Courses</span>
                                    </div>
                                    <button class="text-rose-400 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl group hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-tag text-indigo-300 text-xs"></i>
                                        <span class="text-sm font-bold text-slate-600">Electricite</span>
                                    </div>
                                    <button class="text-rose-400 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>