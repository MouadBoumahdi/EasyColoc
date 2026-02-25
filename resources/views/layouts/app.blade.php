<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyColoc - Design Static</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: #F8FAFC;
        }
        .sidebar-item-active {
            background-color: #EEF2FF;
            color: #4F46E5;
        }
        .sidebar-item-active i {
            color: #4F46E5;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #E2E8F0;
            border-radius: 10px;
        }
    </style>
</head>
<body class="antialiased text-slate-900">

    <div class="flex h-screen overflow-hidden">
        <!-- SIDEBAR -->
        <aside class="w-64 bg-white border-r border-slate-200 flex flex-col h-full relative">
            <!-- Logo -->
            <div class="p-6 mb-2">
                <a href="#" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white">
                        <i class="fa-solid fa-house-chimney-user text-sm"></i>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-indigo-900">EasyColoc</span>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 space-y-2">
                <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Menu</p>
                
                <a href="#" class="sidebar-item-active flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group">
                    <i class="fa-solid fa-gauge-high w-5 text-indigo-500"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-indigo-600 font-medium transition-all group">
                    <i class="fa-solid fa-door-open w-5 group-hover:text-indigo-600 transition-colors"></i>
                    <span>Colocations</span>
                </a>

                <div class="pt-4">
                    <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Administration</p>
                    <a href="#" class="text-slate-500 hover:bg-slate-50 hover:text-indigo-600 flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group">
                        <i class="fa-solid fa-shield-halved w-5 group-hover:text-indigo-600 transition-colors"></i>
                        <span>Admin Panel</span>
                    </a>
                </div>

                <div class="pt-4">
                    <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Compte</p>
                    <a href="#" class="text-slate-500 hover:bg-slate-50 hover:text-indigo-600 flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group">
                        <i class="fa-solid fa-user-gear w-5 group-hover:text-indigo-600 transition-colors"></i>
                        <span>Profile</span>
                    </a>
                    
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-rose-500 hover:bg-rose-50 font-medium transition-all group">
                        <i class="fa-solid fa-arrow-right-from-bracket w-5"></i>
                        <span>Déconnexion</span>
                    </a>
                </div>
            </nav>

            <!-- Reputation Widget At Bottom -->
            <div class="p-4 mt-auto">
                <div class="bg-[#0F172A] rounded-2xl p-4 text-white">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2">Réputation</p>
                    <div class="flex items-center justify-between mb-3">
                        <div class="text-lg font-bold">150 points</div>
                        <i class="fa-solid fa-crown text-amber-400 text-xs"></i>
                    </div>
                    <div class="w-full bg-slate-700 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-indigo-500 h-full w-[65%]" style="width: 65%"></div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col h-full overflow-hidden">
            <!-- Topbar -->
            <header class="h-16 flex items-center justify-end px-8 bg-white/50 backdrop-blur-sm border-b border-slate-100">
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-sm font-bold text-slate-700 leading-tight">USER 2</p>
                        <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-tighter">En ligne</p>
                    </div>
                    <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-700 font-bold border border-indigo-200">
                        U
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-8 custom-scrollbar">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>