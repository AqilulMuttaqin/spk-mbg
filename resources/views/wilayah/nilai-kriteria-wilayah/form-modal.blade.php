<div class="modal fade" id="nilaiKriteriaWilayahModal" tabindex="-1" role="dialog" aria-labelledby="nilaiKriteriaWilayahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nilaiKriteriaWilayahModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="nilaiKriteriaWilayahForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-3">
                            <p class="fw-bold">Kecamatan</p>
                        </div>
                        <div class="col-9">
                            <p id="kecamatan"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <p class="fw-bold">Kelurahan</p>
                        </div>
                        <div class="col-9">
                            <p id="kelurahan"></p>
                        </div>
                    </div><hr>
                    <p class="text-center fw-bold">Nilai Kriteria</p>
                    <input type="hidden" class="form-control form-control-user" name="nama_kelurahan">
                    <input type="hidden" class="form-control form-control-user" name="nama_kecamatan">
                    @foreach ($kriteriaWilayah as $kriteria)
                        <div class="form-group {{ !$loop->last ? 'mb-3' : '' }}">
                            <label for="{{ $kriteria->id }}">{{ $kriteria->nama_kriteria }}</label>
                            @if ($kriteria->tipe === 'angka')
                                <input type="number" step="any" class="form-control form-control-user" id="{{ $kriteria->id }}" name="kriteria-{{ $kriteria->id }}">
                            @else
                                <select class="form-control form-control-user" id="{{ $kriteria->id }}" name="kriteria-{{ $kriteria->id }}">
                                    <option value="" disabled selected></option>
                                    <option value="A">A (Sangat Baik)</option>
                                    <option value="B">B (Baik)</option>
                                    <option value="C">C (Cukup)</option>
                                    <option value="D">D (Kurang)</option>
                                    <option value="E">E (Sangat Kurang)</option>
                                </select>
                            @endif
                        </div>
                    @endforeach
                    <hr>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submmit" class="btn btn-sm btn-primary" id="submitNilaiKriteriaWilayahBtn">Save Change</button>
                </div>
            </form>
        </div>
    </div>
</div>