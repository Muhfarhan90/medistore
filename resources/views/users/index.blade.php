@extends('layouts.app')

@section('heading', 'Users')

@section('content')
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="d-flex justify-content-between mb-2">
        <form class="d-flex gap-2" method="get">
            <input type="text" class="form-control w-auto" placeholder="Cari user" name="search"
                value="{{ request()->search }}">
            <button type="submit" class="btn btn-dark">Cari</button>
        </form>
        <a href="{{ route('users.create') }}" class="btn btn-dark ">
            Tambah
        </a>
    </div>

    <div class="card overflow-hidden">

        <table class="table m-0">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Kota</th>
                    <th scope="col">Paypal_ID</th>
                    <th scope="col">Kontak</th>
                    <th scope="col">Tanggal Lahir</th>
                    <th scope="col">Gender</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->address ?? 'N/A' }}</td>
                        <td>{{ $user->city ?? 'N/A' }}</td>
                        <td>{{ $user->paypal_id ?? 'N/A' }}</td>
                        <td>{{ $user->phone ?? 'N/A' }}</td>
                        <td>{{ $user->date_of_birth ?? 'N/A' }}</td>
                        <td>{{ ucfirst($user->gender ?? 'N/A') }}</td>
                        <td>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                                    class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Belum ada user</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection