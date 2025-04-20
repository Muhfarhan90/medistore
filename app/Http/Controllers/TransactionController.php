<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;
use Midtrans\Snap;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Mendapatkan daftar transaksi untuk admin
        if (Auth::user()->role->name == 'superadmin') {
            $transactions = Transaction::with('user')->get();
            return view('transactions.index-admin', ['transactions' => $transactions]);
        }
        //Menampilkan daftar transaksi untuk customer
        $transactions = Transaction::where('user_id', Auth::id())->with('details.product')->get();
        return view('transactions.index', ['transactions' => $transactions]);
    }


    /**
     * Show the form for creating a new resource.
     */

    public function checkout(Request $request)
    {
        $request->validate([
            'payment_type' => 'required|in:prepaid,cash',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Keranjang Anda kosong.');
        }

        // Validasi data keranjang
        foreach ($cart as $id => $item) {
            if (!isset($item['name'], $item['price'], $item['quantity'])) {
                return redirect()->route('cart.view')->with('error', 'Data keranjang tidak valid.');
            }

            if (!is_numeric($item['price']) || !is_numeric($item['quantity'])) {
                return redirect()->route('cart.view')->with('error', 'Harga dan jumlah harus berupa angka.');
            }
        }

        // Hitung total gross_amount
        $grossAmount = collect($cart)->sum(function ($item) {
            return (int) $item['price'] * (int) $item['quantity'];
        });

        // Simpan transaksi ke database
        $transaction = Transaction::create([
            'order_id' => 'TRX-' . time(),
            'user_id' => Auth::id(),
            'gross_amount' => $grossAmount,
            'payment_type' => $request->payment_type,
            'status' => $request->payment_type === 'cash' ? 'pending' : 'pending', // Status awal untuk cash dan prepaid
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

        // Kosongkan keranjang
        session()->forget('cart');

        // Jika pembayaran menggunakan cash (postpaid)
        if ($request->payment_type === 'cash') {
            return redirect()->route('transactions.success', $transaction->id)
                ->with('success', 'Pesanan Anda berhasil dibuat. Silakan lakukan pembayaran tunai.');
        }

        // Jika pembayaran menggunakan Midtrans (prepaid)
        return $this->processMidtransPayment($transaction, $cart);
    }

    protected function processMidtransPayment($transaction, $cart)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        // Data untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $transaction->order_id,
                'gross_amount' => (int) $transaction->gross_amount,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'item_details' => collect($cart)->map(function ($item, $id) {
                return [
                    'id' => $id,
                    'price' => (int) $item['price'],
                    'quantity' => (int) $item['quantity'],
                    'name' => $item['name'],
                ];
            })->values()->toArray(),
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            if (!$snapToken) {
                throw new \Exception('Snap Token gagal dibuat.');
            }

            // Simpan Snap Token ke database
            $transaction->snap_token = $snapToken;
            $transaction->save();

            return view('transactions.show', ['transaction' => $transaction, 'snapToken' => $snapToken]);
        } catch (\Exception $e) {
            return redirect()->route('cart.view')->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }
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
        // Menampilkan detail transaksi
        $transaction = Transaction::with('details.product')->findOrFail($id);
        return view('transactions.show', ['transaction' => $transaction]);
    }

    public function checkoutSuccess(Transaction $transaction)
    {
        $transaction->status = 'success';
        $transaction->save();

        // Kirim email invoice ke pengguna
        try {
            Mail::to($transaction->user->email)->send(new InvoiceMail($transaction));
        } catch (\Exception $e) {
            return redirect()->route('transactions.index')->with('error', 'Pembayaran berhasil, tetapi gagal mengirim email: ' . $e->getMessage());
        }

        // Menampilkan halaman sukses setelah pembayaran
        return view('transactions.success');
    }

    public function detail(string $id)
    {
        // Menampilkan detail transaksi untuk admin
        if (Auth::user()->role->name == 'superadmin') {
            $transaction = Transaction::with('user', 'details.product')->findOrFail($id);
            return view('transactions.detail-admin', ['transaction' => $transaction]);
        }
        // Menampilkan detail transaksi
        $transaction = Transaction::with('details.product')->findOrFail($id);
        return view('transactions.detail', ['transaction' => $transaction]);
    }

    public function feedback(Request $request, $id)
    {
        $request->validate([
            'feedback' => 'required|string|max:1000',
        ]);

        $transaction = Transaction::findOrFail($id);

        // Cek apakah feedback sudah ada
        if ($transaction->feedback) {
            return redirect()->route('transactions.detail', $id)->with('error', 'Feedback sudah pernah dikirim.');
        }

        $transaction->feedback = $request->feedback;
        $transaction->save();

        return redirect()->route('transactions.detail', $id)->with('success', 'Feedback Anda telah berhasil dikirim.');
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
