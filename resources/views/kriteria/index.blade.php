@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-4">
                    <h5>Data Kriteria</h5>
                </div>
                <div class="col-sm-8">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-sm btn-primary me-2" id="tambahDataBtn">
                            Tambah Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped w-100" id="dataKriteria">
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

    <div class="modal fade" id="kriteriaModal" tabindex="-1" role="dialog" aria-labelledby="kriteriaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kriteriaModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="kriteriaForm">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="nama_kriteria">Nama Kriteria</label>
                            <input type="text" class="form-control form-control-user" id="nama_kriteria" name="nama_kriteria" required>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="kategori">Kategori</label>
                                    <select class="form-control form-control-user" id="kategori" name="kategori" required>
                                        <option value="" disabled selected></option>
                                        <option value="wilayah">Wilayah</option>
                                        <option value="sekolah">Sekolah</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="tipe">Tipe</label>
                                    <select class="form-control form-control-user" id="tipe" name="tipe" required>>
                                        <option value="" disabled selected></option>
                                        <option value="angka">Angka</option>
                                        <option value="non-angka">Non Angka</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3" id="satuanWrapper">
                            <label for="satuan">Satuan</label>
                            <input type="text" class="form-control form-control-user" id="satuan" name="satuan" required>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="sifat">Sifat</label>
                                    <select class="form-control form-control-user" id="sifat" name="sifat" required>>
                                        <option value="" disabled selected></option>
                                        <option value="benefit">Benefit</option>
                                        <option value="cost">Cost</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="bobot">Bobot</label>
                                    <input type="number" class="form-control form-control-user" id="bobot" name="bobot" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-primary" id="submitBtn">Save Change</button>
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

                var table = $('#dataKriteria').DataTable({
                    processing: false,
                    serverSide: true,
                    scrollX: true,
                    ajax: {
                        url: '{{ url()->current() }}',
                        type: 'GET'
                    },
                    columns: [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'nama_kriteria',
                            name: 'nama_kriteria'
                        },
                        {
                            data: 'kategori',
                            name: 'kategori',
                            render: function(data) {
                                return toCamelCase(data);
                            }
                        },
                        {
                            data: 'tipe',
                            name: 'tipe'
                        },
                        {
                            data: 'satuan',
                            name: 'satuan'
                        },
                        {
                            data: 'sifat',
                            name: 'sifat',
                            render: function(data) {
                                return toCamelCase(data);
                            }
                        },
                        {
                            data: 'bobot',
                            name: 'bobot'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                var deleteRoute = "{{ route('kriteria.destroy', ['kriteria' => ':kriteria']) }}";
                                var deleteUrl = deleteRoute.replace(':kriteria', row.id);
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
                
                function toCamelCase(str) {
                    if (!str) return '';
                    return str.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join('');
                }
    
                function resetFormFields() {
                    $('#nama_kriteria').val('');
                    $('#kategori').val('');
                    $('#tipe').val('');
                    $('#satuan').val('');
                    $('#sifat').val('');
                    $('#bobot').val('');
                }
    
                $('#tambahDataBtn').click(function() {
                    resetFormFields();
                    $('#submitBtn').text('Submit');
                    $('#kriteriaModalLabel').text('Tambah Kriteria');
                    $('#kriteriaForm').attr('action', "{{ route('kriteria.store') }}");
                    $('#kriteriaForm').attr('method', 'POST');
    
                    $('#kriteriaModal').modal('show');
                });
    
                $('#dataKriteria').on('click', '.edit-btn', function() {
                    var id = $(this).data('js');
                    var rowData = table.row($(this).parents('tr')).data();
    
                    $('#nama_kriteria').val(rowData.nama_kriteria);
                    $('#kategori').val(rowData.kategori);
                    $('#tipe').val(rowData.tipe);
                    updateSatuanField(rowData.tipe);
                    $('#satuan').val(rowData.satuan);
                    $('#sifat').val(rowData.sifat);
                    $('#bobot').val(rowData.bobot);
                    $('#submitBtn').text('Update');
                    $('#kriteriaModalLabel').text('Edit Kriteria');
                    $('#kriteriaForm').attr('action', '{{ route('kriteria.update', ['kriteria' => ':kriteria']) }}'.replace(':kriteria', rowData.id));
                    $('#kriteriaForm').attr('method', 'PUT');
    
                    $('#kriteriaModal').modal('show');
                });
    
                $('#dataKriteria').on('click', '.confirm-delete', function() {
                    var form = $(this).closest('form');
                    var deleteUrl = form.attr('action');
                    var currentPage = table.page();
    
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        success: function(response) {
                            table.ajax.reload();
                            table.page(currentPage).draw('page');
                        },
                        error: function(xhr) {
                            console.log('error nich');
                        }
                    });
                });
            });

            $('#kriteriaForm').on('submit', function(e) {
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
                        $('#dataKriteria').DataTable().ajax.reload();
                        $('#kriteriaModal').modal('hide');
                        console.log(response);
                    },
                    error: function(xhr) {
                        console.log('error nich');
                    }
                });
            });

            const satuanWrapper = $('#satuanWrapper');

            function updateSatuanField(tipe) {
                if (tipe === 'angka') {
                    let options = `
                        <label for="satuan">Satuan</label>
                        <select class="form-control form-control-user" id="satuan" name="satuan" required>
                            <option value="" disabled selected></option>
                            <option value="%">Persen (%)</option>
                            <option value="Orang">Orang</option>
                            <option value="Rp">Rupiah (Rp)</option>
                            <option value="Tahun">Tahun</option>
                            <option value="Hari">Hari</option>
                            <option value="Unit">Unit</option>
                            <option value="Km">Kilometer (Km)</option>
                            <option value="Liter">Liter</option>
                            <option value="Skor">Skor</option>
                            <option value="Jam">Jam</option>
                        </select>
                    `;
                    satuanWrapper.html(options);
                } else if (tipe === 'non-angka') {
                    let input = `
                        <label for="satuan">Satuan</label>
                        <input type="text" class="form-control form-control-user" id="satuan" name="satuan" value="A-E" readonly>
                    `;
                    satuanWrapper.html(input);
                } else {
                    let input = `
                        <label for="satuan">Satuan</label>
                        <input type="text" class="form-control form-control-user" id="satuan" name="satuan" required>
                    `;
                    satuanWrapper.html(input);
                }
            }

            $('#tipe').change(function() {
                var selectedTipe = $(this).val();
                updateSatuanField(selectedTipe);
            });
        </script>
    @endpush
@endsection