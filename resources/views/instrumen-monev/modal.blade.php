<div class="modal fade" role="dialog" data-backdrop="static" id="filMon">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter RPS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('monev.listMonev') }}">
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
