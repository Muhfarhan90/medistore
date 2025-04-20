@extends('layouts.landing')

@section('title', 'Keranjang Belanja')

@section('content')
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="container mt-5">
        <h1>Keranjang Belanja</h1>

        @if (empty($cart))
            <p>Keranjang Anda kosong.</p>
            @auth
                <a href="{{ route('products.view') }}" class="btn btn-success">Cari Produk</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-success">Login untuk menambah keranjang</a>
            @endauth
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $id => $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                            class="form-control d-inline" style="width: 70px;">
                                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                    </form>
                                </td>
                                <td>Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-right">
                <h4>Total:
                    Rp{{ number_format(
                        collect($cart)->sum(function ($item) {
                            return $item['price'] * $item['quantity'];
                        }),
                        0,
                        ',',
                        '.',
                    ) }}
                </h4>
            </div>
            <div class="d-flex justify-content-between mt-3">
                <!-- Form untuk Checkout -->
                <form action="{{ route('transactions.checkout') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="payment_type" class="form-label">Metode Pembayaran</label>
                        <select name="payment_type" id="payment_type" class="form-select" required>
                            <option value="prepaid">Bayar dengan Midtrans</option>
                            <option value="postpaid">Bayar Tunai</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Checkout</button>
                </form>
                <a href="{{ route('products.view') }}" class="btn btn-success">Tambah Produk</a>
            </div>
        @endif
    </div>
@endsection