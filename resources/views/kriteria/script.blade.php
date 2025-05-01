@push('script')
    <script>
        $(document).ready(function() {
            var tableKriteria = $('#dataKriteria').DataTable({
                processing: false,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: '{{ url()->current() }}',
                    type: 'GET'
                },
                columns: [
                    { data: 'index', name: 'index'},
                    { data: 'nama_kriteria', name: 'nama_kriteria' },
                    { data: 'kategori', name: 'kategori' },
                    { data: 'tipe', name: 'tipe' },
                    { data: 'satuan', name: 'satuan' },
                    { data: 'sifat', name: 'sifat' },
                    { data: 'bobot', name: 'bobot' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

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
                var id = $(this).data('id');
                var rowData = tableKriteria.row($(this).parents('tr')).data();

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
                var currentPage = tableKriteria.page();

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
                                tableKriteria.ajax.reload();
                                tableKriteria.page(currentPage).draw('page');
                                Swal.fire({
                                    title: "Success",
                                    text: response.message,
                                    icon: "success"
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: "Error",
                                    text: xhr.responseJSON.message,
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });
        });

        $('#kriteriaForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var url = $(this).attr('action');
            var method = $(this).attr('method');
            var currentPage = $('#dataKriteria').DataTable().page();

            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function(response) {
                    $('#dataKriteria').DataTable().ajax.reload();
                    $('#dataKriteria').DataTable().page(currentPage).draw('page');
                    $('#kriteriaModal').modal('hide');
                    Swal.fire({
                        title: "Success",
                        text: response.message,
                        icon: "success"
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: "Error",
                        text: xhr.responseJSON.message,
                        icon: "error"
                    });
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