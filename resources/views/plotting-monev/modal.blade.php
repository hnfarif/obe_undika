{{-- modal edit kriteria --}}
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

{{-- modal filter --}}
<div class="modal fade" role="dialog" data-backdrop="static" id="filPlot">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter RPS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('monev.plotting.index') }}">
                    <div class="row">
                        <div class="col-4">
                            <h6>Fakultas</h6>
                            @foreach ($fak as $f)
                            <div class="custom-control custom-checkbox checkbox-xl">
                                <input type="checkbox" name="fakultas[]" value="{{ $f->id }}"
                                    @if(is_array(request('fakultas')) && in_array($f->id, request('fakultas'))) checked
                                @endif
                                class="custom-control-input" id="listFak-{{ $loop->iteration }}">
                                <label class="custom-control-label"
                                    for="listFak-{{ $loop->iteration }}">{{ $f->nama }}</label>
                            </div>
                            @endforeach
                            <div class="mb-3"></div>
                            <h6>Prodi</h6>
                            @foreach ($prodi as $p)
                            <div class="custom-control custom-checkbox checkbox-xl">
                                <input type="checkbox" name="prodi[]" value="{{ $p->id }}" class="custom-control-input"
                                    @if(is_array(request('prodi')) && in_array($p->id, request('prodi'))) checked
                                @endif
                                id="prodi-{{ $loop->iteration }}">
                                <label class="custom-control-label"
                                    for="prodi-{{ $loop->iteration }}">{{ $p->nama.' ('.$p->id.')' }}</label>
                            </div>
                            @endforeach
                        </div>
                        <div class="col-8">
                            <h6>Dosen</h6>
                            <select name="dosen[]" id="" class="select2">
                                <option value="" selected disabled>Pilih Dosen</option>
                                @foreach ($kary as $k)
                                <option value="{{ $k->nik }}" @if(is_array(request('dosen')) && in_array($k->nik,
                                    request('dosen'))) selected
                                    @endif
                                    >{{ $k->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Cari data</button>
            </div>
            </form>
        </div>
    </div>
</div>
