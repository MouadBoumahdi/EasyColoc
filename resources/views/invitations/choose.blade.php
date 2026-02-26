@extends('layouts.app')

@section('title', 'Choix de Colocation')

@section('content')
<div class="flex items-center justify-center min-h-[60vh]">
    <div class="bg-white rounded-[2.5rem] w-full max-w-xl p-10 md:p-16 shadow-sm border border-slate-100 text-center relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-50 rounded-full opacity-50"></div>
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-emerald-50 rounded-full opacity-50"></div>

        <div class="relative">
            <div class="w-20 h-20 bg-indigo-600 rounded-3xl flex items-center justify-center text-white mx-auto mb-8 shadow-xl shadow-indigo-200 rotate-3">
                <i class="fa-solid fa-envelope-open-text text-3xl"></i>
            </div>

            <h1 class="text-3xl font-bold text-slate-800 mb-4 italic uppercase">Rejoindre la colocation ?</h1>
            
            <p class="text-slate-500 text-lg mb-10 leading-relaxed">
                Vous avez été invité à rejoindre la colocation :<br>
                <span class="text-2xl font-black text-slate-900 block mt-2 uppercase tracking-tight">"{{ $invitation->colocation->name }}"</span>
            </p>

            <div class="flex flex-col sm:flex-row items-center gap-4 justify-center mt-10">
                <!-- Accept Button -->
                <a href="{{ route('invitations.accept', $invitation->token) }}" 
                   class="w-full sm:w-48 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-indigo-100 transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-check"></i> Accepter
                </a>

                <!-- Refuse Button -->
                <a href="{{ route('invitations.refuse', $invitation->token) }}" 
                    class="w-full sm:w-48 bg-white border border-slate-200 text-slate-400 font-bold py-4 rounded-2xl hover:bg-rose-50 hover:text-rose-500 hover:border-rose-100 transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-xmark"></i> Refuser
                </a>
            </div>
            
            <p class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.2em] mt-12 italic">
                Connecté en tant que : {{ Auth::user()->email }}
            </p>
        </div>
    </div>
</div>
@endsection
