@extends('layouts.app')

@section('heading', 'Transactions')

@section('content')
    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Search Bar --}}
    {{-- <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <form class="d-flex gap-2 flex-wrap" method="get">
            <input type="text" class="form-control" placeholder="Cari Order ID / Produk" name="search"
                value="{{ request()->search }}">
            <button type="submit" class="btn btn-dark">Cari</button>
        </form>
    </div> --}}

    {{-- Tabel Transaksi --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Order ID</th>
                            <th scope="col">Total Transaksi</th>
                            <th scope="col">Tipe Pembayaran</th>
                            <th scope="col">Status Pembayaran</th>
                            <th scope="col">Status Pengiriman</th> {{-- Kolom baru --}}
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transaction->order_id }}</td>
                                <td>Rp{{ number_format($transaction->gross_amount, 0, ',', '.') }}</td>
                                <td>{{ ucfirst($transaction->payment_type) }}</td>
                                <td>
                                    @switch($transaction->status)
                                        @case('success')
                                            <span class="btn button-sm text-white bg-success">Sukses</span>
                                        @break

                                        @case('pending')
                                            <span class="btn button-sm text-white bg-warning text-dark">Pending</span>
                                        @break

                                        @case('cancelled')
                                            <span class="btn button-sm text-white bg-danger">Dibatalkan</span>
                                        @break

                                        @default
                                            <span
                                                class="btn button-sm text-white bg-secondary">{{ ucfirst($transaction->status) }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    @if ($transaction->shipping_status === 'pending')
                                        <span class="btn button-sm text-white bg-warning text-dark">Belum Diproses</span>
                                    @elseif ($transaction->shipping_status === 'processed')
                                        {{-- <span class="btn button-sm text-white bg-info">Diproses</span> --}}
                                        <span class="btn button-sm text-white bg-info">Diproses</span>
                                    @elseif ($transaction->shipping_status === 'shipped')
                                        <span class="btn button-sm text-white bg-secondary">Dikirim</span>
                                    @elseif ($transaction->shipping_status === 'completed')
                                        <span class="btn button-sm text-white bg-success">Selesai</span>
                                    @elseif ($transaction->shipping_status === 'cancelled')
                                        <span class="btn button-sm text-white bg-danger">Dibatalkan</span>
                                    @else
                                        <span class="btn button-sm text-white bg-secondary">Tidak Diketahui</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.transactions.detail', ['transaction' => $transaction->id]) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        Detail
                                    </a>
                                    @if ($transaction->shipping_status === 'processed')
                                        <form
                                            action="{{ route('admin.transactions.update-status', ['transaction' => $transaction->id]) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-success btn-sm">Kirim</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection
