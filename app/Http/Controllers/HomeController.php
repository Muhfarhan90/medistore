<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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

    public function home()
    {
        $products = Product::all();
        return view('customers.home', ['products' => $products]);
    }

    public function show($id) {
        $product = Product::find($id);
        return view('customers.show', ['product' => $product]);
    }
}
