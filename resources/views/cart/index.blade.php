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
            <!-- Form untuk Checkout -->
            <form action="{{ route('checkout', $id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Checkout</button>
            </form>
        @endif
    </div>
@endsection
