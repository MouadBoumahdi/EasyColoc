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
        </div>
        @elseif(Auth::user()->hasActiveColocation() && Auth::user()->isColocationOwner())
        <form action="{{ route('colocations.leave') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-6 py-2.5 rounded-2xl font-bold flex items-center gap-2 hover:bg-red-600 transition-all">
                <i class="fa-solid fa-right-from-bracket text-sm"></i> Cancel colocation
            </button>
        </form>
        @else
        <form action="{{ route('colocations.leave') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-6 py-2.5 rounded-2xl font-bold flex items-center gap-2 hover:bg-red-600 transition-all">
                <i class="fa-solid fa-right-from-bracket text-sm"></i> Leave colocation
            </button>
        </form>
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

        <div class="space-y-8">
            <!-- Colocation Status -->
            <div class="bg-[#1E293B] rounded-[2rem] p-8 text-white relative h-min shadow-2xl shadow-slate-200 overflow-hidden">
                @if(Auth::user()->hasActiveColocation())
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="font-bold text-lg italic">Ma Colocation</h3>
                        <span class="bg-emerald-500/20 text-emerald-400 text-[10px] font-bold px-3 py-1 rounded-md tracking-tighter uppercase border border-emerald-500/30">Active</span>
                    </div>

                    <div class="space-y-4 mb-8">
                        @foreach(Auth::user()->activeMembership()->colocation->membership()->where('is_active', true)->get() as $m)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg {{ $m->user_id === Auth::id() ? 'bg-indigo-500' : 'bg-slate-700' }} flex items-center justify-center text-[10px] font-bold">
                                {{ substr($m->user->name, 0, 1) }}
                            </div>
                            <div>
                            <div class="flex items-center gap-2">
                                    <p class="text-sm font-bold leading-none">
                                        {{ $m->user->name }}
                                    </p>

                                    @if(auth()->user()->isColocationOwner() && $m->role !== 'owner')
                                        <form action="{{ route('colocation.remove', $m->user_id) }}" method="POST">
                                            @csrf
                                            <button type="submit" 
                                                class="text-red-500 text-xs font-bold hover:text-red-700">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <p class="text-[10px] text-slate-400">
                                    {{ $m->role === 'owner' ? 'Owner' : 'Membre' }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @if(Auth::user()->isColocationOwner())
                        <button onclick="document.getElementById('inviteModal').classList.remove('hidden')" class="block w-full text-center py-4 bg-indigo-600 hover:bg-indigo-700 rounded-2xl text-sm font-bold transition-all shadow-lg shadow-indigo-900/20 text-white">
                            <i class="fa-solid fa-user-plus mr-2"></i> Inviter des colocs
                        </button>
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
            @if(Auth::user()->isColocationOwner())
        <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-bold text-slate-800 flex items-center gap-2 italic uppercase text-sm">
                    <i class="fa-solid fa-tags text-indigo-500"></i>
                    Catégories
                </h3>
            </div>

            <div class="relative mb-6">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <input type="text" name='name' placeholder="Nouvelle catégorie..." 
                    class="w-full pl-5 pr-12 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all text-sm text-slate-700">
                    <button type="submit" class="absolute right-2 top-2 w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">
                        <i class="fa-solid fa-plus text-xs"></i>
                    </button>
                </form>
            </div>

            <div class="flex flex-wrap gap-2">
                @foreach($categories as $category)
                    <span class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 text-xs font-semibold rounded-xl border border-indigo-100 transition-all hover:bg-indigo-100">
                        {{ $category->name }}
                    </span>
                @endforeach
            </div>
        </div>
            @endif
        </div>
    </div>

    <!-- Invitation Modal -->
    <div id="inviteModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-[2.5rem] w-full max-w-md p-10 shadow-2xl relative animate-[fadeIn_0.2s_ease-out]">
            <button onclick="document.getElementById('inviteModal').classList.add('hidden')" class="absolute top-8 right-8 text-slate-400 hover:text-slate-600 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
            
            <div class="mb-8">
                <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 mb-6 font-bold text-xl">
                    <i class="fa-solid fa-paper-plane"></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-900 italic uppercase">Inviter un colocataire</h2>
                <p class="text-slate-500 text-sm mt-1">Envoyez une invitation par email pour rejoindre votre colocation.</p>
            </div>

            <form action="{{ route('invitations.send') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Adresse Email</label>
                    <input type="email" name="email" id="email" required placeholder="exemple@email.com" 
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all text-slate-700">
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-indigo-100 transition-all flex items-center justify-center gap-2">
                    Envoyer l'invitation <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
@endsection