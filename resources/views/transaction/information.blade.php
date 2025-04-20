@extends('layouts.landing')

@section('title', 'Informasi Checkout')

@section('content')
    <div class="container mt-5">
        <h1>Informasi Checkout</h1>
        <div class="mb-3">
            <strong>Nama:</strong> {{ Auth::user()->name }}
        </div>
        <div class="mb-3">
            <strong>Email:</strong> {{ Auth::user()->email }}
        </div>
        <div class="mb-3">
            <strong>Total Pembayaran:</strong> Rp{{ number_format($transaction->gross_amount, 0, ',', '.') }}
        </div>

        <h3>Detail Keranjang</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaction->details as $detail)
                    <tr>
                        <td>{{ $detail->product->name }}</td>
                        <td>Rp{{ number_format($detail->price, 0, ',', '.') }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>Rp{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button id="pay-button" class="btn btn-success">Bayar Sekarang</button>
    </div>

    <script
        src="{{ config('midtrans.isProduction') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // SnapToken acquired from previous step
            snap.pay('{{ $transaction->snap_token }}', {
                // Optional
                onSuccess: function(result) {
                    /* You may add your own js here, this is just example */
                    window.location.href =
                        '{{ route('transaction.index', ['transaction' => $transaction->id]) }}';
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        };
    </script>
@endsection
