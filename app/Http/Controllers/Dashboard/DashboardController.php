<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // ===== SUMMARY CARDS =====
        // Total income this month
        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->currentMonth()
            ->sum('amount');

        // Total expense this month
        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->currentMonth()
            ->sum('amount');

        // Net balance
        $netBalance = $totalIncome - $totalExpense;

        // Total transactions this month
        $totalTransactions = Transaction::where('user_id', $userId)
            ->currentMonth()
            ->count();

        // ===== PIE CHART DATA =====
        // Spending by category this month
        $spendingByCategory = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->currentMonth()
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->groupBy('category_id')
            ->with('category')
            ->get()
            ->map(function ($item) {
                return [
                    'name'   => $item->category->name,
                    'total'  => $item->total,
                    'color'  => $item->category->color,
                ];
            });

        // ===== BAR CHART DATA =====
        // Income vs Expense last 6 months
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

        return view('dashboard.pages.dashboard.index', compact(
            'totalIncome',
            'totalExpense',
            'netBalance',
            'totalTransactions',
            'spendingByCategory',
            'last6Months',
            'recentTransactions'
        ));
    }
}