@push('script')
    <script>
        $(document).ready(function() {
            var tableKecamatan = $('#dataKecamatan').DataTable({
                processing: false,
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
                    { data: 'index', name: 'index' },
                    { data: 'nama_kecamatan', name: 'nama_kecamatan' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
            
            function resetFormFields() {
                $('#nama_kecamatan').val('');
            }

            $('#tambahDataKecamatan').on('click', function() {
                resetFormFields();
                $('#submitKecamatanBtn').text('Submit');
                $('#wilayahKecamatanModalLabel').text('Tambah Kecamatan');
                $('#wilayahKecamatanForm').attr('action', "{{ route('wilayah.kecamatan.store') }}");
                $('#wilayahKecamatanForm').attr('method', 'POST');

                $('#wilayahKecamatanModal').modal('show');
            });

            $('#dataKecamatan').on('click', '.edit-btn', function() {
                var id = $(this).data('id');
                var rowData = tableKecamatan.row($(this).parents('tr')).data();

                $('#nama_kecamatan').val(rowData.nama_kecamatan);
                $('#submitBtn').text('Update');
                $('#wilayahKecamatanModalLabel').text('Edit Kecamatan');
                $('#wilayahKecamatanForm').attr('action', '{{ route('wilayah.kecamatan.update', ['kecamatan' => ':kecamatan']) }}'.replace(':kecamatan', rowData.id));
                $('#wilayahKecamatanForm').attr('method', 'PUT');

                $('#wilayahKecamatanModal').modal('show');
            });

            $('#dataKecamatan').on('click', '.confirm-delete', function() {
                var form = $(this).closest('form');
                var deleteUrl = form.attr('action');
                var currentPage = tableKecamatan.page();

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
                                tableKecamatan.ajax.reload();
                                tableKecamatan.page(currentPage).draw('page');
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

        $('#wilayahKecamatanForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var url = $(this).attr('action');
            var method = $(this).attr('method');
            var currentPage = $('#dataKecamatan').DataTable().page();

            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function(response) {
                    $('#dataKecamatan').DataTable().ajax.reload();
                    $('#dataKecamatan').DataTable().page(currentPage).draw('page');
                    $('#dataKelurahan').DataTable().ajax.reload();
                    $('#dataKriteriaWilayah').DataTable().ajax.reload();
                    $('#wilayahKecamatanModal').modal('hide');
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