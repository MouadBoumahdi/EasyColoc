@extends('layouts.app')

@section('title', 'Créer une colocation')

@section('content')
<div class="max-w-xl mx-auto">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest mb-6">
        <a href="#" class="hover:text-indigo-600 transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-600">Nouvelle colocation</span>
    </div>

    <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100 relative overflow-hidden">
        <div class="absolute -right-10 -top-10 opacity-[0.02] rotate-12">
            <i class="fa-solid fa-house-chimney text-[200px] text-indigo-900"></i>
        </div>

        <div class="relative">
            <h1 class="text-3xl font-bold text-slate-800 mb-2 italic uppercase">Démarrer une coloc</h1>
            <p class="text-slate-500 text-sm mb-10 leading-relaxed font-medium">Donnez un nom à votre colocation pour commencer.</p>

            @if ($errors->any())
                <div class="mb-8 p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl text-sm flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                    <ul class="list-disc pl-2 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="font-medium">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('colocations.store') }}" method="POST" class="space-y-8">
                @csrf

                <div>
                    <label for="name" class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-3 ml-1">Nom de la colocation</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-door-open text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                        </div>
                        <input type="text" name="name" id="name" placeholder="Ex: Loft Parisien"
                            class="w-full bg-slate-50 border-transparent border-2 rounded-2xl py-4 pl-12 pr-4 text-slate-700 placeholder:text-slate-300 focus:bg-white focus:border-indigo-100 focus:ring-4 focus:ring-indigo-50 transition-all outline-none font-medium"
                            value="{{ old('name') }}" required autofocus>
                    </div>
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <button type="submit" 
                        class="flex-1 bg-indigo-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-indigo-100 hover:bg-indigo-700 hover:-translate-y-0.5 transition-all">
                        Confirmer la création
                    </button>
                    <a href="#" class="px-8 py-4 bg-slate-50 text-slate-500 font-bold rounded-2xl hover:bg-slate-100 transition-all text-center">
                       Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Help text block -->
    <div class="mt-8 px-6 flex items-start gap-4 text-slate-400">
        <i class="fa-solid fa-lightbulb text-amber-400 mt-1"></i>
        <p class="text-xs leading-relaxed italic font-medium">
            En créant cette colocation, vous en devenez automatiquement le <b>Gestionnaire (Owner)</b>.
        </p>
    </div>
</div>
@endsection