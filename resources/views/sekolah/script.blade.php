@push('script')
    <script>
        $(document).ready(function() {
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
                    { data: 'index', name: 'index' },
                    { data: 'nama_sekolah', name: 'nama_sekolah' },
                    { data: 'kecamatan', name: 'kecamatan' },
                    { data: 'kelurahan', name: 'kelurahan' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
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
                $('#sekolahModalLabel').text('Tambah Sekolah');
                $('#sekolahForm').attr('action', "{{ route('sekolah.store') }}");
                $('#sekolahForm').attr('method', 'POST');

                $('#sekolahModal').modal('show');
            });

            $('#dataSekolah').on('click', '.edit-btn', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: "{{ route('sekolah.show', ['sekolah' => ':sekolah']) }}".replace(':sekolah', id),
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#nama_sekolah').val(response.sekolah.nama_sekolah);
                        $('#wilayah_kecamatan').val(response.sekolah.wilayah_kelurahan.wilayah_kecamatan.id);
                        $('#wilayah_kelurahan').prop('disabled', false);
                        $('#wilayah_kelurahan').empty();
                        $('#wilayah_kelurahan').append('<option value="" disabled selected></option>');
                        $.each(response.kelurahan, function(key, value) {
                            $('#wilayah_kelurahan').append('<option value="' + value.id + '">' + value.nama_kelurahan + '</option>');
                        });
                        $('#wilayah_kelurahan').val(response.sekolah.wilayah_kelurahan.id);
                        $('#submitSekolahBtn').text('Update');
                        $('#sekolahModalLabel').text('Edit Data Sekolah');
                        $('#sekolahForm').attr('action', "{{ route('sekolah.update', ['sekolah' => ':sekolah ']) }}".replace(':sekolah', response.sekolah.id));
                        $('#sekolahForm').attr('method', 'PUT');

                        $('#sekolahModal').modal('show');
                    }
                })
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
                        console.log(response.message);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON.message);
                    }
                })
            });

            $('#wilayah_kecamatan').on('change', function () {
                var kecamatanID = $(this).val();

                if (kecamatanID) {
                    $('#wilayah_kelurahan').prop('disabled', false);
                    $('#wilayah_kelurahan').empty();

                    $.ajax({
                        url: "{{ route('sekolah.getKelurahan', ['wilayah_kecamatan_id' => ':wilayah_kecamatan_id']) }}".replace(':wilayah_kecamatan_id', kecamatanID),
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('#wilayah_kelurahan').append('<option value="" disabled selected></option>');
                            $.each(data, function (key, value) {
                                $('#wilayah_kelurahan').append('<option value="' + value.id + '">' + value.nama_kelurahan + '</option>');
                            });
                        }
                    });
                } else {
                    $('#wilayah_kelurahan').prop('disabled', true).empty();
                    $('#wilayah_kelurahan').empty();
                }
            });
        });

        $('#sekolahForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this).serialize();
            var url = $(this).attr('action');
            var method = $(this).attr('method');
            var currentPage = $('#dataSekolah').DataTable().page();

            $.ajax({
                url: url,
                type: method,
                data: form,
                success: function(response) {
                    $('#dataSekolah').DataTable().ajax.reload();
                    $('#dataSekolah').DataTable().page(currentPage).draw('page');
                    $('#sekolahModal').modal('hide');
                    console.log(response.message);
                },
                error: function(xhr) {
                    console.log(xhr.responseJSON.message);
                }
            });
        });
    </script>
@endpush