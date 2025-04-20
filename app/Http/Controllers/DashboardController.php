<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $earnings = Transaction::where('status', 'success')->sum('gross_amount');
        $successTransactions = Transaction::where('status', 'success')->count();
        $pendingTransactions = Transaction::where('status', 'pending')->count();
        $failedTransactions = Transaction::where('status', 'cancelled')->count();
        $totalUsers = User::distinct('id')->count('id');
        $totalProducts = Product::distinct('id')->count('id');
        $totalCategories = Category::distinct('id')->count('id');
        $totalTransactions = Transaction::count();
        return view('dashboard', [
            'earnings' => $earnings,
            'successTransactions' => $successTransactions,
            'pendingTransactions' => $pendingTransactions,
            'failedTransactions' => $failedTransactions,
            'totalUsers' => $totalUsers,
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalTransactions' => $totalTransactions,
        ]);
    }
}
