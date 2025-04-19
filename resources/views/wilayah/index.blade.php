@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100">
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
                <div class="card-body h-100 d-flex flex-column">
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
                <div class="card-body h-100 d-flex flex-column">
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

    <div class="modal fade" id="wilayahKecamatanModal" tabindex="-1" role="dialog" aria-labelledby="wilayahKecamatanModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="wilayahKecamatanModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="wilayahKecamatanForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_kecamatan">Nama Kecamatan</label>
                            <input type="text" class="form-control form-control-user" id="nama_kecamatan" name="nama_kecamatan" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submmit" class="btn btn-sm btn-primary" id="submitKecamatanBtn">Save Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="wilayahKelurahanModal" tabindex="-1" role="dialog" aria-labelledby="wilayahKelurahanModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="wilayahKelurahanModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="wilayahKelurahanForm">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="wilayah_kecamatan_id">Kecamatan</label>
                            <select class="form-control form-control-user" name="wilayah_kecamatan_id" id="wilayah_kecamatan_id" required>
                                <option value="" disabled selected></option>
                                @foreach ($kecamatan as $kec)
                                    <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_kelurahan">Nama Kelurahan</label>
                            <input type="text" class="form-control form-control-user" id="nama_kelurahan" name="nama_kelurahan" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submmit" class="btn btn-sm btn-primary" id="submitKelurahanBtn">Save Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="nilaiKriteriaWilayahModal" tabindex="-1" role="dialog" aria-labelledby="nilaiKriteriaWilayahModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nilaiKriteriaWilayahModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="nilaiKriteriaWilayahForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-3">
                                <p class="fw-bold">Kecamatan</p>
                            </div>
                            <div class="col-9">
                                <p id="kecamatan"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <p class="fw-bold">Kelurahan</p>
                            </div>
                            <div class="col-9">
                                <p id="kelurahan"></p>
                            </div>
                        </div><hr>
                        <p class="text-center fw-bold">Nilai Kriteria</p>
                        <input type="hidden" class="form-control form-control-user" name="nama_kelurahan">
                        @foreach ($kriteriaWilayah as $kW)
                            <div class="form-group {{ !$loop->last ? 'mb-3' : '' }}">
                                <label for="{{ $kW->id }}">{{ $kW->nama_kriteria }}</label>
                                @if ($kW->tipe === 'angka')
                                    <input type="number" step="any" class="form-control form-control-user" id="{{ $kW->id }}" name="kriteria-{{ $kW->id }}">
                                @else
                                    <select class="form-control form-control-user" id="{{ $kW->id }}" name="kriteria-{{ $kW->id }}">
                                        <option value="" disabled selected></option>
                                        <option value="A">A (Sangat Baik)</option>
                                        <option value="B">B (Baik)</option>
                                        <option value="C">C (Cukup)</option>
                                        <option value="D">D (Kurang)</option>
                                        <option value="E">E (Sangat Kurang)</option>
                                    </select>
                                @endif
                            </div>
                        @endforeach
                        <hr>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submmit" class="btn btn-sm btn-primary" id="submitNilaiKriteriaWilayahBtn">Save Change</button>
                    </div>
                </form>
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

                var tableKecamatan = $('#dataKecamatan').DataTable({
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
                                var deleteRoute = "{{ route('wilayah.kecamatan.destroy', ':kecamatan') }}";
                                var deleteUrl = deleteRoute.replace(':kecamatan', row.id);
                                return `
                                    <div class="d-flex justify-content-center text-nowrap gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-info edit-btn" data-js="${row.id}">
                                            <i class="ti ti-edit me-1"></i>
                                            Edit
                                        </button>
                                        <form action="${deleteUrl}" method="POST">
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

                var tableKelurahan = $('#dataKelurahan').DataTable({
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
                                var deleteRoute = "{{ route('wilayah.kelurahan.destroy', ':kelurahan') }}";
                                var deleteUrl = deleteRoute.replace(':kelurahan', row.id);
                                return `
                                    <div class="d-flex justify-content-center text-nowrap gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-info edit-btn" data-js="${row.id}">
                                            <i class="ti ti-edit me-1"></i>
                                            Edit
                                        </button>
                                        <form action="${deleteUrl}" method="POST">
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

                var tableNilaiKriteiaWilayah = $('#dataKriteriaWilayah').DataTable({
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
                                            Update
                                        </button>
                                    </div>
                                `;
                            }
                        }
                    ]
                });
                
                function resetFormFields() {
                    $('#nama_kecamatan').val('');
                    $('#wilayah_kecamatan_id').val('');
                    $('#nama_kelurahan').val('');
                }
    
                $('#tambahDataKecamatan').on('click', function() {
                    resetFormFields();
                    $('#submitKecamatanBtn').text('Submit');
                    $('#wilayahKecamatanModalLabel').text('Tambah Data Kecamatan');
                    $('#wilayahKecamatanForm').attr('action', "{{ route('wilayah.kecamatan.store') }}");
                    $('#wilayahKecamatanForm').attr('method', 'POST');
    
                    $('#wilayahKecamatanModal').modal('show');
                });

                $('#tambahDataKelurahan').on('click', function() {
                    resetFormFields();
                    $('#submitKelurahanBtn').text('Submit');
                    $('#wilayahKelurahanModalLabel').text('Tambah Data Kelurahan');
                    $('#wilayahKelurahanForm').attr('action', "{{ route('wilayah.kelurahan.store') }}");
                    $('#wilayahKelurahanForm').attr('method', 'POST');
    
                    $('#wilayahKelurahanModal').modal('show');
                });
    
                $('#dataKecamatan').on('click', '.edit-btn', function() {
                    var id = $(this).data('js');
                    var rowData = tableKecamatan.row($(this).parents('tr')).data();
    
                    $('#nama_kecamatan').val(rowData.nama_kecamatan);
                    $('#submitBtn').text('Update');
                    $('#wilayahKecamatanModalLabel').text('Edit Data Kecamatan');
                    $('#wilayahKecamatanForm').attr('action', '{{ route('wilayah.kecamatan.update', ['kecamatan' => ':kecamatan']) }}'.replace(':kecamatan', rowData.id));
                    $('#wilayahKecamatanForm').attr('method', 'PUT');
    
                    $('#wilayahKecamatanModal').modal('show');
                });

                $('#dataKelurahan').on('click', '.edit-btn', function() {
                    var id = $(this).data('js');
                    var rowData = tableKelurahan.row($(this).parents('tr')).data();
    
                    $('#nama_kelurahan').val(rowData.nama_kelurahan);
                    $('#wilayah_kecamatan_id').val(rowData.wilayah_kecamatan_id);
                    $('#submitKelurahanBtn').text('Update');
                    $('#wilayahKelurahanModalLabel').text('Edit Data Kelurahan');
                    $('#wilayahKelurahanForm').attr('action', '{{ route('wilayah.kelurahan.update', ['kelurahan' => ':kelurahan']) }}'.replace(':kelurahan', rowData.id));
                    $('#wilayahKelurahanForm').attr('method', 'PUT');
    
                    $('#wilayahKelurahanModal').modal('show');
                });

                $('#dataKriteriaWilayah').on('click', '.edit-btn', function() {
                    var id = $(this).data('js');
                    var rowData = tableNilaiKriteiaWilayah.row($(this).parents('tr')).data();
    
                    $('#kecamatan').text(': ' + rowData.kecamatan);
                    $('#kelurahan').text(': ' + rowData.kelurahan);
                    $('input[name="nama_kelurahan"]').val(rowData.kelurahan);
                    @foreach ($kriteriaWilayah as $kriteria)
                        $('#{{ $kriteria->id }}').val(rowData['{{ $kriteria->nama_kriteria }}']);
                    @endforeach
                    $('#submitNilaiKriteriaWilayahBtn').text('Update');
                    $('#nilaiKriteriaWilayahModalLabel').text('Update Data Nilai Kriteria Wilayah');
                    $('#nilaiKriteriaWilayahForm').attr('action', "{{ route('wilayah.nilai-kriteria.update') }}")
                    $('#nilaiKriteriaWilayahForm').attr('method', 'POST');
    
                    $('#nilaiKriteriaWilayahModal').modal('show');
                });

                $('#dataKecamatan').on('click', '.confirm-delete', function() {
                    var form = $(this).closest('form');
                    var deleteUrl = form.attr('action');
                    var currentPage = tableKecamatan.page();

                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        success: function(response) {
                            tableKecamatan.ajax.reload();
                            tableKecamatan.page(currentPage).draw('page');
                        },
                        error: function(xhr) {
                            console.log('Error nich');
                        }
                    })
                });

                $('#dataKelurahan').on('click', '.confirm-delete', function() {
                    var form = $(this).closest('form');
                    var deleteUrl = form.attr('action');
                    var currentPage = tableKelurahan.page();

                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        success: function(response) {
                            tableKelurahan.ajax.reload();
                            tableNilaiKriteiaWilayah.ajax.reload();
                            tableKelurahan.page(currentPage).draw('page');
                        },
                        error: function(xhr) {
                            console.log('Error nich');
                        }
                    })
                });
            });

            $('#wilayahKecamatanForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var url = $(this).attr('action');
                var method = $(this).attr('method');
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        $('#dataKecamatan').DataTable().ajax.reload();
                        $('#dataKelurahan').DataTable().ajax.reload();
                        $('#dataKriteriaWilayah').DataTable().ajax.reload();
                        $('#wilayahKecamatanModal').modal('hide');
                        console.log(response);
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            });

            $('#wilayahKelurahanForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var url = $(this).attr('action');
                var method = $(this).attr('method');
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        $('#dataKelurahan').DataTable().ajax.reload();
                        $('#dataKriteriaWilayah').DataTable().ajax.reload();
                        $('#wilayahKelurahanModal').modal('hide');
                        console.log(response);
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            });

            $('#nilaiKriteriaWilayahForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var url = $(this).attr('action');
                var method = $(this).attr('method');
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        $('#dataKriteriaWilayah').DataTable().ajax.reload();
                        $('#nilaiKriteriaWilayahModal').modal('hide');
                        console.log(response);
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            });
        </script>
    @endpush
@endsection