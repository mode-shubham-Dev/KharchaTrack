<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

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

        foreach ($users as $user) {
            foreach ($defaultCategories as $category) {
                $exists = Category::where('user_id', $user->id)->where('name', $category['name'])->exists();

                if (!$exists) {
                    Category::create([
                        'user_id'    => $user->id,
                        'name'       => $category['name'],
                        'color'      => $category['color'],
                        'type'       => $category['type'],
                        'is_default' => true,
                    ]);
                }
            }
        }
    }
}
