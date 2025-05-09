@push('script')
    <script>
        $(document).ready(function() {
            var tableNilaiKriteriaSekolah = $('#dataKriteriaSekolah').DataTable({
                processing: false,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: "{{ url()->current() }}",
                    type: "GET",
                    data: { type: 'kriteria_sekolah' }
                },
                columns:[
                    { data: 'index', name: 'index' },
                    { data: 'sekolah', name: 'sekolah' },
                    { data: 'wilayah', name: 'wilayah' },
                    @foreach ($kriteriaSekolah as $kriteria)
                        { data: '{{ $kriteria->nama_kriteria }}', name: '{{ $kriteria->nama_kriteria }}' },
                    @endforeach
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
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
        });

        $('#nilaiKriteriaSekolahForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var url = $(this).attr('action');
            var method = $(this).attr('method');
            var currentPage = $('#dataKriteriaSekolah').DataTable().page();

            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function(response) {
                    $('#dataKriteriaSekolah').DataTable().ajax.reload();
                    $('#dataKriteriaSekolah').DataTable().page(currentPage).draw('page');
                    $('#nilaiKriteriaSekolahModal').modal('hide');
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

        $('#importNilaiKriteriaSekolah').on('click', function() {
            $('#file').val('');
            $('#importForm').attr('action', "{{ route('sekolah.nilai-kriteria.import') }}");
            $('#importForm').attr('method', 'POST');
            $('#importModal').modal('show');
        });

        $('#importForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var url = $(this).attr('action');
            var method = $(this).attr('method');
            var currentPage = $('#dataKriteriaSekolah').DataTable().page();

            $.ajax({
                url: url,
                type: method,
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#dataKriteriaSekolah').DataTable().ajax.reload();
                    $('#dataKriteriaSekolah').DataTable().page(currentPage).draw('page');
                    $('#importModal').modal('hide');
                    Swal.fire({
                        title: 'Success',
                        text: response.message,
                        icon: response.status,
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