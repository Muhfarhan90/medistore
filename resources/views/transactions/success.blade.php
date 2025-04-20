{{-- filepath: d:\Belajar Laravel\medistore\resources\views\transactions\success.blade.php --}}
@extends('layouts.landing')

@section('title', 'Pembayaran Berhasil')

@section('content')
    <div class="container mt-5">
        <div class="text-center">
            <h1 class="text-success">Pembayaran Berhasil!</h1>
            <p class="mt-3">Terima kasih telah melakukan pembayaran. Invoice anda telah dikirimkan melalui email. Pesanan Anda sedang diproses.</p>
            <a href="{{ route('transactions.index') }}" class="btn btn-primary mt-4">Lihat Daftar Transaksi</a>
        </div>
    </div>
@endsection
