@extends('layouts.app')

@section('content')

<div class="p-8">

    <h1 class="text-2xl font-bold mb-6">
        Balances - {{ $colocation->name }}
    </h1>
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-sm uppercase text-gray-500">
                <tr>
                    <th class="p-4">Membre</th>
                    <th class="p-4">Total payé</th>
                    <th class="p-4">Part individuelle</th>
                    <th class="p-4">Solde</th>
                </tr>
            </thead>
            <tbody>
                @foreach($balances as $b)
                    <tr class="border-t">
                        <td class="p-4 font-semibold">
                            {{ $b['user']->name }}
                        </td>

                        <td class="p-4">
                            {{ number_format($b['paid'],2) }} DH
                        </td>

                        <td class="p-4">
                            {{ number_format($b['share'],2) }} DH
                        </td>

                        <td class="p-4 font-bold">
                            @if($b['balance'] > 0)
                                <span class="text-emerald-600">
                                    Reçoit {{ number_format($b['balance'],2) }} DH
                                </span>
                            @elseif($b['balance'] < 0)
                                <span class="text-rose-600">
                                    Doit {{ number_format(abs($b['balance']),2) }} DH
                                </span>
                            @else
                                <span class="text-gray-400">
                                    Équilibré
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-10 bg-white p-6 rounded-2xl shadow">
        <h2 class="font-bold text-lg mb-4">
            Qui doit à qui ?
        </h2>

        @forelse($transactions as $t)
            <div class="flex justify-between border-b py-2">
                <span class="text-rose-600 font-semibold">
                    {{ $t['from'] }}
                </span>

                <span>
                    doit
                    <span class="font-bold">
                        {{ number_format($t['amount'],2) }} DH
                    </span>
                    à
                    <span class="text-emerald-600 font-semibold">
                        {{ $t['to'] }}
                    </span>
                </span>
            </div>
        @empty
            <p class="text-gray-400">
                Aucun remboursement nécessaire 🎉
            </p>
        @endforelse
    </div>

</div>

@endsection