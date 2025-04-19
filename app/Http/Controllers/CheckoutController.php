<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function processCheckout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melanjutkan ke checkout.');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Keranjang Anda kosong.');
        }

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // Data transaksi
        $transactionDetails = [
            'order_id' => uniqid(),
            'gross_amount' => collect($cart)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            }),
        ];

        $itemDetails = [];
        foreach ($cart as $id => $item) {
            $itemDetails[] = [
                'id' => $id,
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'name' => $item['name'],
            ];
        }

        $customerDetails = [
            'first_name' => Auth::user()->name,
            'email' => Auth::user()->email,
        ];

        $params = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            // Simpan Snap Token ke session atau database jika diperlukan
            session()->put('snap_token', $snapToken);

            return view('cart.checkout', compact('snapToken'));
        } catch (\Exception $e) {
            return redirect()->route('cart.view')->with('error', 'Terjadi kesalahan saat memproses pembayaran.');
        }
    }
}