@extends('layout.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h5>Data Perhitungan ELECTRE III</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="accordion" id="electreSteps">
                {{-- Langkah 1: Data Awal --}}
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingDataAwal">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDataAwal" aria-expanded="true" aria-controls="collapseDataAwal">
                            Langkah 1: Data Awal
                        </button>
                    </h2>
                    <div id="collapseDataAwal" class="accordion-collapse collapse show" aria-labelledby="headingDataAwal" data-bs-parent="#electreSteps">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-striped text-nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Alternatif</th>
                                            @foreach (array_keys($data->first() ?? []) as $kriteria)
                                                <th>{{ $kriteria }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $row)
                                            <tr>
                                                <td>A{{ $loop->iteration }}</td>
                                                @foreach ($row as $value)
                                                    <td>{{ $value }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>
                </div>
        
                {{-- Langkah 2: Normalisasi --}}
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingNormalisasi">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNormalisasi" aria-expanded="false" aria-controls="collapseNormalisasi">
                            Langkah 2: Normalisasi
                        </button>
                    </h2>
                    <div id="collapseNormalisasi" class="accordion-collapse collapse" aria-labelledby="headingNormalisasi" data-bs-parent="#electreSteps">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-striped text-nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Alternatif</th>
                                            @foreach (array_keys($normalisasi[0] ?? []) as $kriteria)
                                                <th>{{ $kriteria }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($normalisasi as $row)
                                            <tr>
                                                <td>A{{ $loop->iteration }}</td>
                                                @foreach ($row as $value)
                                                    <td>{{ $value }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>
                </div>
        
                {{-- Langkah 3: Bobot Ternormalisasi --}}
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingBobot">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBobot" aria-expanded="false" aria-controls="collapseBobot">
                            Langkah 3: Bobot Ternormalisasi
                        </button>
                    </h2>
                    <div id="collapseBobot" class="accordion-collapse collapse" aria-labelledby="headingBobot" data-bs-parent="#electreSteps">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-striped text-nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Alternatif</th>
                                            @foreach (array_keys($bobotTernormalisasi[0] ?? []) as $kriteria)
                                                <th>{{ $kriteria }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bobotTernormalisasi as $row)
                                            <tr>
                                                <td>A{{ $loop->iteration }}</td>
                                                @foreach ($row as $value)
                                                    <td>{{ $value }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>
                </div>
        
                {{-- Langkah 4: Nilai Concordance dan Discordance --}}
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingConcordanceDiscordance">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseConcordanceDiscordance" aria-expanded="false" aria-controls="collapseConcordanceDiscordance">
                            Langkah 4: Nilai Concordance & Discordance
                        </button>
                    </h2>
                    <div id="collapseConcordanceDiscordance" class="accordion-collapse collapse" aria-labelledby="headingConcordanceDiscordance" data-bs-parent="#electreSteps">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-6">
                                    <h6>Concordance</h6>
                                    <div class="table-responsive">
                                        <table class="table table-striped text-nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>Pasangan</th>
                                                    <th>Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($concordanceSet as $key => $set)
                                                    <tr>
                                                        <td>{{ $key . ' = {' . implode(', ', $set) . '}' }}</td>
                                                        <td>{{ $concordanceValue[$key] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div> 
                                </div>
                                <div class="col-6">
                                    <h6>Discordance</h6>
                                    <div class="table-responsive">
                                        <table class="table table-striped text-nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>Pasangan</th>
                                                    <th>Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($discordanceSet as $key => $set)
                                                    <tr>
                                                        <td>{{ $key . ' = {' . implode(', ', $set) . '}' }}</td>
                                                        <td>{{ $discordanceValue[$key] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
                {{-- Langkah 5: Matriks Concordance --}}
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingMatriksConcordance">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMatriksConcordance" aria-expanded="false" aria-controls="collapseMatriksConcordance">
                            Langkah 5: Matriks Concordance
                        </button>
                    </h2>
                    <div id="collapseMatriksConcordance" class="accordion-collapse collapse" aria-labelledby="headingMatriksConcordance" data-bs-parent="#electreSteps">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table text-nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            @for ($j = 1; $j <= count($bobotTernormalisasi); $j++)
                                                <th>A{{ $j }}</th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 1; $i <= count($bobotTernormalisasi); $i++)
                                            <tr>
                                                <th>A{{ $i }}</th>
                                                @for ($j = 1; $j <= count($bobotTernormalisasi); $j++)
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
                    </div>
                </div>
        
                {{-- Langkah 6: Matriks Discordance --}}
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingMatriksDiscordance">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMatriksDiscordance" aria-expanded="false" aria-controls="collapseMatriksDiscordance">
                            Langkah 6: Matriks Discordance
                        </button>
                    </h2>
                    <div id="collapseMatriksDiscordance" class="accordion-collapse collapse" aria-labelledby="headingMatriksDiscordance" data-bs-parent="#electreSteps">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table text-nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            @for ($j = 1; $j <= count($bobotTernormalisasi); $j++)
                                                <th>A{{ $j }}</th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 1; $i <= count($bobotTernormalisasi); $i++)
                                            <tr>
                                                <th>A{{ $i }}</th>
                                                @for ($j = 1; $j <= count($bobotTernormalisasi); $j++)
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
                    </div>
                </div>

            </div>    
        </div>    
    </div>
@endsection
