@extends('layouts.main')
@section('plottingmonev', 'active')
@section('', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">

            <div class="section-body">
                @if (session()->has('message'))
                <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" role="alert">
                    {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="my-3">
                    <h5>{{ 'Daftar Monev - '.$kary->nama }}</h5>
                </div>
                <div class="row">
                    @foreach ($pltMnv as $m)
                    <div class="col-12 col-md-12 col-lg-4">
                        <div class="card @if ($insMon->where('plot_monev_id', $m->id)->first())
                            card-primary
                            @else
                            card-warning
                            @endif">
                            <div class="card-header" style="height: 100px;">
                                <div class="d-block">
                                    <h4 class="text-dark">{{ $m->getNameMataKuliah($m->klkl_id) }}
                                        ({{ $m->klkl_id }})</h4>
                                    <p class="m-0">{{ $m->programstudi->nama }}</p>
                                </div>
                                <div class="card-header-action ml-auto">
                                    <a data-collapse="#{{ $m->klkl_id.$m->nik_pengajar }}" class="btn btn-icon btn-info"
                                        href="#"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="collapse" id="{{ $m->klkl_id.$m->nik_pengajar }}">
                                <div class="card-body">
                                    <b>Nama Dosen</b>
                                    <p>{{ $m->getNameKary($m->nik_pengajar) .' ('.$m->nik_pengajar.')' }}</p>
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-start">
                                            <div class="mr-5">
                                                <b>Kelas</b>
                                                <p>{{ $m->kelas }}</p>
                                            </div>
                                            <div>
                                                <b>Ruang</b>
                                                <p>{{ $m->getKelasRuang($m->klkl_id, $m->nik_pengajar, $m->kelas) }}
                                                </p>
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

                                @if (auth()->user()->role == 'p3ai')
                                <form class="ml-auto" action="{{ route('monev.plotting.destroy', $m->id) }}"
                                    method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm text-sm"
                                        onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash"></i>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
                @if ($pltMnv->hasPages())
                <div class="pagination-wrapper d-flex justify-content-end">
                    {{ $pltMnv->links() }}
                </div>

                @endif
            </div>


        </section>
    </div>
    @include('layouts.footer')
</div>
@endsection
@push('script')
@include('plotting-monev.script')
@endpush
