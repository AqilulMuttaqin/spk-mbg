<div class="modal fade" id="kriteriaModal" tabindex="-1" role="dialog" aria-labelledby="kriteriaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kriteriaModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="kriteriaForm">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="nama_kriteria">Nama Kriteria</label>
                        <input type="text" class="form-control form-control-user" id="nama_kriteria" name="nama_kriteria" required>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="kategori">Kategori</label>
                                <select class="form-control form-control-user" id="kategori" name="kategori" required>
                                    <option value="" disabled selected></option>
                                    <option value="wilayah">Wilayah</option>
                                    <option value="sekolah">Sekolah</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="tipe">Tipe</label>
                                <select class="form-control form-control-user" id="tipe" name="tipe" required>>
                                    <option value="" disabled selected></option>
                                    <option value="angka">Angka</option>
                                    <option value="non-angka">Non Angka</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3" id="satuanWrapper">
                        <label for="satuan">Satuan</label>
                        <input type="text" class="form-control form-control-user" id="satuan" name="satuan" required>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="sifat">Sifat</label>
                                <select class="form-control form-control-user" id="sifat" name="sifat" required>>
                                    <option value="" disabled selected></option>
                                    <option value="benefit">Benefit</option>
                                    <option value="cost">Cost</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="bobot">Bobot</label>
                                <input type="number" class="form-control form-control-user" id="bobot" name="bobot" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary" id="submitBtn">Save Change</button>
                </div>
            </form>
        </div>
    </div>
</div>