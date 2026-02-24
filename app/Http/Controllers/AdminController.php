<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $usersCount = User::count();
        $bannedCount = User::where('is_banned', true)->count();


        $users = User::orderByDesc('created_at')->paginate(10);

        return view('admin.dashboard', compact(
            'usersCount', 'bannedCount', 'users'
        ));
    }
}