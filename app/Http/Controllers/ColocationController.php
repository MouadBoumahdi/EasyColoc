<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ColocationController extends Controller
{
    /**
     * Show the form to create a new colocation.
     */
    public function create()
    {
        return view('colocations.create');
    }

    /**
     * Store a newly created colocation.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $authenticatedUser = Auth::user();

        // 2. Security Check: Only 1 active colocation allowed
        $alreadyInColoc = Membership::where('user_id', $authenticatedUser->id)
            ->where('is_active', true)
            ->exists();

        if ($alreadyInColoc) {
            return back()->withErrors(['error' => 'Vous faites déjà partie d\'une colocation active.']);
        }

        // 3. Atomic creation using a Transaction
        DB::transaction(function () use ($request, $authenticatedUser) {
            // Create Colocation
            $coloc = Colocation::create([
                'name' => $request->name,
                'owner_id' => $authenticatedUser->id,
                'status' => 'active',
            ]);

            // Create Membership (Role: owner)
            Membership::create([
                'user_id' => $authenticatedUser->id,
                'colocation_id' => $coloc->id,
                'role' => 'owner',
                'is_active' => true,
                'joined_at' => now(),
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Colocation créée !');
    }
}
