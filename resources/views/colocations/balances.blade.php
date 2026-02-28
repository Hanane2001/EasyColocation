@extends('layouts.app')

@section('content')
<div class="p-6 max-w-6xl mx-auto">

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Balances</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $colocation->name }}</p>
        </div>
        <a href="{{ route('colocations.show', $colocation) }}" 
           class="text-indigo-600 hover:text-indigo-700 text-sm font-medium flex items-center gap-1">
            <i class="fas fa-arrow-left text-xs"></i>
            Retour à la colocation
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-6 py-4 text-left">Membre</th>
                        <th class="px-6 py-4 text-left">Total payé</th>
                        <th class="px-6 py-4 text-left">Part individuelle</th>
                        <th class="px-6 py-4 text-left">Solde</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($balances as $b)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center font-bold text-xs">
                                        {{ strtoupper(substr($b['user']->name, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-slate-700">{{ $b['user']->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono">{{ number_format($b['paid'], 2) }} DH</td>
                            <td class="px-6 py-4 font-mono">{{ number_format($b['share'], 2) }} DH</td>
                            <td class="px-6 py-4">
                                @if($b['balance'] > 0)
                                    <span class="inline-flex items-center gap-1 text-emerald-600 font-medium">
                                        <i class="fas fa-arrow-up text-xs"></i>
                                        +{{ number_format($b['balance'], 2) }} DH
                                    </span>
                                @elseif($b['balance'] < 0)
                                    <span class="inline-flex items-center gap-1 text-rose-600 font-medium">
                                        <i class="fas fa-arrow-down text-xs"></i>
                                        {{ number_format($b['balance'], 2) }} DH
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm">Équilibré</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fas fa-exchange-alt text-indigo-500 text-sm"></i>
            Remboursements
        </h2>

        @forelse($transactions as $t)
            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100 last:border-0 gap-3">
                <div class="flex items-center gap-2 text-sm">
                    <span class="font-medium text-rose-600">{{ $t['from'] }}</span>
                    <i class="fas fa-arrow-right text-gray-400 text-xs"></i>
                    <span class="font-medium text-emerald-600">{{ $t['to'] }}</span>
                </div>
                
                <div class="flex items-center gap-4">
                    <span class="font-mono font-bold text-slate-700">{{ number_format($t['amount'], 2) }} DH</span>
                    
                    <form method="POST" action="{{ route('payments.markPaid', $colocation) }}" class="inline">
                        @csrf
                        <input type="hidden" name="payer_id" value="{{ $t['from_id'] }}">
                        <input type="hidden" name="receiver_id" value="{{ $t['to_id'] }}">
                        <input type="hidden" name="amount" value="{{ $t['amount'] }}">
                        <button type="submit" 
                                class="bg-emerald-50 hover:bg-emerald-100 text-emerald-600 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors flex items-center gap-1">
                            <i class="fas fa-check"></i>
                            Marquer payé
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <div class="text-gray-300 text-4xl mb-3">🎉</div>
                <p class="text-gray-500">Tous les comptes sont équilibrés !</p>
            </div>
        @endforelse
    </div>

    @if(!empty($transactions))
        <p class="text-xs text-gray-400 mt-4 text-center">
            <i class="fas fa-info-circle mr-1"></i>
            Cliquez sur "Marquer payé" une fois le remboursement effectué
        </p>
    @endif

</div>
@endsection