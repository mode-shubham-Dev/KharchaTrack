<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Budget\StoreBudgetRequest;
use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    // ===== INDEX — Show all budgets with progress =====
    public function index(Request $request)
    {
        // Get selected month/year from filter
        // Default to current month/year
        $month = $request->input('month', now()->month);
        $year  = $request->input('year', now()->year);

        // Get user's budgets for selected month
        // with category — for name and color
        $budgets = Budget::where('user_id', auth()->id())
            ->forMonth($month, $year)
            ->with('category')
            ->get();

        // Get expense categories that have NO budget set
        // So user knows which categories still need budgets
        $categoriesWithoutBudget = Category::where('user_id', auth()->id())
            ->where('type', 'expense')
            ->whereDoesntHave('budgets', function ($query) use ($month, $year) {
                $query->where('user_id', auth()->id())
                      ->where('month', $month)
                      ->where('year', $year);
            })
            ->get();

        // Summary totals
        $totalBudget = $budgets->sum('amount');
        $totalSpent  = $budgets->sum('spent');

        return view('dashboard.pages.budgets.index', compact(
            'budgets',
            'categoriesWithoutBudget',
            'totalBudget',
            'totalSpent',
            'month',
            'year'
        ));
    }

    // ===== STORE — Create or update budget =====
    public function store(StoreBudgetRequest $request)
    {
        $validated = $request->validated();

        // updateOrCreate — update if exists, create if not
        // This handles the unique constraint gracefully
        Budget::updateOrCreate(
            [
                // Find by these fields
                'user_id'     => auth()->id(),
                'category_id' => $validated['category_id'],
                'month'       => $validated['month'],
                'year'        => $validated['year'],
            ],
            [
                // Update/create with this value
                'amount' => $validated['amount'],
            ]
        );

        return redirect()->route('budgets.index', [
            'month' => $validated['month'],
            'year'  => $validated['year'],
        ])->with('success', 'Budget saved successfully!');
    }

    // ===== DESTROY — Delete budget =====
    public function destroy(Budget $budget)
    {
        if ($budget->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $budget->delete();

        return redirect()->route('budgets.index')
            ->with('success', 'Budget removed successfully!');
    }
}