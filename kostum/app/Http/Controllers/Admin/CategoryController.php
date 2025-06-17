<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\MassDestroyCategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories')); // sesuaikan dengan view yang digunakan
    }

    // Menambahkan create() untuk form pembuatan kategori
    public function create()
    {
        return view('admin.categories.create'); // Pastikan path view ini benar
    }

    public function store(StoreCategoryRequest $request)
    {
        // Validasi dilakukan di StoreCategoryRequest
        $category = Category::create([
            'nama' => $request->validated()['nama'],
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        // Validasi dilakukan di UpdateCategoryRequest
        $category->update([
            'nama' => $request->validated()['nama'],
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }

    public function massDestroy(MassDestroyCategoryRequest $request)
    {
        Category::whereIn('id', $request->validated()['ids'])->delete();

        return response()->json(['success' => 'Categories deleted successfully.']);
    }
}
