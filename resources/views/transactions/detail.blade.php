@extends('layouts.landing')

@section('title', 'Detail Transaksi')

@section('content')
    <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
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
                    @elseif ($transaction->shipping_status === 'processed')
                        <span class="badge bg-info">Diproses</span>
                    @elseif ($transaction->shipping_status === 'shipped')
                        <span class="badge bg-primary">Dikirim</span>
                    @elseif ($transaction->shipping_status === 'completed')
                        <span class="badge bg-success">Diterima</span>
                    @elseif ($transaction->shipping_status === 'cancelled')
                        <span class="badge bg-danger">Dibatalkan</span>
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


        {{-- Feedback Section --}}
        @if ($transaction->status === 'success')
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Feedback Anda</h5>
                </div>
                <div class="card-body">
                    @if ($transaction->feedback)
                        <div class="alert alert-success" role="alert">
                            Terima kasih telah memberikan feedback!
                        </div>
                        <p>{{ $transaction->feedback }}</p>
                    @else
                        <div class="alert alert-info" role="alert">
                            Anda dapat memberikan feedback setelah transaksi selesai.
                        </div>
                        <form action="{{ route('transactions.feedback', $transaction->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="feedback" class="form-label">Berikan Feedback</label>
                                <textarea name="feedback" id="feedback" class="form-control" rows="4"
                                    placeholder="Tulis feedback Anda di sini..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim Feedback</button>
                        </form>
                    @endif
                </div>
            </div>
        @else
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Feedback</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-secondary" role="alert">
                        Feedback hanya dapat diberikan setelah transaksi selesai.
                    </div>
                </div>
            </div>
        @endif

        <a href="{{ route('transactions.index') }}" class="btn btn-secondary mt-4">Kembali ke Daftar Transaksi</a>
    </div>
@endsection
