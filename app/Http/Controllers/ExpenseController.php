<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Membership;
use App\Models\Category;
use App\Http\Requests\StoreExpenseRequest;

class ExpenseController extends Controller
{
    public function index()
    {
        $membership = auth()->user()->activeMembership();

        if (!$membership) {
            return view("dashboard", [
                "expenses"     => collect(),
                "totalexpense" => 0,
                "expenseshare" => 0,
                "balances"     => [],
                "settlements"  => [],
                "categories"   => [],
                "members"      => collect(),
                "userbalance" => 0,
            ]);
        }

        $colocation = $membership->colocation;

        $categories = auth()->user()->hasActiveColocation()
            ? Category::where("colocation_id", $colocation->id)->get()
            : collect();

        $members = Membership::where('colocation_id', $colocation->id)
                    ->where('is_active', true)
                    ->with('user')
                    ->get();

        $membercount = $members->count();

        $expenses = Expense::where('colocation_id', $colocation->id)
                            ->where('is_settlement',false)
                            ->with(['payer','colocation'])
                            ->orderBy('date', 'desc')
                            ->get();

        $settlementspayements = Expense::where('colocation_id',$colocation->id)
                                        ->where('is_settlement',true)
                                        ->get();

        $totalexpense = $expenses->sum('amount');
        $expenseshare = $membercount > 0 ? $totalexpense / $membercount : 0;

        $balances = [];

        foreach ($members as $member) {

            $realPaid           = $expenses->where('payer_id', $member->user->id)->sum('amount');
            $settlementPaid     = $settlementspayements->where('payer_id', $member->user->id)->sum('amount');
            $settlementReceived = $settlementspayements->where('to_user_id', $member->user->id)->sum('amount');

          
            $balance = $realPaid - $expenseshare + $settlementPaid - $settlementReceived;

            $balances[] = [
                'user' => $member->user,
                'paid' => $realPaid,
                'balance' => $balance
            ];
        }

        $settlements = [];

        foreach ($balances as $debtor) {
            if ($debtor['balance'] >= -0.01) continue; 

            foreach ($balances as $creditor) {
                if ($creditor['balance'] <= 0.01) continue;

                if ($debtor['user']->id === $creditor['user']->id) continue;

                $settlements[] = [
                    'from'   => $debtor['user'],
                    'to'     => $creditor['user'],
                    'amount' => round(min(abs($debtor['balance']), $creditor['balance']), 2),
                ];
            }
        }

        
        $userBalance = collect($balances)->firstWhere('user.id', auth()->id())['balance'] ?? 0;
        $reputation_score = auth()->user()->reputation_score;


        return view('dashboard', compact(
            'expenses', 'totalexpense', 'expenseshare',
            'balances', 'settlements', 'categories', 'members', 'userBalance', 'reputation_score'
        ));
    }

    public function store(StoreExpenseRequest $request)
    {
        Expense::create([
            'colocation_id' => auth()->user()->activeMembership()->colocation_id,
            'payer_id'      => auth()->id(),
            'category_name' => $request->category_name,
            'amount'        => $request->amount,
            'date'          => $request->date ?? now(),
            'is_settlement' => false,
        ]);

        return back()->with('success', 'Expense added successfully');
    }




    public function settle(Request $request)
    {
        $request->validate([
            'to_user_id' => 'required|exists:users,id',
            'amount'     => 'required|numeric|min:0.01',
        ]);

        Expense::create([
            'colocation_id' => auth()->user()->activeMembership()->colocation_id,
            'payer_id'      => auth()->id(),        // the one paying (logged-in debtor)
            'to_user_id'    => $request->to_user_id, // the one receiving
            'category_name' => 'Settlement',
            'amount'        => $request->amount,
            'date'          => now(),
            'is_settlement' => true,
        ]);

        return back()->with('success', 'Paiement enregistré !');
    }
}
