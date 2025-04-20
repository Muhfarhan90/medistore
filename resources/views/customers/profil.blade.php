@extends('layouts.landing')

@section('title', 'Profil Saya')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <!-- Bagian Kiri: Foto Profil -->
            <div class="col-md-4 text-center">
                <div class="card shadow-sm">
                    <div class="card-body">
                        {{-- <img src="{{ asset('storage/' . $customer->profile_image ?? 'style/img/default-profile.png') }}"
                            alt="Foto Profil" class="img-fluid rounded-circle mb-3"
                            style="width: 150px; height: 150px; object-fit: cover;"> --}}
                        <h5 class="card-title">{{ $customer->name }}</h5>
                        <p class="text-muted">{{ $customer->email }}</p>
                        {{-- <a href="{{ route('profile') }}" class="btn btn-success">Edit Profil</a> --}}
                    </div>
                </div>
            </div>

            <!-- Bagian Kanan: Informasi Profil -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5>Informasi Profil</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th>Nama</th>
                                <td>{{ $customer->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $customer->email }}</td>
                            </tr>
                            <tr>
                                <th>Nomor Telepon</th>
                                <td>{{ $customer->phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $customer->address ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kota</th>
                                <td>{{ $customer->city ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td>{{ $customer->date_of_birth ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>{{ $customer->gender == 'male' ? 'Laki-laki' : ($customer->gender == 'female' ? 'Perempuan' : '-') }}
                                </td>
                            </tr>
                            <tr>
                                <th>Kontak</th>
                                <td>{{ $customer->phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>PayPal ID</th>
                                <td>{{ $customer->paypal_id ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection