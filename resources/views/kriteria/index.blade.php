@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-4 d-flex align-items-center">
                    <h5 class="mb-0">Data Kriteria</h5>
                </div>
                <div class="col-sm-8">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-sm btn-primary" id="tambahDataBtn">
                            Tambah Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-striped text-nowrap w-100" id="dataKriteria">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kriteria</th>
                            <th>Kategori</th>
                            <th>Tipe</th>
                            <th>Satuan</th>
                            <th>Sifat</th>
                            <th>Bobot</th>
                            <th style="width: 30px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('kriteria.form-modal')
    @include('kriteria.script')
@endsection