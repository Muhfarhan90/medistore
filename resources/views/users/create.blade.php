@extends('layouts.app')

@section('heading', 'Tambah User')

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="post">
                        @csrf

                        {{-- Nama --}}
                        <x-text-input label="Nama" name="name" placeholder="Masukkan nama pengguna"
                            value="{{ old('name') }}"></x-text-input>

                        {{-- Email --}}
                        <x-text-input label="Email" name="email" type="email" placeholder="Masukkan email pengguna"
                            value="{{ old('email') }}"></x-text-input>

                        {{-- Alamat --}}
                        <x-text-input label="Alamat" name="address" placeholder="Masukkan alamat pengguna"
                            value="{{ old('address') }}"></x-text-input>

                        {{-- Kontak --}}
                        <x-text-input label="Kontak" name="phone" placeholder="Masukkan nomor telepon pengguna"
                            value="{{ old('phone') }}"></x-text-input>

                        {{-- Tanggal Lahir --}}
                        <x-text-input label="Tanggal Lahir" name="date_of_birth" type="date"
                            value="{{ old('date_of_birth') }}"></x-text-input>

                        {{-- Gender --}}
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" id="gender" class="form-select">
                                <option value="" disabled selected>Pilih Gender</option>
                                <option value="male" @selected(old('gender') == 'male')>Laki-laki</option>
                                <option value="female" @selected(old('gender') == 'female')>Perempuan</option>
                            </select>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('users.index') }}" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-dark">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection