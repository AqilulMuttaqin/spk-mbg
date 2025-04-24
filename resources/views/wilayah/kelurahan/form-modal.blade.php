<div class="modal fade" id="wilayahKelurahanModal" tabindex="-1" role="dialog" aria-labelledby="wilayahKelurahanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="wilayahKelurahanModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="wilayahKelurahanForm">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="wilayah_kecamatan_id">Kecamatan</label>
                        <select class="form-control form-control-user" name="wilayah_kecamatan_id" id="wilayah_kecamatan_id" required>
                            <option value="" disabled selected></option>
                            @foreach ($kecamatan as $kec)
                                <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_kelurahan">Nama Kelurahan</label>
                        <input type="text" class="form-control form-control-user" id="nama_kelurahan" name="nama_kelurahan" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submmit" class="btn btn-sm btn-primary" id="submitKelurahanBtn">Save Change</button>
                </div>
            </form>
        </div>
    </div>
</div>