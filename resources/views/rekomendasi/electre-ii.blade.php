@extends('layout.app')

@section('content')
    <h1 class="h3 mb-3">Perhitungan Rekomendasi dengan ELECTRE II</h1>
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
                                <button class="nav-link text-start" id="v-pills-normalisasi-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-normalisasi" type="button" role="tab"
                                    aria-controls="v-pills-normalisasi" aria-selected="false">Normalisasi Matriks</button>
                                <button class="nav-link text-start" id="v-pills-bobot-ternormalisasi-tab"
                                    data-bs-toggle="pill" data-bs-target="#v-pills-bobot-ternormalisasi" type="button"
                                    role="tab" aria-controls="v-pills-bobot-ternormalisasi" aria-selected="false">Bobot
                                    Ternormalisasi</button>
                                <button class="nav-link text-start" id="v-pills-concordance-index-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-concordance-index" type="button" role="tab"
                                    aria-controls="v-pills-concordance-index" aria-selected="false">Concordance
                                    Index</button>
                                <button class="nav-link text-start" id="v-pills-discordance-index-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-discordance-index" type="button" role="tab"
                                    aria-controls="v-pills-discordance-index" aria-selected="false">Discordance
                                    Index</button>
                                <button class="nav-link text-start" id="v-pills-concordance-matriks-tab"
                                    data-bs-toggle="pill" data-bs-target="#v-pills-concordance-matriks" type="button"
                                    role="tab" aria-controls="v-pills-concordance-matriks" aria-selected="false">Matriks
                                    Concordance</button>
                                <button class="nav-link text-start" id="v-pills-discordance-matriks-tab"
                                    data-bs-toggle="pill" data-bs-target="#v-pills-discordance-matriks" type="button"
                                    role="tab" aria-controls="v-pills-discordance-matriks" aria-selected="false">Matriks
                                    Discordance</button>
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
                                                        <th>C{{ $loop->index + 1 }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-normalisasi" role="tabpanel"
                                    aria-labelledby="v-pills-normalisasi-tab" tabindex="0">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-nowrap w-100" id="normalisasi">
                                            <thead>
                                                <tr>
                                                    <th>Alternatif</th>
                                                    @foreach ($kriteria as $k)
                                                        <th>C{{ $loop->index + 1 }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-bobot-ternormalisasi" role="tabpanel"
                                    aria-labelledby="v-pills-bobot-ternormalisasi-tab" tabindex="0">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-nowrap w-100" id="bobotTernormalisasi">
                                            <thead>
                                                <tr>
                                                    <th>Alternatif</th>
                                                    @foreach ($kriteria as $k)
                                                        <th>C{{ $loop->index + 1 }}</th>
                                                    @endforeach
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
                                                    <th>Pasangan Concordance</th>
                                                    <th>Nilai</th>
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
                                                    <th>Pasangan Discordance</th>
                                                    <th>Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-concordance-matriks" role="tabpanel"
                                    aria-labelledby="v-pills-concordance-matriks-tab" tabindex="0">
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
                                <div class="tab-pane fade" id="v-pills-discordance-matriks" role="tabpanel"
                                    aria-labelledby="v-pills-discordance-matriks-tab" tabindex="0">
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
                                                                <td>{{ $discordanceValue['d' . $i . '-' . $j] ?? '-' }}
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
                                                    <th>Concordance Murni</th>
                                                    <th>Rank C</th>
                                                    <th>Discordance Murni</th>
                                                    <th>Rank D</th>
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

                // Tab Click Event
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

                        case '#v-pills-normalisasi':
                            initTable('normalisasi', 'normalisasi', [{
                                    data: 'alternatif',
                                    name: 'alternatif',
                                    orderable: false
                                },
                                ...kriteriaColumns
                            ]);
                            break;

                        case '#v-pills-bobot-ternormalisasi':
                            initTable('bobotTernormalisasi', 'bobotTernormalisasi', [{
                                    data: 'alternatif',
                                    name: 'alternatif',
                                    orderable: false
                                },
                                ...kriteriaColumns
                            ]);
                            break;

                        case '#v-pills-concordance-index':
                            initTable('concordanceIndex', 'concordanceIndex', [{
                                    data: 'pasangan',
                                    name: 'pasangan',
                                    orderable: false
                                },
                                {
                                    data: 'nilai',
                                    name: 'nilai',
                                    orderable: false
                                }
                            ]);
                            break;

                        case '#v-pills-discordance-index':
                            initTable('discordanceIndex', 'discordanceIndex', [{
                                    data: 'pasangan',
                                    name: 'pasangan',
                                    orderable: false
                                },
                                {
                                    data: 'nilai',
                                    name: 'nilai',
                                    orderable: false
                                }
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
                                    data: 'c_murni',
                                    name: 'c_murni',
                                    orderable: false
                                },
                                {
                                    data: 'rank_c',
                                    name: 'rank_c',
                                    orderable: false
                                },
                                {
                                    data: 'd_murni',
                                    name: 'd_murni',
                                    orderable: false
                                },
                                {
                                    data: 'rank_d',
                                    name: 'rank_d',
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

                // Optional: Trigger load on the first active tab
                $('#v-pills-tab .active').trigger('shown.bs.tab');
            });
        </script>
    @endpush

@endsection
