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


    public function leave()
    {
        $authUser = Auth::user();
        $membership = $authUser->activeMembership();

        if (!$membership) {
            return back()->with('error', 'Vous n\'avez pas de colocation active.');
        }

        if ($membership->role === 'owner') {
            $colocation = $membership->colocation;

            Membership::where('colocation_id', $colocation->id)
                ->update(['is_active' => false]);

            $colocation->update(['status' => 'cancelled']);

            return redirect()->route('dashboard')->with('success', 'Colocation annulée pour tous les membres.');
        } 

        $membership->update(['is_active' => false]);

        return redirect()->route('dashboard')->with('success', 'Vous avez quitté la colocation.');
    }


    public function removeMember($member_id){
        $user = Auth::user();

        
        $membership = $user->activeMembership();
        // dd($membership);
        if($membership->role === 'owner'){
            Membership::where('user_id',$member_id)->where('colocation_id',$membership->colocation_id)->delete();
            return back()->with('success', 'Member removed.');

        }
    }
}
