<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index(){
        $user = auth()->user();

        $categories = [];

        if($user->hasActiveColocation()){
            $colocation = $user->activeMembership()->colocation;

            $categories = Category::where('colocation_id',$colocation->id)->get();
        }


        return view('dashboard', compact('categories'));
    }
}
