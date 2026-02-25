@extends('layouts.app')

@section('title', 'Créer une colocation')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-3xl shadow-md border border-gray-200">

    <h1 class="text-2xl font-bold mb-6">Créer une nouvelle colocation</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('colocations.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="block font-semibold mb-2">Nom de la colocation</label>
            <input type="text" name="name" id="name" placeholder="Ex: Appartement Paris"
                class="w-full border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                value="{{ old('name') }}" required>
        </div>

        <div class="flex justify-end">
            <a href="#" 
               class="mr-3 px-5 py-2 rounded-full border text-gray-700 hover:bg-gray-100 transition">
               Annuler
            </a>
            <button type="submit" 
                class="px-5 py-2 rounded-full bg-blue-500 text-white font-semibold hover:bg-blue-600 transition">
                Créer
            </button>
        </div>
    </form>
</div>
@endsection