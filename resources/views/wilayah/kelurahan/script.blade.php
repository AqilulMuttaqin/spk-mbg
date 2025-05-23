@push('script')
    <script>
        $(document).ready(function() {
            var tableKelurahan = $('#dataKelurahan').DataTable({
                processing: false,
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
                    { data: 'index', name: 'index' },
                    { data: 'nama_kelurahan', name: 'nama_kelurahan' },
                    { data: 'kecamatan', name: 'kecamatan' },
                    { data: 'action', name: 'action', orderable: false,  searchable: false }
                ]
            });
            
            function resetFormFields() {
                $('#wilayah_kecamatan_id').val('');
                $('#nama_kelurahan').val('');
            }

            $('#tambahDataKelurahan').on('click', function() {
                resetFormFields();
                $('#submitKelurahanBtn').text('Submit');
                $('#wilayahKelurahanModalLabel').text('Tambah Kelurahan');
                $('#wilayahKelurahanForm').attr('action', "{{ route('wilayah.kelurahan.store') }}");
                $('#wilayahKelurahanForm').attr('method', 'POST');

                $('#wilayahKelurahanModal').modal('show');
            });

            $('#dataKelurahan').on('click', '.edit-btn', function() {
                var id = $(this).data('id');
                var rowData = tableKelurahan.row($(this).parents('tr')).data();

                $('#nama_kelurahan').val(rowData.nama_kelurahan);
                $('#wilayah_kecamatan_id').val(rowData.wilayah_kecamatan_id);
                $('#submitKelurahanBtn').text('Update');
                $('#wilayahKelurahanModalLabel').text('Edit Kelurahan');
                $('#wilayahKelurahanForm').attr('action', '{{ route('wilayah.kelurahan.update', ['kelurahan' => ':kelurahan']) }}'.replace(':kelurahan', rowData.id));
                $('#wilayahKelurahanForm').attr('method', 'PUT');

                $('#wilayahKelurahanModal').modal('show');
            });

            $('#dataKelurahan').on('click', '.confirm-delete', function() {
                var form = $(this).closest('form');
                var deleteUrl = form.attr('action');
                var currentPage = tableKelurahan.page();

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data yang dihapus tidak bisa dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            success: function(response) {
                                tableKelurahan.ajax.reload();
                                $('#dataKriteriaWilayah').DataTable().ajax.reload();
                                tableKelurahan.page(currentPage).draw('page');
                                Swal.fire({
                                    title: 'Success',
                                    text: response.message,
                                    icon: 'success',
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error',
                                    text: xhr.responseJSON.message,
                                    icon: 'error',
                                });
                            }
                        })
                    }
                });
            });
        });

        $('#wilayahKelurahanForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var url = $(this).attr('action');
            var method = $(this).attr('method');
            var currentPage = $('#dataKelurahan').DataTable().page();

            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function(response) {
                    $('#dataKelurahan').DataTable().ajax.reload();
                    $('#dataKelurahan').DataTable().page(currentPage).draw('page');
                    $('#dataKriteriaWilayah').DataTable().ajax.reload();
                    $('#wilayahKelurahanModal').modal('hide');
                    Swal.fire({
                        title: 'Success',
                        text: response.message,
                        icon: 'success',
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error',
                        text: xhr.responseJSON.message,
                        icon: 'error',
                    });
                }
            });
        });
    </script>
@endpush