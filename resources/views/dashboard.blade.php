@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
    <div class="flex items-center justify-between mb-10">
        <h1 class="text-2xl font-bold tracking-tight text-slate-800 italic uppercase">Tableau de Bord</h1>
        
        @if(!Auth::user()->hasActiveColocation())
            <div class="flex items-center gap-3">
                <a href="{{ route('colocations.create') }}" class="bg-[#4F46E5] text-white px-6 py-2.5 rounded-2xl font-bold flex items-center gap-2 shadow-lg shadow-indigo-100 hover:bg-[#4338CA] transition-all">
                    <span class="text-lg">+</span> Nouvelle colocation
                </a>
            </div>
        @else
            <form action="{{ route('colocations.leave') }}" method="POST">
                @csrf
                <input type="hidden" name="balance" value="{{ $userBalance }}">
                <button type="submit" class="bg-red-500 text-white px-6 py-2.5 rounded-2xl font-bold flex items-center gap-2 hover:bg-red-600 transition-all">
                    <i class="fa-solid fa-right-from-bracket text-sm"></i> {{ Auth::user()->isColocationOwner() ? 'Cancel' : 'Leave' }} colocation
                </button>
            </form>
        @endif
    </div>

    <div class="mb-10">
        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 flex items-start justify-between relative overflow-hidden group hover:shadow-xl hover:shadow-indigo-50/50 transition-all duration-500">
            <div>
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-2xl flex items-center justify-center text-[#4F46E5] mb-6 group-hover:scale-110 transition-transform shadow-sm">
                    <i class="fa-solid fa-cart-shopping text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-1 italic">Total des dépenses</p>
                    <div class="text-5xl font-black text-slate-900 tracking-tighter">{{ number_format($totalexpense, 2) }} <span class="text-2xl text-indigo-500 -ml-2">€</span></div>
                    <div class="mt-4 flex items-center gap-3">
                        <div class="px-3 py-1 bg-slate-900 text-white text-[9px] font-black uppercase tracking-widest rounded-lg italic">
                            Part : {{ $expenseshare }} €
                        </div>
                        <span class="text-[9px] text-slate-400 font-bold uppercase italic">/ personne</span>
                    </div>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-[0.03] rotate-12">
                <i class="fa-solid fa-cart-shopping text-[120px]"></i>
            </div>
        </div>
    </div>

    @if(auth()->user()->hasActiveColocation())
    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 mb-10">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                <i class="fa-solid fa-plus"></i>
            </div>
            <h3 class="font-bold text-slate-800 italic uppercase text-sm tracking-wider">Ajouter une dépense</h3>
        </div>

        <form action="{{ route('expense.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
            @csrf
            <div class="flex flex-col gap-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Catégorie</label>
                <select name="category_name" class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm font-semibold outline-none appearance-none">
                    <option value="Autre">Autre</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Montant (€)</label>
                <input type="number" step="0.01" name="amount" required placeholder="0.00" class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm font-semibold outline-none appearance-none">
            </div>
            <button type="submit" class="bg-slate-900 text-white font-bold h-[58px] rounded-2xl shadow-xl hover:bg-indigo-600 hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2">
                Enregistrer <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
        </form>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-slate-50">
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-slate-400">Catégorie</th>
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-slate-400">Payeur</th>
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-center">Montant</th>
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-right">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses as $expense)
                        <tr>
                            <td class="px-8 py-5 text-center text-xs font-semibold">{{ $expense->category_name }}</td>
                            <td class="px-8 py-5 text-center text-sm text-slate-600">{{ $expense->payer->name }}</td>
                            <td class="px-8 py-5 text-center font-bold">{{ number_format($expense->amount, 2) }} €</td>
                            <td class="px-8 py-5 text-center text-xs text-slate-400">{{ $expense->date }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-[#1E293B] rounded-[2rem] p-8 text-white relative h-min shadow-2xl overflow-hidden">
                @if(Auth::user()->hasActiveColocation())
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="font-bold text-lg italic uppercase tracking-tighter">Ma Colocation</h3>
                        <span class="bg-emerald-500/20 text-emerald-400 text-[10px] font-bold px-3 py-1 rounded-md uppercase border border-emerald-500/30">Active</span>
                    </div>

                    <div class="space-y-4 mb-8">
                        @foreach(Auth::user()->activeMembership()->colocation->membership()->where('is_active', true)->get() as $m)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg {{ $m->user_id === Auth::id() ? 'bg-indigo-500' : 'bg-slate-700' }} flex items-center justify-center text-[10px] font-bold">
                                {{ substr($m->user->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-bold">{{ $m->user->name }}</p>
                                    @if(auth()->user()->isColocationOwner() && $m->role !== 'owner')
                                        <form action="{{ route('colocation.remove', $m->user_id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-red-500 text-[10px] font-bold hover:text-red-400 uppercase tracking-tighter">Retirer</button>
                                        </form>
                                    @endif
                                </div>
                                <p class="text-[10px] text-slate-400 capitalize">{{ $m->role }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @if(Auth::user()->isColocationOwner())
                        <button onclick="document.getElementById('inviteModal').classList.remove('hidden')" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 rounded-2xl text-sm font-bold transition-all text-white">
                            <i class="fa-solid fa-user-plus mr-2"></i> Inviter des colocs
                        </button>
                    @endif
                @else
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="font-bold text-lg uppercase tracking-tighter">Membres</h3>
                        <span class="bg-indigo-500/20 text-indigo-300 text-[10px] font-bold px-3 py-1 rounded-md uppercase border border-indigo-500/30 italic">Attente</span>
                    </div>
                    <p class="text-slate-400 text-sm italic leading-relaxed">Aucune colocation active. Créez-en une ou rejoignez un groupe.</p>
                @endif
            </div>
{{-- Qui doit à Qui --}}
@if(Auth::user()->hasActiveColocation())
<div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm">
    <div class="flex items-center gap-3 mb-5">
        <div class="w-8 h-8 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-500 text-xs">
            <i class="fa-solid fa-right-left"></i>
        </div>
        <h3 class="font-bold text-slate-800 italic uppercase text-xs tracking-widest">Qui doit à Qui</h3>
    </div>

    @if(count($settlements) === 0)
        <div class="flex items-center gap-3 p-4 bg-emerald-50 rounded-2xl border border-emerald-100">
            <i class="fa-solid fa-check text-emerald-500 text-xs"></i>
            <p class="text-xs font-bold text-emerald-700">Tout est équilibré !</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach($settlements as $s)
            @php $isMe = $s['from']->id === Auth::id(); @endphp
            <div class="p-3 rounded-2xl border {{ $isMe ? 'bg-amber-50 border-amber-200' : 'bg-slate-50 border-slate-100' }}">
                {{-- Row: debtor → amount → creditor --}}
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg {{ $isMe ? 'bg-amber-400' : 'bg-slate-300' }} flex items-center justify-center text-[9px] font-black text-white uppercase shrink-0">
                        {{ substr($s['from']->name, 0, 1) }}
                    </div>
                    <span class="text-xs font-bold text-slate-800 flex-1 truncate">{{ $s['from']->name }}</span>

                    <div class="flex flex-col items-center shrink-0 px-1">
                        <i class="fa-solid fa-arrow-right text-[8px] text-slate-400"></i>
                        <span class="text-[9px] font-black {{ $isMe ? 'text-amber-600' : 'text-indigo-500' }} mt-0.5">
                            {{ number_format($s['amount'], 2) }} €
                        </span>
                    </div>

                    <span class="text-xs font-bold text-slate-800 flex-1 truncate text-right">{{ $s['to']->name }}</span>
                    <div class="w-7 h-7 rounded-lg bg-emerald-200 flex items-center justify-center text-[9px] font-black text-emerald-800 uppercase shrink-0">
                        {{ substr($s['to']->name, 0, 1) }}
                    </div>
                </div>

                {{-- Pay button — only shown to the debtor themselves --}}
                @if($isMe)
                <form action="{{ route('expense.settle') }}" method="POST" class="mt-3">
                    @csrf
                    <input type="hidden" name="to_user_id" value="{{ $s['to']->id }}">
                    <input type="hidden" name="amount"     value="{{ $s['amount'] }}">
                    <button type="submit"
                        class="w-full text-[10px] font-black uppercase tracking-widest bg-amber-500 hover:bg-amber-600 text-white py-2 rounded-xl transition-all">
                        <i class="fa-solid fa-check mr-1"></i> J'ai payé {{ $s['amount'] }} €
                    </button>
                </form>
                @endif
            </div>
            @endforeach
        </div>
    @endif
</div>
@endif


            @if(Auth::user()->isColocationOwner())
                <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2 italic uppercase text-sm mb-6">
                        <i class="fa-solid fa-tags text-indigo-500"></i> Catégories
                    </h3>

                    <form action="{{ route('categories.store') }}" method="POST" class="relative mb-6">
                        @csrf
                        <input type="text" name='name' placeholder="Nouvelle..." class="w-full pl-5 pr-12 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm outline-none">
                        <button type="submit" class="absolute right-2 top-2 w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center hover:bg-indigo-700 transition-all">
                            <i class="fa-solid fa-plus text-xs"></i>
                        </button>
                    </form>

                    <div class="flex flex-wrap gap-2">
                        @foreach($categories as $category)
                            <span class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 text-xs font-semibold rounded-xl border border-indigo-100">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div id="inviteModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-[2.5rem] w-full max-w-md p-10 shadow-2xl relative">
            <button onclick="document.getElementById('inviteModal').classList.add('hidden')" class="absolute top-8 right-8 text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
            <div class="mb-8 font-bold">
                <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 mb-6 text-xl">
                    <i class="fa-solid fa-paper-plane"></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-900 italic uppercase">Inviter</h2>
                <p class="text-slate-500 text-sm mt-1">Rejoindre la colocation par email.</p>
            </div>
            <form action="{{ route('invitations.send') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Email</label>
                    <input type="email" name="email" required placeholder="exemple@email.com" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all outline-none">
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-2xl transition-all flex items-center justify-center gap-2">
                    Envoyer <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>
        </div>
    </div>
@endsection