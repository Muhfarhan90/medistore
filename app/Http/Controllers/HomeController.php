<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // Constructor untuk middleware
    public function __construct()
    {
        $this->middleware('auth')->except('home', 'show', 'view');
    }

    // Fungsi untuk menampilkan daftar produk
    public function view(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->get();
        $categories = Category::all();
        return view('customers.products', ['products' => $products, 'categories' => $categories]);
    }

    // Fungsi untuk menampilkan halaman utama
    public function home(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->get();
        $categories = Category::all();
        return view('customers.home', ['products' => $products, 'categories' => $categories]);
    }

    // Fungsi untuk menampilkan detail produk
    public function show($slug)
    {
        // Cari produk berdasarkan slug
        $product = Product::where('slug', $slug)->firstOrFail();

        // Kirim data produk ke view
        return view('customers.show', ['product' => $product]);
    }

    // Fungsi untuk melihat detail profil user
    public function profile()
    {
        $customer = Auth::user();
        return view('customers.profil', ['customer' => $customer]);
    }
}
