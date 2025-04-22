@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h5>Data Nilai Lengkap</h5>
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
                <table class="table table-striped text-nowrap w-100" id="dataNilaiLengkap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Sekolah</th>
                            <th>Wilayah</th>
                            @foreach ($kriteria as $k)
                                <th>{{ $k->nama_kriteria }}</th>
                            @endforeach
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

                var tableNilaiLengkap = $('#dataNilaiLengkap').DataTable({
                    processing: true,
                    serverSide: true,
                    scrollX: true,
                    ajax: {
                        url: "{{ url()->current() }}",
                        type: "GET",
                    },
                    columns: [
                        {
                            data: 'DT_RowIndex', 
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'sekolah', 
                            name: 'sekolah'
                        },
                        {
                            data: 'wilayah', 
                            name: 'wilayah' 
                        },
                        @foreach ($kriteria as $k)
                            { 
                                data: '{{ $k->nama_kriteria }}', 
                                name: '{{ $k->nama_kriteria }}' 
                            },
                        @endforeach
                    ]
                });
            });
        </script>
    @endpush
@endsection