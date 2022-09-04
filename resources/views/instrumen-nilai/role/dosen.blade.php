<div class="my-3 d-flex">
    <form class="card-header-form ml-auto" action="{{ route('penilaian.clo.index') }}">
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
    @foreach ($jdwkul as $jdw)
    <div class="col-12 col-md-12 col-lg-4">
        <div
            class="card @if ($instru->where('klkl_id', $jdw->klkl_id)->where('nik',$jdw->kary_nik)->first()) card-primary @else card-warning @endif">
            <div class="card-header" style="height: 100px;">
                <div class="d-block">
                    <h4 class="text-dark">{{ $jdw->getNameMataKuliah($jdw->klkl_id,$jdw->prodi) }}
                        ({{ $jdw->klkl_id }})</h4>
                    <p class="m-0">{{ $jdw->getNameProdi($jdw->prodi) }}</p>
                </div>
                <div class="card-header-action ml-auto">
                    <a data-collapse="#{{ $jdw->klkl_id }}" class="btn btn-icon btn-info" href="#"><i
                            class="fas fa-plus"></i></a>
                </div>
            </div>
            <div class="collapse" id="{{ $jdw->klkl_id }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between">
                            <div>
                                <b>Kelas</b>
                                <p>{{ $jdw->kelas }}</p>
                            </div>
                            <div>
                                <b>SKS</b>
                                <p>{{ $jdw->sks }}</p>
                            </div>
                            <div>
                                <b>Ruang</b>
                                <p>{{ $jdw->ruang_id }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer">
                <button data-mk="{{ $jdw->prodi.$jdw->klkl_id }}" data-nik={{ $jdw->kary_nik }} class="btn @if ($instru->where('klkl_id', $jdw->klkl_id)->where('nik',$jdw->kary_nik)->first()) btn-primary @else btn-warning @endif btn-sm
                                        btnUbahNilai">@if ($instru->where('klkl_id',
                    $jdw->klkl_id)->where('nik',$jdw->kary_nik)->first()) Lihat Instrumen
                    @else Buat Instrumen @endif
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>
@if ($jdwkul->hasPages())
<div class="pagination-wrapper d-flex justify-content-end">
    {{ $jdwkul->links() }}
</div>

@endif
