<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ColocationController extends Controller
{
    public function create(){
        return view('colocations.create');
    }

    public function store(Request $request){
        
        $request->validate([
            'name'=>'required|string|max:255',
        ]);

        $user = $auth()->user();

        if($user->member)
        

    }
}
