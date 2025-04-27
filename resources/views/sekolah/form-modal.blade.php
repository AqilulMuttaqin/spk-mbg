<div class="modal fade" id="sekolahModal" tabindex="-1" role="dialog" aria-labelledby="sekolahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sekolahModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="sekolahForm">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="nama_sekolah">Nama Sekolah</label>
                        <input type="text" class="form-control form-control-user" id="nama_sekolah" name="nama_sekolah" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="wilayah_kecamatan">Kecamatan</label>
                        <select class="form-control form-control-user" id="wilayah_kecamatan" required>
                            <option value="" disabled selected></option>
                            @foreach ($kecamatan as $kec)
                                <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="wilayah_kelurahan">Kelurahan</label>
                        <select class="form-control form-control-user" name="wilayah_kelurahan_id" id="wilayah_kelurahan" disabled required>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submmit" class="btn btn-sm btn-primary" id="submitSekolahBtn">Save Change</button>
                </div>
            </form>
        </div>
    </div>
</div>