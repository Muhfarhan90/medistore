@extends('layouts.app')

@section('heading', 'Products')

@section('content')
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="d-flex justify-content-between mb-2">
        <form class="d-flex gap-2" method="get">
            <input type="text" class="form-control w-auto" placeholder="Cari product" name="search"
                value="{{ request()->search }}">
            <button type="submit" class="btn btn-dark">Cari</button>
        </form>
        <a href="{{ route('products.create') }}" class="btn btn-dark ">
            Tambah
        </a>
    </div>

    <div class="card overflow-hidden">

        <table class="table table-responsive m-0">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Image</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->price }}</td>
                        <td><img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                class="w-thumbnail img-thumbnail">
                        </td>
                        <td>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('products.edit', ['product' => $product->id]) }}"
                                    class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('products.destroy', ['product' => $product->id]) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm">Hapus</button>

                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>

                        <td colspan="6" class="text-center">Belum ada product</td>
                    </tr>
                @endforelse



            </tbody>
        </table>
    </div>
@endsection
