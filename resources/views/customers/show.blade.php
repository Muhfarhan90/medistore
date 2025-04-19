@extends('layouts.landing')

@section('title', 'Detail Produk')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ url()->previous() }}" class="btn btn-success mb-3">Kembali</a>
                <div class="row">
                    <!-- Gambar Produk -->
                    <div class="col-md-4">
                        <img src="{{ asset('storage/' . $product['image']) }}" class="img-fluid shadow-sm border border-success"
                            alt="{{ $product['name'] }}" style="border-radius: 10px;">
                    </div>

                    <!-- Detail Produk -->
                    <div class="col-md-8">
                        <h1 class="text-success">{{ $product['name'] }}</h1>
                        <p class="text-muted">{{ $product['description'] }}</p>
                        <h4 class="text-success">Rp{{ number_format($product['price'], 0, ',', '.') }}</h4>
                        <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product['id'] }}">
                            <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                            <input type="hidden" name="price" value="{{ $product['price'] }}">
                            @auth
                                <button type="submit" class="btn btn-success btn-lg">Tambah Keranjang</button>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-success btn-lg">Login untuk membeli</a>
                            @endauth
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
