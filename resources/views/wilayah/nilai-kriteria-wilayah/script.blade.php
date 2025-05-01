@push('script')
    <script>
        $(document).ready(function() {
            var tableNilaiKriteiaWilayah = $('#dataKriteriaWilayah').DataTable({
                processing: false,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: "{{ url()->current() }}",
                    type: 'GET',
                    data: { type: 'kriteria_wilayah' }
                },
                columns: [
                    { data: 'index', name: 'index' },
                    { data: 'kelurahan', name: 'kelurahan' },
                    { data: 'kecamatan', name: 'kecamatan' },
                    @foreach ($kriteriaWilayah as $kriteria)
                        { data: '{{ $kriteria->nama_kriteria }}', name: '{{ $kriteria->nama_kriteria }}' },
                    @endforeach
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            $('#dataKriteriaWilayah').on('click', '.edit-btn', function() {
                var id = $(this).data('id');
                var rowData = tableNilaiKriteiaWilayah.row($(this).parents('tr')).data();

                $('#kecamatan').text(': ' + rowData.kecamatan);
                $('#kelurahan').text(': ' + rowData.kelurahan);
                $('input[name="nama_kelurahan"]').val(rowData.kelurahan);
                @foreach ($kriteriaWilayah as $kriteria)
                    $('#{{ $kriteria->id }}').val(rowData['{{ $kriteria->nama_kriteria }}']);
                @endforeach
                $('#submitNilaiKriteriaWilayahBtn').text('Update');
                $('#nilaiKriteriaWilayahModalLabel').text('Update Nilai Kriteria Wilayah');
                $('#nilaiKriteriaWilayahForm').attr('action', "{{ route('wilayah.nilai-kriteria.update') }}")
                $('#nilaiKriteriaWilayahForm').attr('method', 'POST');

                $('#nilaiKriteriaWilayahModal').modal('show');
            });
        });

        $('#nilaiKriteriaWilayahForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var url = $(this).attr('action');
            var method = $(this).attr('method');
            var currentPage = $('#dataKriteriaWilayah').DataTable().page();

            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function(response) {
                    $('#dataKriteriaWilayah').DataTable().ajax.reload();
                    $('#dataKriteriaWilayah').DataTable().page(currentPage).draw('page');
                    $('#nilaiKriteriaWilayahModal').modal('hide');
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