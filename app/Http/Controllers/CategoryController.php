<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Fungsi ini digunakan untuk menampilkan daftar kategori
    public function index(Request $request)
    {
        $query = Category::query();
        if ($request->search) {
            $query->where('name', 'like', "%$request->search%");
        }
        $category = $query->get();

        return view('categories.index', ['categories' => $category]);
    }

    /**
     * Show the form for creating a new resource.
     */

    // Fungsi ini digunakan untuk menampilkan form tambah kategori
    public function create()
    {
        //
        return view('categories.create');
    }

    // Fungsi ini digunakan untuk menyimpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|string|max:255',
        ]);
        $isActive = $request->has('is_active') ? true : false;
        Category::create([
            'name' => $request->name,
            'is_active' => $isActive
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    // Fungsi ini digunakan untuk menampilkan form edit kategori
    public function edit(Category $category)
    {
        return view('categories.edit', ['category' => $category]);
    }

    // Fungsi ini digunakan untuk memperbarui kategori
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);
        $isActive = $request->has('is_active') ? true : false;

        $category->update([
            'name' => $request->name,
            'is_active' => $isActive,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    // Fungsi ini digunakan untuk menghapus kategori
    public function destroy(Category $category)
    {
        //
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
