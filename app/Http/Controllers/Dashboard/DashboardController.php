<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // ===== SUMMARY CARDS =====
        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->currentMonth()
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->currentMonth()
            ->sum('amount');

        $netBalance = $totalIncome - $totalExpense;

        $totalTransactions = Transaction::where('user_id', $userId)
            ->currentMonth()
            ->count();

        // ===== PIE CHART DATA =====
        $spendingByCategory = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->currentMonth()
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->groupBy('category_id')
            ->with('category')
            ->get()
            ->map(function ($item) {
                return [
                    'name'  => $item->category->name,
                    'total' => $item->total,
                    'color' => $item->category->color,
                ];
            });

        // ===== BAR CHART DATA =====
        $last6Months = collect();

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->startOfMonth()->subMonths($i);

            $income = Transaction::where('user_id', $userId)
                ->where('type', 'income')
                ->whereMonth('date', $month->month)
                ->whereYear('date', $month->year)
                ->sum('amount');

            $expense = Transaction::where('user_id', $userId)
                ->where('type', 'expense')
                ->whereMonth('date', $month->month)
                ->whereYear('date', $month->year)
                ->sum('amount');

            $last6Months->push([
                'month'   => $month->format('M Y'),
                'income'  => $income,
                'expense' => $expense,
            ]);
        }

        // ===== RECENT TRANSACTIONS =====
        $recentTransactions = Transaction::where('user_id', $userId)
            ->with('category')
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();

        // ===== SMART INSIGHTS =====
        $insights = $this->generateInsights($userId, $totalIncome, $totalExpense);

        return view('dashboard.pages.dashboard.index', compact(
            'totalIncome',
            'totalExpense',
            'netBalance',
            'totalTransactions',
            'spendingByCategory',
            'last6Months',
            'recentTransactions',
            'insights'
        ));
    }

    // ===== GENERATE INSIGHTS METHOD =====
    // Separated into own method to keep index() clean
    // Returns array of insight messages
    private function generateInsights($userId, $totalIncome, $totalExpense)
    {
        // Each insight is an array with:
        // type    → 'success', 'warning', 'danger', 'info'
        // icon    → font awesome icon class
        // message → the insight text
        $insights = [];

        // ===== INSIGHT 1: SAVINGS RATE =====
        // Only show if user has income this month
        if ($totalIncome > 0) {
            $savingsRate = round((($totalIncome - $totalExpense) / $totalIncome) * 100);

            if ($savingsRate >= 20) {
                // Good savings rate
                $insights[] = [
                    'type'    => 'success',
                    'icon'    => 'fas fa-piggy-bank',
                    'message' => "You saved {$savingsRate}% of your income this month — great job! 🎉",
                ];
            } elseif ($savingsRate > 0) {
                // Low but positive savings
                $insights[] = [
                    'type'    => 'warning',
                    'icon'    => 'fas fa-piggy-bank',
                    'message' => "You saved only {$savingsRate}% of your income this month. Try to save at least 20%.",
                ];
            } else {
                // Spending more than earning
                $insights[] = [
                    'type'    => 'danger',
                    'icon'    => 'fas fa-triangle-exclamation',
                    'message' => "You spent more than you earned this month! Review your expenses.",
                ];
            }
        }

        // ===== INSIGHT 2: TOP EXPENSE CATEGORY =====
        $topExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->currentMonth()
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->with('category')
            ->first();

        if ($topExpense) {
            $insights[] = [
                'type'    => 'info',
                'icon'    => 'fas fa-chart-pie',
                'message' => "Your biggest expense this month is {$topExpense->category->name} — NPR " . number_format($topExpense->total, 2),
            ];
        }

        // ===== INSIGHT 3: MONTH COMPARISON =====
        // Compare this month vs last month expense
        $lastMonthExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('date', now()->subMonth()->month)
            ->whereYear('date', now()->subMonth()->year)
            ->sum('amount');

        if ($lastMonthExpense > 0 && $totalExpense > 0) {
            $change = round((($totalExpense - $lastMonthExpense) / $lastMonthExpense) * 100);

            if ($change > 20) {
                // Spending increased significantly
                $insights[] = [
                    'type'    => 'warning',
                    'icon'    => 'fas fa-arrow-trend-up',
                    'message' => "Your spending increased by {$change}% compared to last month.",
                ];
            } elseif ($change < -10) {
                // Spending decreased
                $insights[] = [
                    'type'    => 'success',
                    'icon'    => 'fas fa-arrow-trend-down',
                    'message' => "Great! Your spending decreased by " . abs($change) . "% compared to last month.",
                ];
            }
        }

        // ===== INSIGHT 4: BUDGET ALERTS =====
        // Get all budgets for current month
        $budgets = Budget::where('user_id', $userId)
            ->currentMonth()
            ->with('category')
            ->get();

        foreach ($budgets as $budget) {
            if ($budget->percentage >= 100) {
                // Over budget
                $insights[] = [
                    'type'    => 'danger',
                    'icon'    => 'fas fa-circle-xmark',
                    'message' => "{$budget->category->name} budget is over limit! You exceeded by NPR " . number_format(abs($budget->remaining), 2),
                ];
            } elseif ($budget->percentage >= 80) {
                // Near budget limit
                $insights[] = [
                    'type'    => 'warning',
                    'icon'    => 'fas fa-circle-exclamation',
                    'message' => "{$budget->category->name} budget is {$budget->percentage}% used — NPR " . number_format($budget->remaining, 2) . " remaining.",
                ];
            }
        }

        // ===== INSIGHT 5: REMAINING BUDGET =====
        if ($budgets->count() > 0) {
            $totalBudget    = $budgets->sum('amount');
            $totalSpent     = $budgets->sum('spent');
            $totalRemaining = $totalBudget - $totalSpent;

            if ($totalRemaining > 0) {
                $insights[] = [
                    'type'    => 'info',
                    'icon'    => 'fas fa-wallet',
                    'message' => "You have NPR " . number_format($totalRemaining, 2) . " remaining across all your budgets this month.",
                ];
            }
        }

        // ===== INSIGHT 6: INCOME TREND =====
        $lastMonthIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereMonth('date', now()->subMonth()->month)
            ->whereYear('date', now()->subMonth()->year)
            ->sum('amount');

        if ($lastMonthIncome > 0 && $totalIncome > 0) {
            $incomeDiff = $totalIncome - $lastMonthIncome;

            if ($incomeDiff > 0) {
                $insights[] = [
                    'type'    => 'success',
                    'icon'    => 'fas fa-arrow-trend-up',
                    'message' => "Your income increased by NPR " . number_format($incomeDiff, 2) . " compared to last month! 📈",
                ];
            } elseif ($incomeDiff < 0) {
                $insights[] = [
                    'type'    => 'warning',
                    'icon'    => 'fas fa-arrow-trend-down',
                    'message' => "Your income decreased by NPR " . number_format(abs($incomeDiff), 2) . " compared to last month.",
                ];
            }
        }

        // ===== NO INSIGHTS =====
        // Show helpful message if no data yet
        if (empty($insights)) {
            $insights[] = [
                'type'    => 'info',
                'icon'    => 'fas fa-lightbulb',
                'message' => "Add transactions and set budgets to see personalized insights here!",
            ];
        }

        return $insights;
    }
}