@foreach ($pltMnv as $m)
<div class="col-12 col-md-12 col-lg-4">
    <div class="card @if ($insMon->where('plot_monev_id', $m->id)->first())
        card-primary
        @else
        card-warning
        @endif">
        <div class="card-header" style="height: 100px;">
            <div class="d-block">
                <h4 class="text-dark">{{ $m->getNameMataKuliah($m->klkl_id, $m->prodi) }}
                    ({{ $m->klkl_id }})</h4>
                <p class="m-0">{{ $m->programstudi->nama }}</p>
            </div>
            <div class="card-header-action ml-auto">
                <a data-collapse="#{{ $m->klkl_id.$m->nik_pengajar }}" class="btn btn-icon btn-info" href="#"><i
                        class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="collapse" id="{{ $m->klkl_id.$m->nik_pengajar }}">
            <div class="card-body">
                <b>Nama Dosen</b>
                <p>{{ $m->getNameKary($m->nik_pengajar) .' ('.$m->nik_pengajar.')' }}</p>
                <b>Nama Pemonev</b>
                <p>{{ $m->getNameKary($m->nik_pemonev) .' ('.$m->nik_pemonev.')' }}</p>
                <div class="row">
                    <div class="col-12 d-flex justify-content-start">
                        <div class="mr-5">
                            <b>Kelas</b>
                            <p>{{ $m->getKelasRuang($m->klkl_id, $m->nik_pengajar)['kelas'] }}</p>
                        </div>
                        <div>
                            <b>Ruang</b>
                            <p>{{ $m->getKelasRuang($m->klkl_id, $m->nik_pengajar)['ruang'] }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('monev.instrumen.index', ['id' => $m->id]) }}" class="btn @if ($insMon->where('plot_monev_id', $m->id)->first())

                btn-primary
                @else
                btn-warning
                @endif  btn-sm text-sm">
                @if ($insMon->where('plot_monev_id', $m->id)->first())
                Lihat Instrumen Monev
                @else
                Buat Instrumen Monev
                @endif
            </a>
        </div>
    </div>
</div>
@endforeach
