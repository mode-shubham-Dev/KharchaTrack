<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // ===== VALIDATE =====
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // ===== CREATE USER =====
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'is_active' => true,
        ]);

        // ===== ASSIGN DEFAULT ROLE =====
        $user->assignRole('user');

        // ===== CREATE DEFAULT CATEGORIES =====
        $defaultCategories = [
            ['name' => 'Food & Drinks',  'color' => '#ef4444', 'type' => 'expense'],
            ['name' => 'Rent',           'color' => '#f59e0b', 'type' => 'expense'],
            ['name' => 'Transport',      'color' => '#3b82f6', 'type' => 'expense'],
            ['name' => 'Health',         'color' => '#22c55e', 'type' => 'expense'],
            ['name' => 'Shopping',       'color' => '#a855f7', 'type' => 'expense'],
            ['name' => 'Entertainment',  'color' => '#ec4899', 'type' => 'expense'],
            ['name' => 'Utilities',      'color' => '#14b8a6', 'type' => 'expense'],
            ['name' => 'Other Expense',  'color' => '#64748b', 'type' => 'expense'],
            ['name' => 'Salary',         'color' => '#22c55e', 'type' => 'income'],
            ['name' => 'Freelance',      'color' => '#6366f1', 'type' => 'income'],
            ['name' => 'Business',       'color' => '#f59e0b', 'type' => 'income'],
            ['name' => 'Investment',     'color' => '#3b82f6', 'type' => 'income'],
            ['name' => 'Other Income',   'color' => '#64748b', 'type' => 'income'],
        ];

        foreach ($defaultCategories as $category) {
            Category::create([
                'user_id'    => $user->id,
                'name'       => $category['name'],
                'color'      => $category['color'],
                'type'       => $category['type'],
                'is_default' => true,
            ]);
        }

        // ===== FIRE REGISTERED EVENT =====
        event(new Registered($user));

        // ===== LOGIN USER =====
        Auth::login($user);

        // ===== REDIRECT TO DASHBOARD =====
        return redirect(route('dashboard', absolute: false));
    }
}