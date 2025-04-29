@extends('layout.app')

@section('content')
    <h1 class="h3 mb-3">Kriteria</h1>
    <div class="row">
        <div class="col-12">       
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-4 d-flex align-items-center">
                            <h5 class="card-title mb-0">Data Kriteria</h5>
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
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table table-striped text-nowrap w-100" id="dataKriteria">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">No</th>
                                    <th>Nama Kriteria</th>
                                    <th>Kategori</th>
                                    <th>Tipe</th>
                                    <th>Satuan</th>
                                    <th>Sifat</th>
                                    <th>Bobot</th>
                                    <th style="width: 10px;">Action</th>
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

    @include('kriteria.form-modal')
    @include('kriteria.script')
@endsection