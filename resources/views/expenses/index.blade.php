@extends('layouts.app')

@section('content')
<div class="p-8">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-slate-800">
            Dépenses de {{ $colocation->name }}
        </h2>

        <a href="{{ route('expenses.create', $colocation) }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold">
            + Ajouter
        </a>
    </div>
    @if(session('success'))
        <div class="bg-emerald-100 text-emerald-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- FILTER --}}
    <form method="GET" class="mb-6 flex gap-4 items-end">
        <div>
            <label class="block text-sm font-bold mb-1">Filtrer par mois</label>
            <input type="month" name="month"
                   value="{{ request('month') }}"
                   class="border rounded-lg p-2">
        </div>

        <button type="submit"
                class="bg-gray-800 text-white px-4 py-2 rounded-lg">
            Filtrer
        </button>

        <a href="{{ route('expenses.index', $colocation) }}"
           class="px-4 py-2 bg-gray-200 rounded-lg">
            Reset
        </a>
    </form>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-sm uppercase text-gray-500">
                <tr>
                    <th class="p-4">Titre</th>
                    <th class="p-4">Montant</th>
                    <th class="p-4">Date</th>
                    <th class="p-4">Catégorie</th>
                    <th class="p-4">Payeur</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $expense)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-4 font-semibold">{{ $expense->title }}</td>
                        <td class="p-4 text-indigo-600 font-bold">
                            {{ number_format($expense->amount, 2) }} €
                        </td>
                        <td class="p-4">
                            {{ $expense->expense_date->format('d/m/Y') }}
                        </td>
                        <td class="p-4">
                            {{ $expense->category->name ?? '—' }}
                        </td>
                        <td class="p-4">
                            {{ $expense->user->name }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-gray-400">
                            Aucune dépense trouvée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- STATISTIQUES --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">

        <div class="bg-white p-6 rounded-2xl shadow">
            <h3 class="font-bold text-lg mb-4">Statistiques par catégorie</h3>
            <ul class="space-y-2">
                @foreach($statsByCategory as $stat)
                    <li class="flex justify-between">
                        <span>{{ $stat->category->name ?? '—' }}</span>
                        <span class="font-bold text-indigo-600">
                            {{ number_format($stat->total, 2) }} €
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow">
            <h3 class="font-bold text-lg mb-4">Statistiques mensuelles</h3>
            <ul class="space-y-2">
                @foreach($statsByMonth as $stat)
                    <li class="flex justify-between">
                        <span>Mois {{ $stat->month }}</span>
                        <span class="font-bold text-indigo-600">
                            {{ number_format($stat->total, 2) }} €
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>

</div>
@endsection