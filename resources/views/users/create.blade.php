@extends('layouts.app')

@section('heading', 'Tambah User')

@section('content')
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('categories.store') }}" method="post">
                        @csrf
                        <x-text-input label="Nama" name="name" placeholder="Masukkan nama category"
                            value="{{ old('name') }}"></x-text-input>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="active"
                                @checked(!old() || old('active') == 'on') name="active">
                            <label class="form-check-label" for="active">Aktif</label>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('categories.index') }}" class="btn btn-danger">Batal</a>

                            <button type="submit" class="btn btn-dark">Simpan</button>

                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
@endsection
