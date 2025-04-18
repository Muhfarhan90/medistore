@extends('layouts.app')

@section('heading', 'Edit Produk')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('products.update', ['product' => $product->id] ?? '') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-control" id="category_id" name="category_id">
                                @forelse ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @empty
                                    <option value="">Belum ada category</option>
                                @endforelse
                            </select>
                        </div>
                        <x-text-input label="Nama" name="name" placeholder="Masukkan nama product"
                            value="{{ old('name', $product->name) }}"></x-text-input>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea name="description" placeholder="Masukkan deskripsi product" id="" class="form-control">{{ old('description', $product->description) }}</textarea>

                        </div>
                        <x-text-input label="Harga" name="price" placeholder="Masukkan harga product"
                            value="{{ old('price', $product->price) }}" type="number"></x-text-input>

                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar</label>
                            <input class="form-control" type="file" id="image" name="image"
                                accept="image/jpeg,image/png, image/jpg">
                            <div class="form-text">Kosongi gambar jika tidak ingin mengupdate</div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('products.index') }}" class="btn btn-danger">Batal</a>
                            <button class="btn btn-dark">Simpan</button>

                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
@endsection
