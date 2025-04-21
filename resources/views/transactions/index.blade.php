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
                                <span class="badge bg-warning text-dark">Belum Diproses</span>
                            @elseif ($transaction->shipping_status === 'processed')
                                {{-- <span class="badge bg-info">Diproses</span> --}}
                                <span class="badge bg-info">Diproses</span>
                            @elseif ($transaction->shipping_status === 'shipped')
                                <span class="badge bg-secondary">Dikirim</span>
                            @elseif ($transaction->shipping_status === 'completed')
                                <span class="badge bg-success">Selesai</span>
                            @elseif ($transaction->shipping_status === 'cancelled')
                                <span class="badge bg-danger">Dibatalkan</span>
                            @else
                                <span class="badge bg-secondary">Tidak Diketahui</span>
                            @endif
                        </td>
                        <td>
                            @if ($transaction->shipping_status === 'pending')
                                {{-- Tombol Batalkan --}}
                                <form action="{{ route('transactions.cancel', $transaction->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Batalkan</button>
                                </form>

                                {{-- Tombol Bayar --}}
                                <a href="{{ route('transactions.show', $transaction->id) }}"
                                    class="btn btn-success btn-sm">Bayar</a>
                            @elseif ($transaction->shipping_status === 'processed')
                                {{-- Tombol Batalkan --}}
                                <form action="{{ route('transactions.cancel', $transaction->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Batalkan</button>
                                </form>
                            @elseif ($transaction->shipping_status === 'shipped')
                                {{-- Tombol Diterima --}}
                                <form action="{{ route('transactions.confirm', $transaction->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Diterima</button>
                                </form>
                            @endif
                            {{-- Tombol Lihat Detail --}}
                            <a href="{{ route('transactions.detail', $transaction->id) }}"
                                class="btn btn-primary btn-sm">Lihat Detail</a>
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
