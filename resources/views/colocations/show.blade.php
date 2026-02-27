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

        <p class="text-xs mt-1 font-bold {{ $colocation->statusColocation === 'active' ? 'text-emerald-500' : 'text-gray-400' }}">
            Status: {{ ucfirst($colocation->statusColocation) }}
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
            <li class="flex justify-between bg-white p-3 rounded shadow-sm items-center">
                <div>
                    {{ $member->name }}
                    <span class="text-xs text-indigo-500 ml-2">
                        ({{-- $member->reputation --}} pts)
                    </span>
                    @if($member->id === $colocation->owner_id)
                        <span class="text-xs text-orange-500">(Owner)</span>
                    @endif
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-400">
                        Joined: {{ $member->pivot->joined_at }}
                    </span>

                    @if($colocation->owner_id === auth()->id() && $member->id !== auth()->id())
                        <form action="{{ route('colocations.kick', [$colocation, $member]) }}" method="POST">
                            @csrf
                            <button class="bg-rose-500 text-white px-2 py-1 rounded text-xs hover:bg-rose-600">
                                Retirer
                            </button>
                        </form>
                    @endif
                </div>
            </li>
        @endforeach
        </ul>
    </div>

    @if($colocation->owner_id === auth()->id())
        <div class="mb-8">
            <h2 class="font-bold mb-3">Inviter un membre</h2>

            <form method="POST" action="{{ route('invitations.store', $colocation) }}" class="flex gap-2">
                @csrf
                <input type="email" name="email" required placeholder="Email"
                    class="border p-2 rounded w-64">
                <button class="bg-indigo-600 text-white px-4 py-2 rounded">
                    Envoyer
                </button>
            </form>
        </div>
    @endif
    <form method="POST" action="{{ route('invitations.generateToken', $colocation) }}">
        @csrf
        <button class="bg-indigo-600 text-white px-3 py-1 rounded text-sm">
            Générer lien public
        </button>
    </form>

    @if(session('token_link'))
        <div class="mt-3 bg-gray-100 p-2 rounded text-sm">
            {{ session('token_link') }}
        </div>
    @endif

    <!-- Categories -->
    @if($colocation->owner_id === auth()->id())
    <div class="mb-10">
        <h2 class="font-bold mb-4">Catégories</h2>

        <form method="POST" 
            action="{{ route('categories.store', $colocation) }}"
            class="flex gap-2 mb-4">
            @csrf
            <input type="text" name="name" required
                placeholder="Nouvelle catégorie"
                class="border p-2 rounded w-64">
            <button class="bg-indigo-600 text-white px-4 py-2 rounded">
                Ajouter
            </button>
        </form>

        <ul class="space-y-2">
            @foreach($colocation->categories as $category)
                <li class="flex justify-between bg-white p-2 rounded shadow-sm">
                    {{ $category->name }}

                    <form method="POST"
                        action="{{ route('categories.destroy', [$colocation, $category]) }}">
                        @csrf
                        @method('DELETE')
                        <button class="text-rose-500 text-xs">
                            Supprimer
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Expenses -->
        <div class="mt-10">

            <div class="flex justify-between items-center mb-4">
                <h2 class="font-bold text-lg">Dépenses</h2>

                <a href="{{ route('expenses.index', $colocation) }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">
                    Voir toutes les dépenses
                </a>
            </div>

            <a href="{{ route('colocations.balances', $colocation) }}"
            class="bg-emerald-600 text-white px-4 py-2 rounded text-sm">
            Voir les balances
            </a>

        </div>

</div>

@endsection