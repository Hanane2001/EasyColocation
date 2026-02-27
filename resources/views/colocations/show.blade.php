@extends('layouts.app')

@section('content')

<div class="p-8">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold">
            {{ $colocation->name }}
        </h1>

        <p class="text-sm text-gray-400">
            Owner: {{ $colocation->owner->name }}
        </p>

        <p class="text-sm font-bold mt-2">
            Total Dépenses: 
            <span class="text-indigo-600">
                {{ $expensesSum }} DH
            </span>
        </p>
    </div>

    <!-- Actions -->
    <div class="mb-6 flex gap-4">

        {{-- Leave --}}
        @if($colocation->owner_id !== auth()->id())
            <form method="POST" action="{{ route('colocations.leave', $colocation) }}">
                @csrf
                <button class="bg-rose-500 text-white px-4 py-2 rounded">
                    Quitter
                </button>
            </form>
        @endif

        {{-- Cancel --}}
        @if($colocation->owner_id === auth()->id())
            <form method="POST" action="{{ route('colocations.cancel', $colocation) }}">
                @csrf
                <button class="bg-gray-800 text-white px-4 py-2 rounded">
                    Annuler colocation
                </button>
            </form>
        @endif

    </div>

    <!-- Members -->
    <div class="mb-10">
        <h2 class="font-bold mb-4">Membres actifs</h2>

        <ul class="space-y-2">
            @foreach($colocation->users as $member)
                <li class="flex justify-between bg-white p-3 rounded shadow-sm">

                    <span>
                        {{ $member->name }}
                        @if($member->id === $colocation->owner_id)
                            <span class="text-xs text-orange-500">(Owner)</span>
                        @endif
                    </span>

                    <span class="text-xs text-gray-400">
                        Joined: {{ $member->pivot->joined_at }}
                    </span>

                </li>
            @endforeach
        </ul>
    </div>

    <!-- Expenses -->
    <div>
        <h2 class="font-bold mb-4">Dépenses</h2>

        @forelse($colocation->expenses as $expense)
            <div class="bg-white p-4 rounded shadow-sm mb-2 flex justify-between">

                <div>
                    <p class="font-bold">{{ $expense->title }}</p>
                    <p class="text-xs text-gray-400">
                        ajouté par {{ $expense->user->name ?? '' }}
                    </p>
                </div>

                <div class="font-bold text-indigo-600">
                    {{ $expense->amount }} DH
                </div>

            </div>
        @empty
            <p class="text-gray-400">Aucune dépense</p>
        @endforelse
    </div>

</div>

@endsection