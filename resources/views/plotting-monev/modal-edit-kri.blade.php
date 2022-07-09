<div class="modal fade " role="dialog" id="editKri">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah PEO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('monev.updateCriteria') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="nikAdm" value="{{ auth()->user()->nik }}">
                    <input type="hidden" name="id" id="kri_id">
                    <div class="form-group">
                        <label>Kriteria Penilaian</label>
                        <input type="text" class="form-control" id="kriteria_penilaian" name="kri_penilaian"
                            value="{{ old('kriteria_penilaian') }}">
                        @error('kriteria_penilaian')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="row">

                        <div class="col-6">
                            <div class="form-group">
                                <label>Kategori</label>
                                <input type="text" class="form-control" id="kategori" name="kategori"
                                    value="{{ old('kategori') }}">
                                @error('kategori')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Bobot (%)</label>
                                <input type="number" class="form-control" id="bobot" name="bobot"
                                    value="{{ old('bobot') }}">
                                @error('bobot')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea id="deskripsi" style="width:100%; height: 100px;" class="form-control"
                            name="deskripsi" value="{{ old('deskripsi') }}"></textarea>
                        @error('deskripsi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
