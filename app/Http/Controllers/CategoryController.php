<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(StoreCategoryRequest $request){
        $user = auth()->user();

        $membership = $user->activeMembership();
        $colocation_id = $membership->colocation_id;
        
        Category::create([
            'colocation_id' => $colocation_id,
            'name' => $request->name
        ]);



        return redirect()->route('dashboard')->with('success','Categorie ajoutee avec succes !');

        
    }



}
