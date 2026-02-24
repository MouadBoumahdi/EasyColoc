<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{


    public function index()
    {
        $usersCount = User::count();
        $bannedCount = User::where('is_banned', true)->count();
        $users = User::orderByDesc('created_at')->paginate(10);

        return view('admin.dashboard', compact('usersCount', 'bannedCount', 'users'));
    }



    public function toggleBan(User $user){
        if($user->id === auth()->id()){
            return back()->withErrors(['error' => "You can't ban yourself."]);
        }


        $user->is_banned = !$user->is_banned;
        $user->save();

        return back();
    }
}