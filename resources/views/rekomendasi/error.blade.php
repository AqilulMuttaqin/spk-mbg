@extends('layout.app')

@section('content')
    <h1 class="h3 mb-3">Perhitungan Rekomendasi</h1>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-danger mb-0" role="alert">
                        <h4 class="alert-heading">Terjadi Kesalahan!</h4>
                        <p>{{ $message }}</p>
                        <hr>
                        <p class="mb-0">Silahkan coba lagi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection