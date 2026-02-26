<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Membership;
use App\Models\User;
use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Requests\StoreInvitationRequest;

class InvitationController extends Controller
{
   
    public function store(StoreInvitationRequest $request)
    { 

        $user = auth()->user();
        $membership = $user->activeMembership();
        

        if (!$membership || $membership->role !== 'owner') {
            return back()->with('error', 'Seul le propriétaire de la colocation peut envoyer des invitations.');
        }

        $colocation = $membership->colocation;

        $existingInvitation = Invitation::where('colocation_id', $colocation->id)
            ->where('email', $request->email)
            ->where('status', 'pending')
            ->first();
            
        if ($existingInvitation) {
            return back()->with('error', 'Une invitation est déjà en cours pour cet email.');
        }

        $invitation = Invitation::create([
            'colocation_id' => $colocation->id,
            'email' => $request->email,
            'token' => Str::random(32),
            'status' => 'pending',
            'expires_at' => Carbon::now()->addDays(7)
        ]);

        Mail::to($request->email)->send(new InvitationMail($invitation));

        return back()->with('success', 'Invitation envoyée avec succès à ' . $request->email);
    }


    
    public function choose($token)
    {
        $invitation = Invitation::where('token', $token)
            ->where('status', 'pending')
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$invitation) {
            return redirect()->route('dashboard')->with('error', 'Invitation invalide ou expirée.');
        }

        return view('invitations.choose', compact('invitation'));
    }


    public function accept($token)
    {
        $invitation = Invitation::where('token', $token)
            ->where('status', 'pending')
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$invitation) {
            return redirect()->route('dashboard')->with('error', 'Invitation invalide ou expirée.');
        }

        $user = auth()->user();

        if ($user->email !== $invitation->email) {
            return redirect()->route('dashboard')->with('error', 'Cette invitation est destinée à un autre email.');
        }

        if ($user->hasActiveColocation()) {
            return redirect()->route('dashboard')->with('error', 'Vous avez déjà une colocation active.');
        }

        Membership::create([
            'user_id' => $user->id,
            'colocation_id' => $invitation->colocation_id,
            'role' => 'member',
            'is_active' => true,
            'joined_at' => Carbon::now()
        ]);

        $invitation->update(['status' => 'accepted']);

        $user->increment('reputation_score');

        return redirect()->route('dashboard')->with('success', 'Bienvenue dans votre nouvelle colocation !');
    }


    public function refuse($token)
    {
        $invitation = Invitation::where('token', $token)
            ->where('status', 'pending')
            ->first();

        if (!$invitation) {
            return redirect()->route('dashboard')->with('error', 'Invitation invalide.');
        }

        $invitation->update(['status' => 'refused']);

        return redirect()->route('dashboard')->with('success', 'Invitation refusée.');
    }
}
