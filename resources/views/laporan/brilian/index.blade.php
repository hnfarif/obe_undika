@extends('layouts.main')
@section('laporan', 'active')
@section('brilian', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">

            @include('laporan.section-header')
            <div class="section-body">
                @if (session()->has('message'))
                <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" role="alert">
                    {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <div class="row monev">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Penggunaan Brilian</h4>
                                <form action="{{ route('laporan.brilian.store') }}" method="POST" class="ml-auto mr-3">
                                    @csrf

                                    <input type="hidden" value="{{ $week->count() + 1 }}" name="minggu">
                                    <input type="hidden" value="{{ $smt }}" name="semester">

                                    @foreach ($data as $item)
                                    <input type="hidden" name="data[nik][]" value="{{ $item->nik }}">
                                    <input type="hidden" name="data[kode_mk][]" value="{{ $item->kode_mk }}">
                                    <input type="hidden" name="data[kelas][]" value="{{ $item->kelas }}">
                                    <input type="hidden" name="data[prodi][]" value="{{ $item->prodi }}">
                                    <input type="hidden" name="data[skor][]" value="{{ $item->skor_total }}">
                                    @endforeach

                                    <button class="btn btn-success" type="submit">
                                        <i class="fas fa-plus"></i> Tambah nilai minggu {{ $week->count() + 1 }}
                                    </button>
                                </form>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#filterBrilian">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-responsive" id="lapBrilian" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center" rowspan="2">
                                                    Dosen
                                                </th>
                                                <th rowspan="2">Nama MK</th>
                                                <th rowspan="2">Kode MK</th>
                                                <th rowspan="2">Kelas</th>
                                                <th rowspan="2">Prodi</th>
                                                @foreach ($indikator as $i)
                                                <th colspan="2">{{ 'Kriteria '.$loop->iteration }}</th>
                                                @endforeach
                                                <th rowspan="2">Skor Total</th>

                                                @foreach ($week as $w)

                                                <th rowspan="2">{{ 'Nilai Minggu ke '.$w->minggu_ke }}</th>
                                                @endforeach

                                                <th rowspan="2">Badges</th>
                                            </tr>
                                            <tr>
                                                @foreach ($indikator as $i)
                                                <th>{{ $i->nama }}</th>
                                                <th>Skor</th>
                                                @endforeach
                                            </tr>

                                        </thead>
                                        <tbody>
                                            @foreach ($data as $d)
                                            <tr>
                                                <td>

                                                    {{ $d->nama_dosen }}
                                                </td>
                                                <td>{{ $d->nama_course }}</td>
                                                <td>{{ $d->kode_mk }}</td>
                                                <td>{{ $d->kelas }}</td>
                                                <td>{{ $d->prodi }}</td>
                                                @foreach ($d->jml_modul as $j)
                                                <td>
                                                    {{ $j }}
                                                </td>
                                                <td>
                                                    {{ $d->skor[$loop->index] }}
                                                </td>
                                                @endforeach
                                                <td>
                                                    {{ $d->skor_total }}
                                                </td>
                                                @foreach ($week as $w)

                                                <td>
                                                    {{ number_format($dtlBri->where('brilian_week_id', $w->id)->where('nik', $d->nik)->where('kode_mk', $d->kode_mk)->where('kelas', $d->kelas)->where('prodi', $d->prodi)->first()->nilai, 1) }}
                                                </td>
                                                @endforeach
                                                <td class="badges">

                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>
    </div>
    @include('layouts.footer')
</div>
@include('laporan.brilian.modal-brilian')
@endsection
@push('script')
@include('laporan.brilian.script')
@endpush
