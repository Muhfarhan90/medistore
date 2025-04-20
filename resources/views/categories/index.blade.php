@extends('layouts.app')

@section('heading', 'Category')

@section('content')
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="d-flex justify-content-between mb-2">
        <form class="d-flex gap-2" method="get">
            <input type="text" class="form-control w-auto" placeholder="Cari category" name="search"
                value="{{ request()->search }}">
            <button type="submit" class="btn btn-dark">Cari</button>
        </form>
        <a href="{{ route('categories.create') }}" class="btn btn-dark ">
            Tambah
        </a>
    </div>

    <div class="card overflow-hidden">

        <table class="table table-responsive m-0">
            <thead>
                <tr>
                    <td>#</td>
                    <th scope="col">Nama</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        @if ($category->is_active == 1)
                            <td><button class="btn btn-info btn-sm" disabled>Aktif</button></td>
                        @else
                            <td><button class="btn btn-danger btn-sm" disabled>Tidak</button></td>
                        @endif
                        <td>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('categories.edit', ['category' => $category->id]) }}"
                                    class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('categories.destroy', parameters: ['category' => $category->id]) }}"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm">Hapus</button>

                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>

                        <td colspan="3" class="text-center">Belum ada category</td>
                    </tr>
                @endforelse



            </tbody>
        </table>
    </div>
@endsection
