<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\StoreTransactionRequest;
use App\Http\Requests\Transaction\UpdateTransactionRequest;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // ===== GET FILTER VALUES FROM URL =====
        $type       = $request->input('type');
        $month      = $request->input('month');
        $search     = $request->input('search');
        $categoryId = $request->input('category_id');

        // ===== BUILD QUERY DYNAMICALLY =====
        $query = Transaction::where('user_id', auth()->id())
            ->with('category')
            ->orderBy('date', 'desc');

        // Add type filter if selected
        if ($type) {
            $query->where('type', $type);
        }

        // Add month filter if selected otherwise default current month
        if ($month) {
            $query->whereYear('date', substr($month, 0, 4))
                  ->whereMonth('date', substr($month, 5, 2));
        } else {
            $query->currentMonth();
        }

        // Add category filter if selected
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Add search filter if entered
        if ($search) {
            $query->where('note', 'like', '%' . $search . '%');
        }

        // Execute with pagination — withQueryString keeps filters in page links
        $transactions = $query->paginate(10)->withQueryString();

        // ===== FILTERED SUMMARY =====
        // Build fresh queries for summary — same filters applied
        $summaryBase = Transaction::where('user_id', auth()->id())
            ->when($month, fn($q) =>
                $q->whereYear('date', substr($month, 0, 4))
                  ->whereMonth('date', substr($month, 5, 2)))
            ->when(!$month, fn($q) => $q->currentMonth())
            ->when($categoryId, fn($q) =>
                $q->where('category_id', $categoryId))
            ->when($search, fn($q) =>
                $q->where('note', 'like', '%' . $search . '%'));

        $filteredIncome  = (clone $summaryBase)->where('type', 'income')->sum('amount');
        $filteredExpense = (clone $summaryBase)->where('type', 'expense')->sum('amount');
        $filteredBalance = $filteredIncome - $filteredExpense;

        // ===== CATEGORIES FOR DROPDOWN =====
        $categories = Category::where('user_id', auth()->id())
            ->orderBy('name')
            ->get();

        return view('dashboard.pages.transactions.index', compact(
            'transactions',
            'categories',
            'filteredIncome',
            'filteredExpense',
            'filteredBalance',
            'type',
            'month',
            'search',
            'categoryId'
        ));
    }

    public function create()
    {
        $categories = Category::where('user_id', auth()->id())
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        return view('dashboard.pages.transactions.create', compact('categories'));
    }

    public function store(StoreTransactionRequest $request)
    {
        $validated = $request->validated();

        Transaction::create([
            'user_id'     => auth()->id(),
            'category_id' => $validated['category_id'],
            'type'        => $validated['type'],
            'amount'      => $validated['amount'],
            'note'        => $validated['note'] ?? null,
            'date'        => $validated['date'],
        ]);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction added successfully!');
    }

    public function show(Transaction $transaction)
    {
        //
    }

    public function edit(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $categories = Category::where('user_id', auth()->id())
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        return view('dashboard.pages.transactions.edit',
            compact('transaction', 'categories')
        );
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $transaction->update($request->validated());

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction updated successfully!');
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully!');
    }
}