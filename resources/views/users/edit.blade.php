@extends('layouts.app')

@section('heading', 'Edit User')

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        {{-- Nama --}}
                        <x-text-input label="Nama" name="name" placeholder="Masukkan nama pengguna"
                            value="{{ old('name', $user->name) }}"></x-text-input>

                        {{-- Email --}}
                        <x-text-input label="Email" name="email" type="email" placeholder="Masukkan email pengguna"
                            value="{{ old('email', $user->email) }}"></x-text-input>

                        {{-- Alamat --}}
                        <x-text-input label="Alamat" name="address" placeholder="Masukkan alamat pengguna"
                            value="{{ old('address', $user->address) }}"></x-text-input>

                        {{-- Kontak --}}
                        <x-text-input label="Kontak" name="phone" placeholder="Masukkan nomor telepon pengguna"
                            value="{{ old('phone', $user->phone) }}"></x-text-input>

                        {{-- Tanggal Lahir --}}
                        <x-text-input label="Tanggal Lahir" name="birth_date" type="date"
                            value="{{ old('birth_date', $user->birth_date) }}"></x-text-input>

                        {{-- Gender --}}
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" id="gender" class="form-select">
                                <option value="" disabled>Pilih Gender</option>
                                <option value="male" @selected(old('gender', $user->gender) == 'male')>Laki-laki</option>
                                <option value="female" @selected(old('gender', $user->gender) == 'female')>Perempuan</option>
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
