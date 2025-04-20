@extends('layouts.landing')

@section('title', 'Detail Transaksi')

@section('content')
    <div class="container mt-5">
        <h1>Detail Transaksi</h1>

        <div class="card mt-4">
            <div class="card-header">
                <h5>Informasi Transaksi</h5>
            </div>
            <div class="card-body">
                <p><strong>ID Transaksi:</strong> {{ $transaction->id }}</p>
                <p><strong>Order ID:</strong> {{ $transaction->order_id }}</p>
                <p><strong>Tanggal Transaksi:</strong> {{ $transaction->created_at->format('d-m-Y H:i:s') }}</p>
                <p><strong>Total Pembayaran:</strong> Rp{{ number_format($transaction->gross_amount, 0, ',', '.') }}</p>
                <p><strong>Status Transaksi:</strong>
                    @if ($transaction->status === 'success')
                        <span class="badge bg-success">Sukses</span>
                    @elseif ($transaction->status === 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @elseif ($transaction->status === 'cancelled')
                        <span class="badge bg-danger">Dibatalkan</span>
                    @else
                        <span class="badge bg-secondary">Tidak Diketahui</span>
                    @endif
                </p>
                <p><strong>Status Pengiriman:</strong>
                    @if ($transaction->shipping_status === 'pending')
                        <span class="badge bg-warning text-dark">Belum Dikirim</span>
                    @elseif ($transaction->shipping_status === 'shipped')
                        <span class="badge bg-primary">Dikirim</span>
                    @elseif ($transaction->shipping_status === 'delivered')
                        <span class="badge bg-success">Diterima</span>
                    @else
                        <span class="badge bg-secondary">Tidak Diketahui</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5>Detail Produk</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
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

        <a href="{{ route('transactions.index') }}" class="btn btn-secondary mt-4">Kembali ke Daftar Transaksi</a>
    </div>
@endsection
