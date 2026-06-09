<?php

namespace App\Http\Controllers;

use App\Models\SavingsGoals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavingsGoalsController extends Controller
{
    public function index()
    {
        $savingsGoals = SavingsGoals::where('user_id', Auth::id())->get();

        return view('savings_goals.index', compact('savingsGoals'));
    }

    public function create()
    {
        return view('savings_goals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'current_amount' => 'nullable|numeric|min:0',
            'deadline' => 'nullable|date|after:today',
        ]);

        SavingsGoals::create([
            'user_id' => Auth::id(),
            ...$validated,
        ]);

        return redirect()->route('savings-goals.index')->with('status', 'Savings goal created successfully!');
    }

    public function show(string $id)
    {
        $savingsGoal = SavingsGoals::where('user_id', Auth::id())->findOrFail($id);

        return view('savings_goals.show', compact('savingsGoal'));
    }

    public function edit(string $id)
    {
        $savingsGoal = SavingsGoals::where('user_id', Auth::id())->findOrFail($id);

        return view('savings_goals.edit', compact('savingsGoal'));
    }

    public function update(Request $request, string $id)
    {
        $savingsGoal = SavingsGoals::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'current_amount' => 'nullable|numeric|min:0',
            'deadline' => 'nullable|date|after:today',
        ]);

        $savingsGoal->update($validated);

        return redirect()->route('savings-goals.index')->with('status', 'Savings goal updated successfully!');
    }

    public function destroy(string $id)
    {
        $savingsGoal = SavingsGoals::where('user_id', Auth::id())->findOrFail($id);

        $savingsGoal->delete();

        return redirect()->route('savings-goals.index')->with('status', 'Savings goal deleted successfully!');
    }
}