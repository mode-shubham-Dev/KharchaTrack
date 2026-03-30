<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // ===== PLATFORM WIDE STATS =====
        // No user filter — shows ALL platform data
        $totalUsers        = User::count();
        $totalTransactions = Transaction::count();
        $totalIncome       = Transaction::where('type', 'income')->sum('amount');
        $totalExpense      = Transaction::where('type', 'expense')->sum('amount');

        // ===== USERS LIST =====
        // with('roles') — eager load roles for badge display
        // withCount('transactions') — adds transactions_count to each user
        // latest() — newest users first
        $users = User::with('roles')
            ->withCount('transactions')
            ->latest()
            ->paginate(10);

        return view('dashboard.pages.admin.index', compact(
            'totalUsers',
            'totalTransactions',
            'totalIncome',
            'totalExpense',
            'users'
        ));
    }

    // ===== TOGGLE ADMIN/USER ROLE =====
    public function toggleRole(User $user)
    {
        // Prevent changing own role
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.index')
                ->with('error', 'You cannot change your own role!');
        }

        if ($user->hasRole('admin')) {
            $user->removeRole('admin');
            $user->assignRole('user');
            $message = $user->name . ' is now a regular user.';
        } else {
            $user->removeRole('user');
            $user->assignRole('admin');
            $message = $user->name . ' is now an admin.';
        }

        return redirect()->route('admin.index')
            ->with('success', $message);
    }

    // ===== TOGGLE ACTIVE/INACTIVE STATUS =====
    public function toggleStatus(User $user)
    {
        // Prevent deactivating own account
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.index')
                ->with('error', 'You cannot deactivate yourself!');
        }

        // Flip boolean — true becomes false, false becomes true
        $user->update(['is_active' => !$user->is_active]);

        // Fresh from DB to get updated value
        $user->refresh();

        $status  = $user->is_active ? 'activated' : 'deactivated';
        $message = $user->name . ' has been ' . $status . '.';

        return redirect()->route('admin.index')
            ->with('success', $message);
    }
}