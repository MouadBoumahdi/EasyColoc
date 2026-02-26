@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-10">
        <h1 class="text-2xl font-bold tracking-tight text-slate-800 italic uppercase">Mon Profil</h1>
    </div>

    <div class="space-y-8">
        <!-- Profile Info -->
        <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-sm border border-slate-100 group transition-all duration-500">
            <div class="max-w-xl">
                <h3 class="text-lg font-bold text-slate-800 mb-6">Informations du profil</h3>
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-sm border border-slate-100 group transition-all duration-500">
            <div class="max-w-xl">
                <h3 class="text-lg font-bold text-slate-800 mb-6">Mettre à jour le mot de passe</h3>
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account -->
        <div class="bg-rose-50 rounded-[2.5rem] p-8 md:p-12 shadow-sm border border-rose-100 group transition-all duration-500">
            <div class="max-w-xl">
                <h3 class="text-lg font-bold text-rose-800 mb-2">Supprimer le compte</h3>
                <p class="text-sm text-rose-600 mb-6">Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.</p>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
