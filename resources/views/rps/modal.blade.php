<div class="modal fade" role="dialog" data-backdrop="static" id="filRps">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter RPS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('rps.index') }}">
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
                            <h6>Status</h6>
                            <div class="custom-control custom-checkbox checkbox-xl">
                                <input type="checkbox" name="status[]" value="1" class="custom-control-input"
                                    @if(is_array(request('status')) && in_array(1, request('status'))) checked @endif
                                    id="status-1">
                                <label class="custom-control-label" for="status-1">Done</label>
                            </div>
                            <div class="custom-control custom-checkbox checkbox-xl">
                                <input type="checkbox" name="status[]" value="0" class="custom-control-input"
                                    @if(is_array(request('status')) && in_array(0, request('status'))) checked @endif
                                    id="status-0">
                                <label class="custom-control-label" for="status-0">To Do</label>
                            </div>
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

{{-- modal set email --}}
<div class=" modal fade" role="dialog" id="modalPenyusun">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Dosen Penyusun</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Dosen</label>
                    <select class="form-control select2">
                        <option>Dosen 1</option>
                        <option>Dosen 2</option>
                        <option>Dosen 3</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
{{-- modal edit data RPS --}}
<div class="modal fade" role="dialog" id="editRps">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titleRps">Ubah data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('rps.update') }}" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="rps_id" id="rps">
                    <div class="form-group">
                        <label>Nama Rumpun Mata Kuliah</label>
                        <input type="text" id="rumpun_mk" name="rumpun_mk"
                            class="form-control @error('rumpun_mk') is-invalid @enderror"
                            placeholder="cth : PENGELOLAAN DATA DAN INFORMASI" required>
                        @error('rumpun_mk')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Ketua Rumpun</label>
                        <select id="ketua_rumpun"
                            class="form-control select2 @error('ketua_rumpun') is-invalid @enderror" name="ketua_rumpun"
                            required>

                            @foreach ($dosens as $i)
                            <option value="{{ $i->nik }}">{{ $i->nama }}
                            </option>

                            @endforeach
                        </select>
                        @error('ketua_rumpun')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Semester Pembuatan</label>
                        <input type="text" id="semester" name="semester"
                            class="form-control @error('semester') is-invalid @enderror"
                            placeholder="cth : 201, 202, 211" required>
                        @error('semester')
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

<div class="modal fade" role="dialog" id="saveRps">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Simpan RPS
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('rps.file.store') }}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <input type="hidden" name="mrps_id" id="mrps_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Masukkan File RPS </label>
                        <div class="custom-file">
                            <input class="form-control @error('rps') is-invalid
                            @enderror" type="file" name="rps" id="formFile" required>

                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btnSaveRps" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>