<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard');
    }

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
    public function show($slug)
    {
        // Cari produk berdasarkan slug
        $product = Product::where('slug', $slug)->firstOrFail();
    
        // Kirim data produk ke view
        return view('customers.show', ['product' => $product]);
    }
    public function profile()
    {
        $customer = Auth::user();
        return view('customers.profil', ['customer' => $customer]);
    }
    
}
