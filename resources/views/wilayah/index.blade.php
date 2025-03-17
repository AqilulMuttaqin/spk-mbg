@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5>Data Kecamatan</h5>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-sm btn-primary me-2" id="tambahDataKecamatan">
                                    Tambah Data
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
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
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5>Data Kelurahan</h5>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-sm btn-primary me-2" id="tambahDataKelurahan">
                                    Tambah Data
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
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
                    <h5>Data Wilayah Lengkap</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
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

    @push('script')
        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#dataKecamatan').DataTable({
                    processing: true,
                    serverSide: true,
                    scrollX: true,
                    pageLength: 5,
                    lengthMenu: [5, 10, 25, 50, 100],
                    ajax: {
                        url: "{{ url()->current() }}",
                        type: 'GET',
                        data: { type: 'kecamatan' }
                    },
                    columns: [
                        {
                            data: 'DT_RowIndex', 
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'nama_kecamatan', 
                            name: 'nama_kecamatan'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                return `
                                    <div class="d-flex justify-content-center text-nowrap gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-info edit-btn" data-js="${row.id}">
                                            <i class="ti ti-edit me-1"></i>
                                            Edit
                                        </button>
                                        <form action="" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger confirm-delete">
                                                <i class="ti ti-trash me-1"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                `;
                            }
                        }
                    ]
                });

                $('#dataKelurahan').DataTable({
                    processing: true,
                    serverSide: true,
                    scrollX: true,
                    pageLength: 5,
                    lengthMenu: [5, 10, 25, 50, 100],
                    ajax: {
                        url: "{{ url()->current() }}",
                        type: 'GET',
                        data: { type: 'kelurahan' }
                    },
                    columns: [
                        {
                            data: 'DT_RowIndex', 
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'nama_kelurahan', 
                            name: 'nama_kelurahan'
                        },
                        {
                            data: 'kecamatan', 
                            name: 'kecamatan'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                return `
                                    <div class="d-flex justify-content-center text-nowrap gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-info edit-btn" data-js="${row.id}">
                                            <i class="ti ti-edit me-1"></i>
                                            Edit
                                        </button>
                                        <form action="" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger confirm-delete">
                                                <i class="ti ti-trash me-1"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                `;
                            }
                        }
                    ]
                });

                $('#dataKriteriaWilayah').DataTable({
                    processing: true,
                    serverSide: true,
                    scrollX: true,
                    ajax: {
                        url: "{{ url()->current() }}",
                        type: 'GET',
                        data: { type: 'kriteria_wilayah' }
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { data: 'kelurahan', name: 'kelurahan' },
                        { data: 'kecamatan', name: 'kecamatan' },
                        @foreach ($kriteriaWilayah as $kriteria)
                            { data: '{{ $kriteria->nama_kriteria }}', name: '{{ $kriteria->nama_kriteria }}' },
                        @endforeach
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                return `
                                    <div class="d-flex justify-content-center text-nowrap gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-info edit-btn" data-js="${row.id}">
                                            <i class="ti ti-edit me-1"></i>
                                            Edit
                                        </button>
                                        <form action="" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger confirm-delete">
                                                <i class="ti ti-trash me-1"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                `;
                            }
                        }
                    ]
                });
            });
        </script>
    @endpush
@endsection