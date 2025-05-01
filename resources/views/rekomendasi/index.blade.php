@extends('layout.app')

@section('content')
    <h1 class="h3 mb-3">Perhitungan Rekomendasi</h1>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-md-3 pe-0 border-end">
                            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <button class="nav-link text-start active" id="v-pills-data-awal-tab" data-bs-toggle="pill" data-bs-target="#v-pills-data-awal" type="button" role="tab" aria-controls="v-pills-data-awal" aria-selected="true">Data Awal</button>
                                <button class="nav-link text-start" id="v-pills-matriks-keputusan-tab" data-bs-toggle="pill" data-bs-target="#v-pills-matriks-keputusan" type="button" role="tab" aria-controls="v-pills-matriks-keputusan" aria-selected="false">Matriks Keputusan</button>
                                <button class="nav-link text-start" id="v-pills-normalisasi-tab" data-bs-toggle="pill" data-bs-target="#v-pills-normalisasi" type="button" role="tab" aria-controls="v-pills-normalisasi" aria-selected="false">Normalisasi Matriks</button>
                                <button class="nav-link text-start" id="v-pills-bobot-ternormalisasi-tab" data-bs-toggle="pill" data-bs-target="#v-pills-bobot-ternormalisasi" type="button" role="tab" aria-controls="v-pills-bobot-ternormalisasi" aria-selected="false">Bobot Ternormalisasi</button>
                                <button class="nav-link text-start" id="v-pills-concordance-index-tab" data-bs-toggle="pill" data-bs-target="#v-pills-concordance-index" type="button" role="tab" aria-controls="v-pills-concordance-index" aria-selected="false">Concordance Index</button>
                                <button class="nav-link text-start" id="v-pills-discordance-index-tab" data-bs-toggle="pill" data-bs-target="#v-pills-discordance-index" type="button" role="tab" aria-controls="v-pills-discordance-index" aria-selected="false">Discordance Index</button>
                                <button class="nav-link text-start" id="v-pills-concordance-matriks-tab" data-bs-toggle="pill" data-bs-target="#v-pills-concordance-matriks" type="button" role="tab" aria-controls="v-pills-concordance-matriks" aria-selected="false">Matriks Concordance</button>
                                <button class="nav-link text-start" id="v-pills-discordance-matriks-tab" data-bs-toggle="pill" data-bs-target="#v-pills-discordance-matriks" type="button" role="tab" aria-controls="v-pills-discordance-matriks" aria-selected="false">Matriks Discordance</button>
                                <button class="nav-link text-start" id="v-pills-dominan-concordance-tab" data-bs-toggle="pill" data-bs-target="#v-pills-dominan-concordance" type="button" role="tab" aria-controls="v-pills-dominan-concordance" aria-selected="false">Dominan Concordance</button>
                                <button class="nav-link text-start" id="v-pills-dominan-discordance-tab" data-bs-toggle="pill" data-bs-target="#v-pills-dominan-discordance" type="button" role="tab" aria-controls="v-pills-dominan-discordance" aria-selected="false">Dominan Discordance</button>
                                <button class="nav-link text-start" id="v-pills-matriks-agregat-tab" data-bs-toggle="pill" data-bs-target="#v-pills-matriks-agregat" type="button" role="tab" aria-controls="v-pills-matriks-agregat" aria-selected="false">Matriks Agregat</button>
                                <button class="nav-link text-start" aria-selected="false">Perangkingan</button>
                            </div>
                        </div>
                        <div class="col-7 col-md-9 ps-0">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-data-awal" role="tabpanel" aria-labelledby="v-pills-data-awal-tab" tabindex="0">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-nowrap w-100" id="dataAwal">
                                            <thead>
                                                <tr>
                                                    <th>Alternatif</th>
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
                                <div class="tab-pane fade" id="v-pills-matriks-keputusan" role="tabpanel" aria-labelledby="v-pills-matriks-keputusan-tab" tabindex="0">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-nowrap w-100" id="matriksKeputusan">
                                            <thead>
                                                <tr>
                                                    <th>Alternatif</th>
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
                                <div class="tab-pane fade" id="v-pills-normalisasi" role="tabpanel" aria-labelledby="v-pills-normalisasi-tab" tabindex="0">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-nowrap w-100" id="normalisasi">
                                            <thead>
                                                <tr>
                                                    <th>Alternatif</th>
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
                                <div class="tab-pane fade" id="v-pills-bobot-ternormalisasi" role="tabpanel" aria-labelledby="v-pills-bobot-ternormalisasi-tab" tabindex="0">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-nowrap w-100" id="bobotTernormalisasi">
                                            <thead>
                                                <tr>
                                                    <th>Alternatif</th>
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
                                <div class="tab-pane fade" id="v-pills-concordance-index" role="tabpanel" aria-labelledby="v-pills-concordance-index-tab" tabindex="0">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-nowrap w-100" id="concordanceIndex">
                                            <thead>
                                                <tr>
                                                    <th>Pasangan Concordance</th>
                                                    <th>Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-discordance-index" role="tabpanel" aria-labelledby="v-pills-discordance-index-tab" tabindex="0">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-nowrap w-100" id="discordanceIndex">
                                            <thead>
                                                <tr>
                                                    <th>Pasangan Discordance</th>
                                                    <th>Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-concordance-matriks" role="tabpanel" aria-labelledby="v-pills-concordance-matriks-tab" tabindex="0">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-nowrap w-100" id="matriksConcordance">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    @for ($j = 1; $j <= $jumlahData; $j++)
                                                        <th>A{{ $j }}</th>
                                                    @endfor
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 1; $i <= $jumlahData; $i++)
                                                    <tr>
                                                        <th>A{{ $i }}</th>
                                                        @for ($j = 1; $j <= $jumlahData; $j++)
                                                            @if ($i == $j)
                                                                <td>-</td>
                                                            @else
                                                                <td>{{ $concordanceValue['c' . $i . '-' . $j] ?? '-' }}</td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-discordance-matriks" role="tabpanel" aria-labelledby="v-pills-discordance-matriks-tab" tabindex="0">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-nowrap w-100" id="matriksDiscordance">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    @for ($j = 1; $j <= $jumlahData; $j++)
                                                        <th>A{{ $j }}</th>
                                                    @endfor
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 1; $i <= $jumlahData; $i++)
                                                    <tr>
                                                        <th>A{{ $i }}</th>
                                                        @for ($j = 1; $j <= $jumlahData; $j++)
                                                            @if ($i == $j)
                                                                <td>-</td>
                                                            @else
                                                                <td>{{ $discordanceValue['d' . $i . '-' . $j] ?? '-' }}</td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-dominan-concordance" role="tabpanel" aria-labelledby="v-pills-dominan-concordance-tab" tabindex="0">
                                    <div class="row ms-2">
                                        <div class="col-3">
                                            <p class="card-title">Jumlah total concordance</p>
                                        </div>
                                        <div class="col-9">
                                            <p>: {{ $totalConcordanceValue }}</p>
                                        </div>
                                    </div>
                                    <div class="row ms-2">
                                        <div class="col-3">
                                            <p class="card-title">c Threshold</p>
                                        </div>
                                        <div class="col-9">
                                            <p>: {{ $cThreshold }}</p>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped text-nowrap w-100" id="dominanConcordance">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    @for ($j = 1; $j <= $jumlahData; $j++)
                                                        <th>A{{ $j }}</th>
                                                    @endfor
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 1; $i <= $jumlahData; $i++)
                                                    <tr>
                                                        <th>A{{ $i }}</th>
                                                        @for ($j = 1; $j <= $jumlahData; $j++)
                                                            @if ($i == $j)
                                                                <td>-</td>
                                                            @else
                                                                <td>{{ $concordanceDominanValue['c' . $i . '-' . $j] ?? '-' }}</td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-dominan-discordance" role="tabpanel" aria-labelledby="v-pills-dominan-discordance-tab" tabindex="0">
                                    <div class="row ms-2">
                                        <div class="col-3">
                                            <p class="card-title">Jumlah total discordance</p>
                                        </div>
                                        <div class="col-9">
                                            <p>: {{ $totalDiscordanceValue }}</p>
                                        </div>
                                    </div>
                                    <div class="row ms-2">
                                        <div class="col-3">
                                            <p class="card-title">d Threshold</p>
                                        </div>
                                        <div class="col-9">
                                            <p>: {{ $dThreshold }}</p>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped text-nowrap w-100" id="dominanDiscordance">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    @for ($j = 1; $j <= $jumlahData; $j++)
                                                        <th>A{{ $j }}</th>
                                                    @endfor
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 1; $i <= $jumlahData; $i++)
                                                    <tr>
                                                        <th>A{{ $i }}</th>
                                                        @for ($j = 1; $j <= $jumlahData; $j++)
                                                            @if ($i == $j)
                                                                <td>-</td>
                                                            @else
                                                                <td>{{ $discordanceDominanValue['d' . $i . '-' . $j] ?? '-' }}</td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-matriks-agregat" role="tabpanel" aria-labelledby="v-pills-matriks-agregat-tab" tabindex="0">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-nowrap w-100" id="matriksAgregat">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    @for ($j = 1; $j <= $jumlahData; $j++)
                                                        <th>A{{ $j }}</th>
                                                    @endfor
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 1; $i <= $jumlahData; $i++)
                                                    <tr>
                                                        <th>A{{ $i }}</th>
                                                        @for ($j = 1; $j <= $jumlahData; $j++)
                                                            @if ($i == $j)
                                                                <td>-</td>
                                                            @else
                                                                <td>{{ $agregatDominanValue[$i . '-' . $j] ?? '-' }}</td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="d-flex align-items-start">
                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active" id="v-pills-data-awal-tab" data-bs-toggle="pill" data-bs-target="#v-pills-data-awal" type="button" role="tab" aria-controls="v-pills-data-awal" aria-selected="true">Data Awal</button>
                            <button class="nav-link" id="v-pills-matriks-keputusan-tab" data-bs-toggle="pill" data-bs-target="#v-pills-matriks-keputusan" type="button" role="tab" aria-controls="v-pills-matriks-keputusan" aria-selected="false">Matriks Keputusan</button>
                            <button class="nav-link" aria-selected="false">Normalisasi Matriks</button>
                            <button class="nav-link" aria-selected="false">Bobot Ternormalisasi</button>
                            <button class="nav-link" aria-selected="false">Concordance Index</button>
                            <button class="nav-link" aria-selected="false">Discordance Index</button>
                            <button class="nav-link" aria-selected="false">Matriks Concordance</button>
                            <button class="nav-link" aria-selected="false">Matriks Discordance</button>
                            <button class="nav-link" aria-selected="false">Dominan Concordance</button>
                            <button class="nav-link" aria-selected="false">Dominan Discordance</button>
                            <button class="nav-link" aria-selected="false">Matriks Agregat</button>
                            <button class="nav-link" aria-selected="false">Perangkingan</button>
                        </div>
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-data-awal" role="tabpanel" aria-labelledby="v-pills-data-awal-tab" tabindex="0">
                                <div class="table-responsive">
                                    <table class="table table-striped text-nowrap w-100" id="dataAwal">
                                        <thead>
                                            <tr>
                                                <th>Alternatif</th>
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
                            <div class="tab-pane fade" id="v-pills-matriks-keputusan" role="tabpanel" aria-labelledby="v-pills-matriks-keputusan-tab" tabindex="0">...</div>
                        </div>
                    </div> --}}
                </div>
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

                var tableDataAwal = $('#dataAwal').DataTable({
                    processing: false,
                    serverSide: true,
                    scrollX: true,
                    deferRender: true,
                    scroller: true,
                    ajax: {
                        url: "{{ url()->current() }}",
                        type: "GET",
                        data: { type: 'dataAwal' }
                    },
                    columns: [
                        { data: 'alternatif', name: 'alternatif', orderable: false },
                        { data: 'sekolah', name: 'sekolah', orderable: false },
                        { data: 'wilayah', name: 'wilayah', orderable: false },
                        @foreach ($kriteria as $k)
                            { data: '{{ $k->nama_kriteria }}', name: '{{ $k->nama_kriteria }}', orderable: false },
                        @endforeach
                    ]
                });

                var tableMatriksKeputusan = $('#matriksKeputusan').DataTable({
                    processing: false,
                    serverSide: true,
                    scrollX: true,
                    deferRender: true,
                    scroller: true,
                    ajax: {
                        url: "{{ url()->current() }}",
                        type: "GET",
                        data: { type: 'matriksKeputusan' }
                    },
                    columns: [
                        { data: 'alternatif', name: 'alternatif', orderable: false },
                        @foreach ($kriteria as $k)
                            { data: '{{ $k->nama_kriteria }}', name: '{{ $k->nama_kriteria }}', orderable: false },
                        @endforeach
                    ]
                });

                var tableNormalisasi = $('#normalisasi').DataTable({
                    processing: false,
                    serverSide: true,
                    scrollX: true,
                    deferRender: true,
                    scroller: true,
                    ajax: {
                        url: "{{ url()->current() }}",
                        type: "GET",
                        data: { type: 'normalisasi' }
                    },
                    columns: [
                        { data: 'alternatif', name: 'alternatif', orderable: false },
                        @foreach ($kriteria as $k)
                            { data: '{{ $k->nama_kriteria }}', name: '{{ $k->nama_kriteria }}', orderable: false },
                        @endforeach
                    ]
                });
                
                var tableBobotTernormalisasi = $('#bobotTernormalisasi').DataTable({
                    processing: false,
                    serverSide: true,
                    scrollX: true,
                    deferRender: true,
                    scroller: true,
                    ajax: {
                        url: "{{ url()->current() }}",
                        type: "GET",
                        data: { type: 'bobotTernormalisasi' }
                    },
                    columns: [
                        { data: 'alternatif', name: 'alternatif', orderable: false },
                        @foreach ($kriteria as $k)
                            { data: '{{ $k->nama_kriteria }}', name: '{{ $k->nama_kriteria }}', orderable: false },
                        @endforeach
                    ]
                });
                
                var tableConcordanceIndex = $('#concordanceIndex').DataTable({
                    processing: false,
                    serverSide: true,
                    scrollX: true,
                    deferRender: true,
                    scroller: true,
                    ajax: {
                        url: "{{ url()->current() }}",
                        type: "GET",
                        data: { type: 'concordanceIndex' }
                    },
                    columns: [
                        { data: 'pasangan', name: 'pasangan', orderable: false },
                        { data: 'nilai', name: 'nilai', orderable: false }
                    ]
                });

                var tableDiscordanceIndex = $('#discordanceIndex').DataTable({
                    processing: false,
                    serverSide: true,
                    scrollX: true,
                    deferRender: true,
                    scroller: true,
                    ajax: {
                        url: "{{ url()->current() }}",
                        type: "GET",
                        data: { type: 'discordanceIndex' }
                    },
                    columns: [
                        { data: 'pasangan', name: 'pasangan', orderable: false },
                        { data: 'nilai', name: 'nilai', orderable: false }
                    ]
                });
            });
        </script>
    @endpush
    {{-- <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h5>Data Nilai Lengkap</h5>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('rekomendasi.lihat-hasil-perhitungan') }}" class="btn btn-sm btn-primary me-2">
                            Lihat Hasil Rekomendasi
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped text-nowrap w-100" id="dataAwal">
                    <thead>
                        <tr>
                            <th>Alternatif</th>
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

                var tableNilaiLengkap = $('#dataAwal').DataTable({
                    processing: false,
                    serverSide: true,
                    scrollX: true,
                    ajax: {
                        url: "{{ url()->current() }}",
                        type: "GET",
                    },
                    columns: [
                        { data: 'alternatif', name: 'alternatif' },
                        { data: 'sekolah', name: 'sekolah' },
                        { data: 'wilayah', name: 'wilayah' },
                        @foreach ($kriteria as $k)
                            { data: '{{ $k->nama_kriteria }}', name: '{{ $k->nama_kriteria }}' },
                        @endforeach
                    ]
                });
            });
        </script>
    @endpush --}}
@endsection