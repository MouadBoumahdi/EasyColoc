<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreColocationRequest;

class ColocationController extends Controller
{
    
    public function create()
    {
        return view('colocations.create');
    }

   
    public function store(StoreColocationRequest $request)
    {

        $authenticatedUser = Auth::user();

        $alreadyInColoc = Membership::where('user_id', $authenticatedUser->id)
            ->where('is_active', true)
            ->exists();

        if ($alreadyInColoc) {
            return back()->withErrors(['error' => 'Vous faites déjà partie d\'une colocation active.']);
        }

        $coloc = Colocation::create([
            'name' => $request->name,
            'owner_id' => $authenticatedUser->id,
            'status' => 'active',
        ]);

        Membership::create([
            'user_id' => $authenticatedUser->id,
            'colocation_id' => $coloc->id,
            'role' => 'owner',
            'is_active' => true,
            'joined_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Colocation créée !');
    }


    public function leave(){
        $authUser = Auth::user();
        $membership = Membership::where('user_id', $authUser->id)
        ->where('is_active',true)
        ->first();

        if($membership){
            $membership->update([
                'is_active'=>false
            ]);
            return redirect()->route('dashboard')->with('success','vous avez quittez la colocation');
        }
    }
}
