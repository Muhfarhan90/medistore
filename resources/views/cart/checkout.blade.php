@extends('layouts.landing')

@section('title', 'Checkout')

@section('content')
    <div class="container mt-5">
        <h1>Checkout</h1>
        <div id="payment-button"></div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        var snapToken = "{{ $snapToken }}";
        snap.pay(snapToken, {
            onSuccess: function(result) {
                alert('Pembayaran berhasil!');
                console.log(result);
                window.location.href = "{{ route('home') }}"; // Redirect setelah pembayaran berhasil
            },
            onPending: function(result) {
                alert('Pembayaran tertunda!');
                console.log(result);
            },
            onError: function(result) {
                alert('Pembayaran gagal!');
                console.log(result);
            },
            onClose: function() {
                alert('Anda menutup pembayaran tanpa menyelesaikannya.');
            }
        });
    </script>
@endsection
