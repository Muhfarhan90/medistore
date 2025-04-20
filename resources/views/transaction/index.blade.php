@extends('layouts.landing')

@section('title', 'Daftar Transaksi')

@section('content')
    <div class="container mt-5">
        <h1>Daftar Transaksi</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Total Pembayaran</th>
                    <th>Status Transaksi</th>
                    <th>Status Pengiriman</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $transaction)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                        <td>Rp{{ number_format($transaction->gross_amount, 0, ',', '.') }}</td>
                        <td>
                            @if ($transaction->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif ($transaction->status === 'success')
                                <span class="badge bg-success">Sukses</span>
                            @elseif ($transaction->status === 'cancelled')
                                <span class="badge bg-danger">Dibatalkan</span>
                            @else
                                <span class="badge bg-secondary">Tidak Diketahui</span>
                            @endif
                        </td>
                        <td>
                            @if ($transaction->shipping_status === 'pending')
                                <span class="badge bg-warning text-dark">Belum Dikirim</span>
                            @elseif ($transaction->shipping_status === 'shipped')
                                <span class="badge bg-primary">Dikirim</span>
                            @elseif ($transaction->shipping_status === 'delivered')
                                <span class="badge bg-success">Diterima</span>
                            @else
                                <span class="badge bg-secondary">Tidak Diketahui</span>
                            @endif
                        </td>
                        <td>
                            @if ($transaction->status === 'pending')
                                <form action="{{ route('transactions.cancel', $transaction->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Batalkan</button>
                                </form>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>Tidak Tersedia</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection