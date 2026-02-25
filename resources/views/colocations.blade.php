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
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-gray-50 rounded-xl font-medium transition-all">
                        <i class="fas fa-th-large w-5"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 bg-indigo-50 text-indigo-700 rounded-xl font-medium transition-all">
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
                    <h1 class="text-lg font-black text-slate-800 uppercase italic tracking-widest">Mes Colocations</h1>
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

            <div class="p-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <div class="bg-white rounded-[2rem] border border-indigo-100 shadow-sm p-6 relative group hover:shadow-md transition-all">
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-indigo-100">C</div>
                        <div class="flex flex-col items-end gap-2">
                            <span class="bg-orange-500 text-white text-[9px] font-black px-3 py-1 rounded-full uppercase flex items-center gap-1">
                                <i class="fas fa-crown text-[8px]"></i> Owner
                            </span>
                            <span class="text-emerald-500 text-[10px] font-black uppercase tracking-widest">Active</span>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-1">coloc 3</h3>
                    <p class="text-indigo-400 text-xs font-bold uppercase mb-8">1 Membres</p>
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-[10px] text-gray-300 font-bold uppercase tracking-tighter">Dépenses</p>
                            <p class="text-indigo-600 font-black text-lg">0</p>
                        </div>
                        <button class="w-8 h-8 bg-indigo-50 text-indigo-400 rounded-full flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-colors">
                            <i class="fas fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-6 relative opacity-80">
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-12 h-12 bg-indigo-500 rounded-2xl flex items-center justify-center text-white font-bold text-xl">C</div>
                        <div class="flex flex-col items-end gap-2">
                            <span class="bg-orange-500 text-white text-[9px] font-black px-3 py-1 rounded-full uppercase flex items-center gap-1">
                                <i class="fas fa-crown text-[8px]"></i> Owner
                            </span>
                            <span class="text-gray-300 text-[10px] font-black uppercase tracking-widest">Cancelled</span>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-1">coloc 2</h3>
                    <p class="text-indigo-400 text-xs font-bold uppercase mb-8">2 Membres</p>
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-[10px] text-gray-300 font-bold uppercase tracking-tighter">Dépenses</p>
                            <p class="text-indigo-600 font-black text-lg">1</p>
                        </div>
                        <button class="w-8 h-8 bg-indigo-50 text-indigo-400 rounded-full flex items-center justify-center">
                            <i class="fas fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <div class="bg-gray-50/50 rounded-[2rem] border border-gray-100 p-6 relative opacity-60 grayscale-[0.5]">
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-12 h-12 bg-slate-200 rounded-2xl flex items-center justify-center text-white font-bold text-xl">C</div>
                        <div class="flex flex-col items-end gap-2">
                            <span class="bg-slate-400 text-white text-[9px] font-black px-3 py-1 rounded-full uppercase flex items-center gap-1">
                                <i class="fas fa-door-open text-[8px]"></i> Quittée
                            </span>
                            <span class="text-gray-300 text-[10px] font-black uppercase tracking-widest">Cancelled</span>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-slate-300 mb-1">coloc 1</h3>
                    <p class="text-slate-300 text-xs font-bold uppercase mb-8">1 Membres</p>
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-[10px] text-gray-200 font-bold uppercase tracking-tighter">Dépenses</p>
                            <p class="text-slate-300 font-black text-lg">2</p>
                        </div>
                        <button class="w-8 h-8 bg-gray-100 text-gray-300 rounded-full flex items-center justify-center cursor-not-allowed">
                            <i class="fas fa-eye text-xs"></i>
                        </button>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>