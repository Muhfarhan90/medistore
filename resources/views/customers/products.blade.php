@extends('layouts.landing')

@section('title', 'Products')

@section('content')
    <div class="row mt-4">
        <h1>Produk</h1>
        <!-- Bagian Kanan: Search dan Kategori -->
        <div class="col-md-3">
            <!-- Search Bar -->
            <div class="mb-4">
                <form action="{{ route('products.view') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari produk..."
                            value="{{ request('search') }}">
                        <button class="btn btn-success" type="submit">Cari</button>
                    </div>
                </form>
            </div>

            <!-- Kategori -->
            <div class="mb-4">
                <h5 class="text-success">Kategori</h5>
                <ul class="list-group">
                    @foreach ($categories as $category)
                        <li class="list-group-item">
                            <a href="{{ route('products.view', ['category' => $category->id]) }}" class="text-success">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Bagian Kiri: Produk -->
        <div class="col-md-9">
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-5 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset('storage/' . $product['image']) }}" class="card-img-top"
                                alt="{{ $product['name'] }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title text-success">{{ $product['name'] }}</h5>
                                <p class="card-text text-muted" style="font-size: 14px;">
                                    {{ Str::limit($product['description'], 50) }}
                                </p>
                                <div class="d-flex gap-2 align-items-center">
                                    <a href="{{ route('products.show', $product['slug']) }}"
                                        class="btn btn-success btn-sm">Detail</a>
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $product['id'] }}">
                                        <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                        <input type="hidden" name="price" value="{{ $product['price'] }}">
                                        @auth
                                            <button type="submit" class="btn btn-success btn-sm">Tambah Keranjang</button>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-success btn-sm">Login untuk
                                                membeli</a>
                                        @endauth
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
