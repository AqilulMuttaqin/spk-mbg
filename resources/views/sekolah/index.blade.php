@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h5>Data Sekolah</h5>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-sm btn-primary me-2" id="tambahDataSekolah">
                            Tambah Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
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
                    <h5>Data Nilai Kriteria Sekolah</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
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

    <div class="modal fade" id="sekolahModal" tabindex="-1" role="dialog" aria-labelledby="sekolahModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sekolahModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="sekolahForm">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="nama_sekolah">Nama Sekolah</label>
                            <input type="text" class="form-control form-control-user" id="nama_sekolah" name="nama_sekolah" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="wilayah_kecamatan">Kecamatan</label>
                            <select class="form-control form-control-user" id="wilayah_kecamatan" required>
                                <option value="" disabled selected></option>
                                @foreach ($kecamatan as $kec)
                                    <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="wilayah_kelurahan">Kelurahan</label>
                            <select class="form-control form-control-user" name="wilayah_kelurahan_id" id="wilayah_kelurahan" disabled required>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submmit" class="btn btn-sm btn-primary" id="submitSekolahBtn">Save Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="nilaiKriteriaSekolahModal" tabindex="-1" role="dialog" aria-labelledby="nilaiKriteriaSekolahModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nilaiKriteriaSekolahModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="nilaiKriteriaSekolahForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-3">
                                <p class="fw-bold">Nama Sekolah</p>
                            </div>
                            <div class="col-9">
                                <p id="sekolah"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <p class="fw-bold">Wilayah</p>
                            </div>
                            <div class="col-9">
                                <p id="wilayah"></p>
                            </div>
                        </div><hr>
                        <p class="text-center fw-bold">Nilai Kriteria</p>
                        <input type="hidden" class="form-control form-control-user" name="nama_sekolah">
                        @foreach ($kriteriaSekolah as $kriteria)
                            <div class="form-group {{ !$loop->last ? 'mb-3' : '' }}">
                                <label for="{{ $kriteria->id }}">{{ $kriteria->nama_kriteria }}</label>
                                @if ($kriteria->tipe === 'angka')
                                    <input type="number" step="any" class="form-control form-control-user" id="{{ $kriteria->id }}" name="kriteria-{{ $kriteria->id }}">
                                @else
                                    <select class="form-control form-control-user" id="{{ $kriteria->id }}" name="kriteria-{{ $kriteria->id }}">
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

                var tableSekolah = $('#dataSekolah').DataTable({
                    processing: true,
                    serverSide: true,
                    scrollX: true,
                    ajax: {
                        url: "{{ url()->current() }}",
                        type: "GET",
                        data: { type: 'sekolah' }
                    },
                    columns:[
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                        },
                        {
                            data: 'nama_sekolah',
                            name: 'nama_sekolah',
                        },
                        {
                            data: 'kecamatan',
                            name: 'kecamatan',
                        },
                        {
                            data: 'kelurahan',
                            name: 'kelurahan',
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                var deleteRoute = "{{ route('sekolah.destroy', ':sekolah') }}";
                                var deleteUrl = deleteRoute.replace(':sekolah', row.id);
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

                var tableNilaiKriteriaSekolah = $('#dataKriteriaSekolah').DataTable({
                    processing: true,
                    serverSide: true,
                    scrollX: true,
                    ajax: {
                        url: "{{ url()->current() }}",
                        type: "GET",
                        data: { type: 'kriteria_sekolah' }
                    },
                    columns:[
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                        },
                        {
                            data: 'sekolah',
                            name: 'sekolah',
                        },
                        {
                            data: 'wilayah',
                            name: 'wilayah',
                        },
                        @foreach ($kriteriaSekolah as $kriteria)
                            {
                                data: '{{ $kriteria->nama_kriteria }}',
                                name: '{{ $kriteria->nama_kriteria }}',
                            },
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
                    $('#nama_sekolah').val('');
                    $('#wilayah_kecamatan').val('');
                    $('#wilayah_kelurahan').val('');
                    $('#wilayah_kelurahan').prop('disabled', true);
                }

                $('#tambahDataSekolah').click(function() {
                    resetFormFields();
                    $('#submitSekolahBtn').text('Submit');
                    $('#sekolahModalLabel').text('Tambah Data Sekolah');
                    $('#sekolahForm').attr('action', "{{ route('sekolah.store') }}");
                    $('#sekolahForm').attr('method', 'POST');

                    $('#sekolahModal').modal('show');
                });

                $('#dataSekolah').on('click', '.edit-btn', function() {
                    var id = $(this).data('js');
                    var rowData = tableSekolah.row($(this).parents('tr')).data();

                    $('#nama_sekolah').val(rowData.nama_sekolah);
                    var kecamatanID = rowData.wilayah_kelurahan.wilayah_kecamatan.id;
                    $('#wilayah_kecamatan').val(kecamatanID).trigger('change');
                    loadKelurahan(kecamatanID, function() {
                        $('#wilayah_kelurahan').val(rowData.wilayah_kelurahan.id);
                    });
                    $('#wilayah_kelurahan').prop('disabled', false);
                    $('#submitSekolahBtn').text('Update');
                    $('#sekolahModalLabel').text('Edit Data Sekolah');
                    $('#sekolahForm').attr('action', "{{ route('sekolah.update', ['sekolah' => ':sekolah ']) }}".replace(':sekolah', rowData.id));
                    $('#sekolahForm').attr('method', 'PUT');

                    $('#sekolahModal').modal('show');
                });

                $('#dataKriteriaSekolah').on('click', '.edit-btn', function() {
                    var id = $(this).data('js');
                    var rowData = tableNilaiKriteriaSekolah.row($(this).parents('tr')).data();
    
                    $('#sekolah').text(': ' + rowData.sekolah);
                    $('#wilayah').text(': ' + rowData.wilayah);
                    $('input[name="nama_sekolah"]').val(rowData.sekolah);
                    @foreach ($kriteriaSekolah as $kriteria)
                        $('#{{ $kriteria->id }}').val(rowData['{{ $kriteria->nama_kriteria }}']);
                    @endforeach
                    $('#submitNilaiKriteriaSekolahBtn').text('Update');
                    $('#nilaiKriteriaSekolahModalLabel').text('Update Data Nilai Kriteria Sekolah');
                    $('#nilaiKriteriaSekolahForm').attr('action', "{{ route('sekolah.nilai-kriteria.update') }}")
                    $('#nilaiKriteriaSekolahForm').attr('method', 'POST');
    
                    $('#nilaiKriteriaSekolahModal').modal('show');
                });

                $('#dataSekolah').on('click', '.confirm-delete', function() {
                    var form = $(this).closest('form');
                    var deleteUrl = form.attr('action');
                    var currentPage = tableSekolah.page();
                    
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        success: function(response) {
                            tableSekolah.ajax.reload();
                            tableSekolah.page(currentPage).draw('page');
                        },
                        error: function(xhr) {
                            console.log('Error nich');
                        }
                    })
                });

                $('#wilayah_kecamatan').on('change', function () {
                    var kecamatanID = $(this).val();

                    if (kecamatanID) {
                        $('#wilayah_kelurahan').prop('disabled', false);

                        $.ajax({
                            url: "{{ route('sekolah.getKelurahan', ['wilayah_kecamatan_id' => ':wilayah_kecamatan_id']) }}".replace(':wilayah_kecamatan_id', kecamatanID),
                            type: "GET",
                            dataType: "json",
                            success: function (data) {
                                $('#wilayah_kelurahan').append('<option value="" disabled selected></option>');
                                $.each(data, function (key, value) {
                                    $('#wilayah_kelurahan').append('<option value="' + value.id + '">' + value.nama_kelurahan + '</option>');
                                });
                                if (callback) callback();
                            }
                        });
                    } else {
                        $('#wilayah_kelurahan').prop('disabled', true).empty();
                    }
                });

                function loadKelurahan(kecamatanID, callback) {
                    $.ajax({
                        url: "{{ route('sekolah.getKelurahan', ['wilayah_kecamatan_id' => ':id']) }}".replace(':id', kecamatanID),
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('#wilayah_kelurahan').append('<option value="" disabled selected></option>');
                            $.each(data, function (key, value) {
                                $('#wilayah_kelurahan').append('<option value="' + value.id + '">' + value.nama_kelurahan + '</option>');
                            });
                            if (callback) callback();
                        }
                    });
                }
            });

            $('#sekolahForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this).serialize();
                var url = $(this).attr('action');
                var method = $(this).attr('method');
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: url,
                    type: method,
                    data: form,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        $('#dataSekolah').DataTable().ajax.reload();
                        $('#dataKriteriaSekolah').DataTable().ajax.reload();
                        $('#sekolahModal').modal('hide');
                        console.log(response);
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            });

            $('#nilaiKriteriaSekolahForm').on('submit', function(e) {
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
                        $('#dataKriteriaSekolah').DataTable().ajax.reload();
                        $('#nilaiKriteriaSekolahModal').modal('hide');
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