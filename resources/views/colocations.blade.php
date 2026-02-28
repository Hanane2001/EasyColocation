@extends('layouts.app')

@section('content')
<div class="p-6 max-w-7xl mx-auto">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Mes colocations</h1>
            <p class="text-sm text-gray-500 mt-1">Gérez vos colocations et suivez vos dépenses</p>
        </div>
        
        <button onclick="document.getElementById('newColocModal').classList.remove('hidden')" 
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium inline-flex items-center gap-2 transition-colors shadow-sm">
            <i class="fas fa-plus"></i>
            Nouvelle colocation
        </button>
    </div>

    @if($colocations->isEmpty())
        <div class="text-center py-12 bg-white rounded-xl border border-gray-100">
            <div class="text-gray-300 text-5xl mb-4">🏠</div>
            <h3 class="text-lg font-medium text-slate-700 mb-2">Aucune colocation pour le moment</h3>
            <p class="text-gray-500 text-sm mb-6">Créez votre première colocation ou rejoignez-en une via une invitation</p>
            <button onclick="document.getElementById('newColocModal').classList.remove('hidden')" 
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl text-sm font-medium inline-flex items-center gap-2 transition-colors">
                <i class="fas fa-plus"></i>
                Créer une colocation
            </button>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($colocations as $coloc)
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                    
                    <div class="p-5 border-b border-gray-50">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center font-bold">
                                    {{ strtoupper(substr($coloc->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h3 class="font-semibold text-slate-800">{{ $coloc->name }}</h3>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        <i class="far fa-calendar mr-1"></i>
                                        Créée le {{ $coloc->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                            
                            @if($coloc->owner_id === auth()->id())
                                <span class="bg-amber-100 text-amber-600 text-[10px] font-medium px-2 py-1 rounded-full flex items-center gap-1">
                                    <i class="fas fa-crown text-[8px]"></i>
                                    Owner
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-5">
                        <div class="flex justify-between items-center mb-4 text-sm">
                            <div class="flex items-center gap-1 text-gray-500">
                                <i class="fas fa-users text-indigo-400 text-xs"></i>
                                <span>{{ $coloc->active_users_count }} membre(s)</span>
                            </div>
                            <div class="flex items-center gap-1 text-gray-500">
                                <i class="fas fa-coins text-emerald-400 text-xs"></i>
                                <span>{{ number_format($coloc->expenses_sum ?? 0, 0) }} DH</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs text-gray-400">Statut</span>
                            @if($coloc->statusColocation === 'active')
                                <span class="text-emerald-600 text-xs font-medium bg-emerald-50 px-2 py-1 rounded-full">
                                    <i class="fas fa-circle text-[6px] mr-1"></i>
                                    Active
                                </span>
                            @else
                                <span class="text-gray-400 text-xs font-medium bg-gray-50 px-2 py-1 rounded-full">
                                    <i class="fas fa-circle text-[6px] mr-1"></i>
                                    Fermée
                                </span>
                            @endif
                        </div>

                        @if($coloc->statusColocation === 'active')
                            <a href="{{ route('colocations.show', $coloc) }}" 
                               class="mt-2 w-full bg-indigo-50 hover:bg-indigo-100 text-indigo-600 text-sm font-medium py-2.5 rounded-lg inline-flex items-center justify-center gap-2 transition-colors">
                                Voir les détails
                                <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        @else
                            <button disabled 
                                    class="mt-2 w-full bg-gray-50 text-gray-400 text-sm font-medium py-2.5 rounded-lg cursor-not-allowed">
                                Colocation fermée
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<div id="newColocModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl w-full max-w-md">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-slate-800">Nouvelle colocation</h2>
        </div>
        
        <form method="POST" action="{{ route('colocations.store') }}">
            @csrf
            <div class="p-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nom de la colocation
                </label>
                <input type="text" name="name" 
                       required 
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
            </div>
            
            <div class="p-6 bg-gray-50/50 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('newColocModal').classList.add('hidden')" 
                        class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-gray-600 text-sm font-medium hover:bg-gray-50 transition-colors">
                    Annuler
                </button>
                <button type="submit" 
                        class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 transition-colors">
                    Créer
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    window.onclick = function(event) {
        const modal = document.getElementById('newColocModal');
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection