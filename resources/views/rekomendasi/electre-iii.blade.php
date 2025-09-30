@extends('layout.app')

@section('content')
    <h1 class="h3 mb-3">Perhitungan Rekomendasi dengan ELECTRE III</h1>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-md-3 pe-0 border-end">
                            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <button class="nav-link text-start active" id="v-pills-data-awal-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-data-awal" type="button" role="tab"
                                    aria-controls="v-pills-data-awal" aria-selected="true">Data Awal</button>
                                <button class="nav-link text-start" id="v-pills-matriks-keputusan-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-matriks-keputusan" type="button" role="tab"
                                    aria-controls="v-pills-matriks-keputusan" aria-selected="false">Matriks
                                    Keputusan</button>
                                <button class="nav-link text-start" id="v-pills-bobot-threshold-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-bobot-threshold" type="button" role="tab"
                                    aria-controls="v-pills-bobot-threshold" aria-selected="false">Bobot & Threshold</button>
                                <button class="nav-link text-start" id="v-pills-concordance-index-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-concordance-index" type="button" role="tab"
                                    aria-controls="v-pills-concordance-index" aria-selected="false">Concordance
                                    Index</button>
                                <button class="nav-link text-start" id="v-pills-discordance-index-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-discordance-index" type="button" role="tab"
                                    aria-controls="v-pills-discordance-index" aria-selected="false">Discordance
                                    Index</button>
                                <button class="nav-link text-start" id="v-pills-credibility-matriks-tab"
                                    data-bs-toggle="pill" data-bs-target="#v-pills-credibility-matriks" type="button"
                                    role="tab" aria-controls="v-pills-credibility-matriks" aria-selected="false">Matriks
                                    Credibility</button>
                                <button class="nav-link text-start" id="v-pills-ranking-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-ranking" type="button" role="tab"
                                    aria-controls="v-pills-ranking" aria-selected="false">Perangkingan</button>
                            </div>
                        </div>
                        <div class="col-7 col-md-9 ps-0">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-data-awal" role="tabpanel"
                                    aria-labelledby="v-pills-data-awal-tab" tabindex="0">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-nowrap w-100" id="dataAwal">
                                            <thead>
                                                <tr>
                                                    <th>Alternatif</th>
                                                    <th>Nama Sekolah</th>
                                                    <th>Wilayah</th>
                                                    @foreach ($kriteria as $k)
                                                        <th>{{ $k->nama_kriteria }} (C{{ $loop->index + 1 }})</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-matriks-keputusan" role="tabpanel"
                                    aria-labelledby="v-pills-matriks-keputusan-tab" tabindex="0">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-nowrap w-100" id="matriksKeputusan">
                                            <thead>
                                                <tr>
                                                    <th>Alternatif</th>
                                                    @foreach ($kriteria as $k)
                                                        <th>{{ $k->nama_kriteria }} (C{{ $loop->index + 1 }})</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-bobot-threshold" role="tabpanel"
                                    aria-labelledby="v-pills-bobot-threshold-tab" tabindex="0">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-nowrap w-100" id="bobotThreshold">
                                            <thead>
                                                <tr>
                                                    <th>Kriteria</th>
                                                    <th>Bobot</th>
                                                    <th>Threshold q</th>
                                                    <th>Threshold p</th>
                                                    <th>Threshold v</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-concordance-index" role="tabpanel"
                                    aria-labelledby="v-pills-concordance-index-tab" tabindex="0">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-nowrap w-100" id="concordanceIndex">
                                            <thead>
                                                <tr>
                                                    <th>Perbandingan</th>
                                                    <th>c(C1)</th>
                                                    <th>c(C2)</th>
                                                    <th>c(C3)</th>
                                                    <th>c(C4)</th>
                                                    <th>c(C5)</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-discordance-index" role="tabpanel"
                                    aria-labelledby="v-pills-discordance-index-tab" tabindex="0">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-nowrap w-100" id="discordanceIndex">
                                            <thead>
                                                <tr>
                                                    <th>Perbandingan</th>
                                                    <th>d(C1)</th>
                                                    <th>d(C2)</th>
                                                    <th>d(C3)</th>
                                                    <th>d(C4)</th>
                                                    <th>d(C5)</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-credibility-matriks" role="tabpanel"
                                    aria-labelledby="v-pills-credibility-matriks-tab" tabindex="0">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-nowrap w-100" id="matriksCredibility">
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
                                                                <td>{{ $credibilityIndex['A' . $i . '-A' . $j] ?? '-' }}
                                                                </td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-ranking" role="tabpanel"
                                    aria-labelledby="v-pills-ranking-tab" tabindex="0">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-nowrap w-100" id="perangkingan">
                                            <thead>
                                                <tr>
                                                    <th>Alternatif</th>
                                                    <th>Nama Sekolah</th>
                                                    <th>Descending</th>
                                                    <th>Rank Descending</th>
                                                    <th>Ascending</th>
                                                    <th>Rank Ascending</th>
                                                    <th>Average Rank</th>
                                                    <th>Final Rank</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

                const initializedTables = {};

                const initTable = (tableId, ajaxType, columns) => {
                    if (initializedTables[tableId]) return;

                    $('#' + tableId).DataTable({
                        processing: false,
                        serverSide: true,
                        scrollX: true,
                        deferRender: true,
                        scroller: true,
                        ajax: {
                            url: "{{ url()->current() }}",
                            type: "GET",
                            data: {
                                type: ajaxType
                            }
                        },
                        columns: columns
                    });

                    initializedTables[tableId] = true;
                };

                const kriteriaColumns = [
                    @foreach ($kriteria as $k)
                        {
                            data: '{{ $k->nama_kriteria }}',
                            name: '{{ $k->nama_kriteria }}',
                            orderable: false
                        },
                    @endforeach
                ];

                // Event ketika tab diklik
                $('button[data-bs-toggle="pill"]').on('shown.bs.tab', function(e) {
                    const target = $(e.target).data('bs-target');

                    switch (target) {
                        case '#v-pills-data-awal':
                            initTable('dataAwal', 'dataAwal', [{
                                    data: 'alternatif',
                                    name: 'alternatif',
                                    orderable: false
                                },
                                {
                                    data: 'sekolah',
                                    name: 'sekolah',
                                    orderable: false
                                },
                                {
                                    data: 'wilayah',
                                    name: 'wilayah',
                                    orderable: false
                                },
                                ...kriteriaColumns
                            ]);
                            break;

                        case '#v-pills-matriks-keputusan':
                            initTable('matriksKeputusan', 'matriksKeputusan', [{
                                    data: 'alternatif',
                                    name: 'alternatif',
                                    orderable: false
                                },
                                ...kriteriaColumns
                            ]);
                            break;

                        case '#v-pills-bobot-threshold':
                            initTable('bobotThreshold', 'bobotThreshold', [{
                                    data: 'nama_kriteria',
                                    name: 'nama_kriteria',
                                    orderable: false
                                },
                                {
                                    data: 'bobot',
                                    name: 'bobot',
                                    orderable: false
                                },
                                {
                                    data: 'q',
                                    name: 'q',
                                    orderable: false
                                },
                                {
                                    data: 'p',
                                    name: 'p',
                                    orderable: false
                                },
                                {
                                    data: 'v',
                                    name: 'v',
                                    orderable: false
                                },
                            ]);
                            break;

                        case '#v-pills-concordance-index':
                            initTable('concordanceIndex', 'concordanceIndex', [{
                                    data: 'perbandingan',
                                    name: 'perbandingan',
                                    orderable: false
                                },
                                ...kriteriaColumns
                            ]);
                            break;

                        case '#v-pills-discordance-index':
                            initTable('discordanceIndex', 'discordanceIndex', [{
                                    data: 'perbandingan',
                                    name: 'perbandingan',
                                    orderable: false
                                },
                                ...kriteriaColumns
                            ]);
                            break;

                        case '#v-pills-ranking':
                            initTable('perangkingan', 'hasilRanking', [{
                                    data: 'alternatif',
                                    name: 'alternatif',
                                    orderable: false
                                },
                                {
                                    data: 'sekolah',
                                    name: 'sekolah',
                                    orderable: false
                                },
                                {
                                    data: 'distilasi_descending',
                                    name: 'distilasi_descending',
                                    orderable: false
                                },
                                {
                                    data: 'rank_desc',
                                    name: 'rank_desc',
                                    orderable: false
                                },
                                {
                                    data: 'distilasi_ascending',
                                    name: 'distilasi_ascending',
                                    orderable: false
                                },
                                {
                                    data: 'rank_asc',
                                    name: 'rank_asc',
                                    orderable: false
                                },
                                {
                                    data: 'avg_rank',
                                    name: 'avg_rank',
                                    orderable: false
                                },
                                {
                                    data: 'final_rank',
                                    name: 'final_rank'
                                }
                            ]);
                            break;
                    }
                });

                // Inisialisasi tab aktif pertama
                $('#v-pills-tab .active').trigger('shown.bs.tab');
            });
        </script>
    @endpush

@endsection
