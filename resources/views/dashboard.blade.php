@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-10">
        <h1 class="text-2xl font-bold tracking-tight text-slate-800 italic uppercase">Tableau de Bord</h1>
        
        @if(!Auth::user()->hasActiveColocation())
        <div class="flex items-center gap-3">
            <a href="{{ route('colocations.create') }}" class="bg-[#4F46E5] text-white px-6 py-2.5 rounded-2xl font-bold flex items-center gap-2 shadow-lg shadow-indigo-100 hover:bg-[#4338CA] transition-all">
                <span class="text-lg">+</span> Nouvelle colocation
            </a>
            <a href="#" class="bg-white text-slate-600 border border-slate-200 px-6 py-2.5 rounded-2xl font-bold flex items-center gap-2 hover:bg-slate-50 transition-all">
                <i class="fa-solid fa-link text-sm"></i> Rejoindre une colocation
            </a>
        </div>
        @endif
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
        <!-- Reputation Card -->
        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 flex items-start justify-between relative overflow-hidden group hover:shadow-xl hover:shadow-emerald-50/50 transition-all duration-500">
            <div>
                <div class="w-12 h-12 bg-[#ECFDF5] rounded-xl flex items-center justify-center text-[#10B981] mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-star text-xl"></i>
                </div>
                <p class="text-sm font-medium text-slate-500 mb-1">Mon score réputation</p>
                <div class="text-5xl font-bold text-slate-900">150</div>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-[0.03] rotate-12">
                <i class="fa-solid fa-star text-[120px]"></i>
            </div>
        </div>

        <!-- Expenses Card -->
        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 flex items-start justify-between relative overflow-hidden group hover:shadow-xl hover:shadow-indigo-50/50 transition-all duration-500">
            <div>
                <div class="w-12 h-12 bg-[#EEF2FF] rounded-xl flex items-center justify-center text-[#4F46E5] mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-cart-shopping text-xl"></i>
                </div>
                <p class="text-sm font-medium text-slate-500 mb-1">Dépenses Globales (Feb)</p>
                <div class="text-5xl font-bold text-slate-900">145,50 €</div>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-[0.03] rotate-12">
                <i class="fa-solid fa-cart-shopping text-[120px]"></i>
            </div>
        </div>
    </div>

    <!-- Main Content Grid: Table + Side Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Expenses Table Section (2/3 width) -->
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-slate-800">Dépenses récentes</h2>
                <a href="#" class="text-indigo-600 font-bold text-sm tracking-tight hover:underline">Voir tout</a>
            </div>

            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-slate-50">
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-slate-400">Titre / Catégorie</th>
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-slate-400">Payeur</th>
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-center">Montant</th>
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-right">Coloc</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="bg-slate-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fa-solid fa-receipt text-slate-300 text-2xl"></i>
                                </div>
                                <p class="text-slate-400 font-medium italic">Aucune dépense enregistrée ce mois-ci.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sidebar Actions & Info (1/3 width) -->
        <div class="space-y-8">
            <!-- Colocation Status -->
            <div class="bg-[#1E293B] rounded-[2rem] p-8 text-white relative h-min shadow-2xl shadow-slate-200 overflow-hidden">
                @if(Auth::user()->hasActiveColocation())
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="font-bold text-lg italic">Ma Colocation</h3>
                        <span class="bg-emerald-500/20 text-emerald-400 text-[10px] font-bold px-3 py-1 rounded-md tracking-tighter uppercase border border-emerald-500/30">Active</span>
                    </div>

                    <div class="space-y-4 mb-8">
                        <!-- Static Member list for design -->
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-500 flex items-center justify-center text-[10px] font-bold">ME</div>
                            <div>
                                <p class="text-sm font-bold leading-none">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-slate-400">Propriétaire</p>
                            </div>
                        </div>
                    </div>

                    @if(Auth::user()->isColocationOwner())
                        <a href="#" class="block w-full text-center py-4 bg-indigo-600 hover:bg-indigo-700 rounded-2xl text-sm font-bold transition-all shadow-lg shadow-indigo-900/20">
                            <i class="fa-solid fa-user-plus mr-2"></i> Inviter des colocs
                        </a>
                    @endif
                @else
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="font-bold text-lg">Membres de la coloc</h3>
                        <span class="bg-indigo-500/20 text-indigo-300 text-[10px] font-bold px-3 py-1 rounded-md tracking-tighter uppercase border border-indigo-500/30 italic">En attente</span>
                    </div>
                    
                    <div class="py-4">
                        <p class="text-slate-400 text-sm leading-relaxed italic">Vous ne faites partie d'aucune colocation active pour le moment. Créez-en une ou utilisez un lien d'invitation pour rejoindre vos colocataires.</p>
                    </div>
                @endif
            </div>

            <!-- Summary of Debts Placeholder -->
            <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm group">
                <h3 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-scale-balanced text-indigo-500"></i>
                    Qui doit quoi ?
                </h3>
                <div class="space-y-4 opacity-50">
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50">
                        <div class="w-8 h-8 rounded-lg bg-slate-200"></div>
                        <div class="flex-1 h-3 bg-slate-200 rounded mx-4"></div>
                        <div class="w-12 h-3 bg-slate-200 rounded"></div>
                    </div>
                </div>
                <p class="mt-6 text-xs text-slate-400 text-center italic">Activez une colocation pour voir vos soldes.</p>
            </div>
        </div>
    </div>
@endsection