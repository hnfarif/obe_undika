<div class="my-3 d-flex">
    <form class="card-header-form ml-auto" action="{{ route('rps.index') }}">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari nama matakuliah"
                value="{{ request('search') }}">
            <div class="input-group-btn d-flex">
                <button class="btn btn-primary btn-icon"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </form>
</div>
<div class="row">
    @foreach ($rps as $r)

    <div class="col-12 col-md-12 col-lg-4">
        <div class="card @if($r->is_done == 1) card-success @else card-warning
        @endif">
            <div class="card-header" style="height: 100px;">
                <div class="d-block">
                    <h4 class="text-dark">{{ $r->nama_mk }} ({{ $r->kurlkl_id }})</h4>
                    <p class="m-0">{{ $r->matakuliah->prodi->nama }}</p>
                </div>
                <div class="card-header-action ml-auto">
                    <a data-collapse="#{{ $r->id }}" class="btn btn-icon btn-info" href="#"><i
                            class="fas fa-plus"></i></a>
                </div>
            </div>
            <div class="collapse" id="{{ $r->id }}">
                <div class="card-body">
                    <b>Rumpun Mata Kuliah</b>
                    <p>{{ $r->rumpun_mk }}</p>
                    <b>Fakultas</b>
                    <p class="">{{ $r->matakuliah->prodi->fakultas->nama }}</p>
                    <div class="row mb-2">
                        <div class="col-12">
                            <div>
                                <b>Ketua Rumpun</b>
                                <p class="">{{ $r->karyawan->nama }}</p>
                            </div>
                            <div>
                                <b>Penyusun</b>
                                <div>
                                    {{ $r->dosenPenyusun->nama }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between">
                            <div>
                                <b>Semester</b>
                                <p>{{ $r->semester }}</p>
                            </div>
                            <div>
                                <b>SKS</b>
                                <p>{{ $r->matakuliah->sks }}</p>
                            </div>
                            <div>
                                <b>Status</b>
                                <div>
                                    @if ($r->is_done)
                                    <div class="badge badge-success">Done</div>
                                    @else
                                    <div class="badge badge-warning">To do</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer">
                @if ($r->file_rps)
                <a href="{{ asset('storage/'.$r->file_rps) }}" target="_blank" class="btn btn-primary btn-sm mr-1 "> <i
                        class="fas fa-file-pdf"></i> Lihat PDF</a>

                <button type="button" class="btn btn-info btn-sm mr-1 saveRps" data-id="{{ $r->id }}"> <i
                        class="fas fa-edit"></i> Ubah PDF</button>
                @else
                <button type="button" class="btn btn-warning btn-sm mr-1 saveRps" data-id="{{ $r->id }}"><i
                        class="fas fa-file-upload"></i> Upload
                    RPS </button>
                @endif
                <a href="{{ route('clo.index', $r->id) }}" class="btn btn-light btn-sm">Kelola Rps</a>

            </div>
        </div>
    </div>
    @endforeach
    @if($rps->isEmpty())
    <div class="col-12">
        <div class="alert alert-info">
            Tidak ada data
        </div>
    </div>
    @endif
</div>
@if ($rps->hasPages())
<div class="pagination-wrapper d-flex justify-content-end">
    {{ $rps->links() }}
</div>

@endif
