<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Menampilkan daftar transaksi
        $transactions = Transaction::where('user_id', Auth::id())->with('details.product')->get();
        return view('transactions.index', ['transactions' => $transactions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function checkout(Request $request)
    {
        //
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        };

        // Simpan transaksi ke database
        $transaction = Transaction::create([
            'order_id' => 'TRX-' . time(),
            'user_id' => Auth::id(),
            'gross_amount' => collect($cart)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            }),
            'payment_type' => 'prepaid',
            'status' => 'pending',
        ]);

        // Simpan detail transaksi
        foreach ($cart as $id => $item) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Konfigurasi midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // Data untuk midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $transaction->order_id,
                'gross_amount' => $transaction->gross_amount,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'item_details' => collect($cart)->map(function ($item, $id) {
                return [
                    'id' => $id,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'name' => $item['name'],
                ];
            })->toArray(),
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            if (!$snapToken) {
                throw new \Exception('Snap Token gagal dibuat.');
            }
            // Simpan snap token ke database
            $transaction->snap_token = $snapToken;
            $transaction->save();
            // Kosongkan keranjang
            session()->forget('cart');

            return view('transaction.information', ['transaction' => $transaction]);
        } catch (\Exception $e) {
            return redirect()->route('cart.view')->with('error', 'Terjadi kesalahan saat proses checkout' . $e->getMessage());
        }
    }
    public function chechoutInformation($id)
    {
        $transaction = Transaction::with('details.product')->findOrFail($id);
        return view('transaction.information', ['transaction' => $transaction]);
    }

    // Fungsi untuk membatalkan transaksi
    public function cancel($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status !== 'pending') {
            return redirect()->route('transactions.index')->with('error', 'Transaksi tidak dapat dibatalkan.');
        }

        $transaction->status = 'cancelled';
        $transaction->save();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dibatalkan.');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Menyimpan transaksi baru
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
