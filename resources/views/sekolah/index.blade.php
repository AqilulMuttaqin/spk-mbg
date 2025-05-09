@extends('layout.app')

@section('content')
    <h1 class="h3 mb-3">Sekolah</h1>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5 class="card-title mb-0">Data Sekolah</h5>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-sm btn-primary" id="tambahDataSekolah">
                                    Tambah Data
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-striped w-100" id="dataSekolah">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Sekolah</th>
                                    <th>Kecamatan</th>
                                    <th>Kelurahan</th>
                                    <th style="width: 30px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5 class="card-title mb-0">Data Nilai Kriteria Sekolah</h5>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-bs-toggle="dropdown">
                                    Import Excel
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" id="importNilaiKriteriaSekolah">
                                        <i class="icon-sm me-1" data-feather="upload"></i>
                                        Import Excel
                                    </a>
                                    <a class="dropdown-item" href="{{ route('sekolah.nilai-kriteria.export-format-import') }}">
                                        <i class="icon-sm me-1" data-feather="download"></i>
                                        Format Import
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-striped w-100" id="dataKriteriaSekolah">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Sekolah</th>
                                    <th>Wilayah Sekolah</th>
                                    @foreach ($kriteriaSekolah as $kriteria)
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

    @include('sekolah.form-modal')
    @include('sekolah.nilai-kriteria-sekolah.form-modal')

    @include('sekolah.script')
    @include('sekolah.nilai-kriteria-sekolah.script')
@endsection