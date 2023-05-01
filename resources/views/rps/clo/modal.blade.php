<div class="modal fade" role="dialog" data-backdrop="static" id="editClo">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah CLO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('clo.update') }}" method="POST">
                    @method('put')
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="rps_id" id="rps">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Kode CLO</label>
                                <input type="text" name="kode_clo" id="kode_clo"
                                    class="form-control @error('kode_clo') is-invalid @enderror" required readonly>
                                @error('kode_clo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Deskripsi CLO</label>
                                <textarea name="deskripsi" id="deskripsi" style="height: 100px"
                                    class="form-control @error('deskripsi') is-invalid @enderror" required
                                    autofocus>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Ranah Capaian Pembelajaran</label>
                                <select class="form-control select2 optranah @error('ranah_capai') is-invalid @enderror"
                                    name="ranah_capai[]" multiple="" required>
                                    @foreach ($ranah as $r)
                                    <option value="{{ $r->nama }}">{{ $r->nama }}</option>
                                    @endforeach
                                </select>
                                @error('ranah_capai')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">

                            <div class="form-group">
                                <label>Level Bloom</label>
                                <select class="form-control select2 optLevel @error('lvl_bloom') is-invalid @enderror"
                                    name="lvl_bloom[]" multiple="" required>
                                    @foreach ($level as $l)
                                    <option value="{{ $l->kode_level.' - '.$l->nama }}">
                                        {{ $l->kode_level.' - '.$l->nama }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('lvl_bloom')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Tambah Plo yang didukung</label>
                                <select id="ploid" class="form-control  @error('ploid') is-invalid @enderror select2"
                                    name="ploid[]" multiple="" required>

                                </select>
                                @error('ploid')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Target Kelulusan (%)</label>

                                <input type="number" name="target_lulus" id="target_lulus"
                                    class="form-control @error('target_lulus') is-invalid @enderror" min="0" max="100"
                                    value="{{ old('target_lulus') }}" required>
                                @error('target_lulus')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Nilai Minimal</label>

                                <input type="number" name="nilai_min" id="nilai_min"
                                    class="form-control @error('nilai_min') is-invalid @enderror " min="0" max="100"
                                    value="{{ old('nilai_min') }}" required>
                                @error('nilai_min')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
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
