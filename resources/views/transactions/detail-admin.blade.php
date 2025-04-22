@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="container my-5">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <h1 class="mb-4 text-center">Detail Transaksi</h1>
        </div>

        {{-- Informasi Transaksi --}}
        <div class="col-12 col-lg-8 mx-auto">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Transaksi</h5>
                </div>
                <div class="card-body">
                    <p><strong>ID Transaksi:</strong> {{ $transaction->id }}</p>
                    <p><strong>Order ID:</strong> {{ $transaction->order_id }}</p>
                    <p><strong>Tanggal Transaksi:</strong> {{ $transaction->created_at->format('d-m-Y H:i:s') }}</p>
                    <p><strong>Total Pembayaran:</strong> Rp{{ number_format($transaction->gross_amount, 0, ',', '.') }}</p>
                    <p><strong>Status Transaksi:</strong>
                        @if ($transaction->status === 'success')
                            <span class="badge text-white bg-success">Sukses</span>
                        @elseif ($transaction->status === 'pending')
                            <span class="badge text-white bg-warning text-dark">Pending</span>
                        @elseif ($transaction->status === 'cancelled')
                            <span class="badge text-white bg-danger">Dibatalkan</span>
                        @else
                            <span class="badge text-white bg-secondary">Tidak Diketahui</span>
                        @endif
                    </p>
                    <p><strong>Status Pengiriman:</strong>
                        @if ($transaction->shipping_status === 'pending')
                            <span class="badge text-white bg-warning text-dark">Belum Dikirim</span>
                        @elseif ($transaction->shipping_status === 'shipped')
                            <span class="badge text-white bg-primary">Dikirim</span>
                        @elseif ($transaction->shipping_status === 'delivered')
                            <span class="badge text-white bg-success">Diterima</span>
                        @else
                            <span class="badge text-white bg-secondary">Tidak Diketahui</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        {{-- Detail Produk --}}
        {{-- <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Detail Produk</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaction->details as $detail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $detail->product->name }}</td>
                                    <td>Rp{{ number_format($detail->price, 0, ',', '.') }}</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td>Rp{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}

        {{-- Back Button --}}
        <div class="col-12 text-center">
            <a href="{{ route('admin.transactions') }}" class="btn btn-outline-secondary mt-3">← Kembali ke Daftar Transaksi</a>
        </div>
    </div>
</div>
@endsection
