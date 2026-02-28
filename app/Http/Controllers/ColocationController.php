<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreColocationRequest;
use App\Http\Requests\StorebalanceRequest;

class ColocationController extends Controller
{
    
    public function create()
    {
        return view('colocations.create');
    }

   
    public function store(StoreColocationRequest $request)
    {

        

        $coloc = Colocation::create([
            'name' => $request->name,
            'owner_id' => auth()->user()->id,
            'status' => 'active',
        ]);

        Membership::create([
            'user_id' => auth()->user()->id,
            'colocation_id' => $coloc->id,
            'role' => 'owner',
            'is_active' => true,
            'joined_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Colocation créée !');
    }


   public function leave(StorebalanceRequest $request)
{
    $membership = auth()->user()->activeMembership();

    $balance = $request->balance;

    if ($membership->role === 'owner') {
        $colocation = $membership->colocation;

        Membership::where('colocation_id', $colocation->id)
            ->update(['is_active' => false]);

        $colocation->update(['status' => 'cancelled']);

        if ($balance < 0) {
            auth()->user()->decrement('reputation_score'); // -1
        } else {
            auth()->user()->increment('reputation_score'); // +1
        }

        return redirect()->route('dashboard')->with('success', 'Colocation annulée pour tous les membres.');
    }

    if ($balance < 0) {
        auth()->user()->decrement('reputation_score'); // -1
    } else {
        auth()->user()->increment('reputation_score'); // +1
    }

    $membership->update(['is_active' => false]);

    return redirect()->route('dashboard')->with('success', 'Vous avez quitté la colocation.');
}

    public function removeMember($member_id){
     

        
        $membership = auth()->user()->activeMembership();
            Membership::where('user_id',$member_id)->where('colocation_id',$membership->colocation_id)
                        ->delete();
            return back()->with('success', 'Member removed.');

    }
}
