@extends('layout.app')

@section('content')
    <h3>Wilayah</h3>
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-6 d-flex align-items-stretch">
                    <div class="card w-100">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5 class="card-title mb-0">Data Kecamatan</h5>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-sm btn-primary" id="tambahDataKecamatan">
                                            Tambah Data
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body h-100 d-flex flex-column p-2">
                            <div class="table-responsive mb-auto">
                                <table class="table table-striped w-100" id="dataKecamatan">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th style="width: 30px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="col-lg-6 d-flex align-items-stretch">
                    <div class="card w-100">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5 class="card-title mb-0">Data Kelurahan</h5>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-sm btn-primary" id="tambahDataKelurahan">
                                            Tambah Data
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body h-100 d-flex flex-column p-2">
                            <div class="table-responsive mb-auto">
                                <table class="table table-striped w-100" id="dataKelurahan">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Kecamatan</th>
                                            <th style="width: 30px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5 class="card-title mb-0">Data Nilai Kriteria Wilayah</h5>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-bs-toggle="dropdown">
                                    Import Excel
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" id="importNilaiKriteriaWilayah">
                                        <i class="icon-sm me-1" data-feather="upload"></i>
                                        Import Excel
                                    </a>
                                    <a class="dropdown-item" href="{{ route('wilayah.nilai-kriteria.export-format-import') }}">
                                        <i class="icon-sm me-1" data-feather="download"></i>
                                        Format Import
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table table-striped w-100" id="dataKriteriaWilayah">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kelurahan</th>
                                    <th>Kecamatan</th>
                                    @foreach ($kriteriaWilayah as $kriteria)
                                        <th>{{ $kriteria->nama_kriteria }}</th>
                                    @endforeach
                                    <th style="width: 30px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('wilayah.kecamatan.form-modal')
    @include('wilayah.kelurahan.form-modal')
    @include('wilayah.nilai-kriteria-wilayah.form-modal')
    @include('wilayah.nilai-kriteria-wilayah.import-modal')

    @include('wilayah.kecamatan.script')
    @include('wilayah.kelurahan.script')
    @include('wilayah.nilai-kriteria-wilayah.script')
@endsection