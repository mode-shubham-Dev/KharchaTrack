<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('user_id', auth()->id())
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        $incomeCategories = $categories->where('type', 'income');
        $expenseCategories = $categories->where('type', 'expense');

        return view('dashboard.pages.categories.index', compact('incomeCategories', 'expenseCategories'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pages.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        Category::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'color' => $validated['color'],
            'type' => $validated['type'],
            'is_default' => false
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('dashboard.pages.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $category->update($request->validated());

        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        if ($category->transactions()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'Cannot delete category with existing transactions!');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category delted successfully!');
    }
}
