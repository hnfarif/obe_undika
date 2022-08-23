@extends('layouts.main')
@section('laporan', 'active')
@section('monev', 'active')
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
                <div class="d-flex align-items-center my-0">
                    <div class="ml-auto">
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="optlaporan" value="monev" class="selectgroup-input"
                                    checked="">
                                <span class="selectgroup-button">Daftar Monev</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="optlaporan" value="rangkuman" class="selectgroup-input">
                                <span class="selectgroup-button">Rangkuman</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row monev">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Monev</h4>
                                <a href="{{ route('laporan.exportExcel') }}" class="btn btn-success ml-auto mr-3"> <i
                                        class="fas fa-file-excel"></i> Export Excel </a>
                                <a target="_blank"
                                    href="{{ route('laporan.exportPdf', ['fakultas' => request('fakultas'), 'prodi' => request('prodi'), 'dosen' => request('dosen') ]) }}"
                                    class="btn btn-danger mr-3">
                                    <i class="fas fa-file-pdf"></i> Export PDF </a>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#filterMonev">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="lapMonev" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center" rowspan="2">
                                                    No
                                                </th>
                                                <th rowspan="2">Nama MK</th>
                                                <th rowspan="2">Kelas</th>
                                                <th rowspan="2">Nama Dosen</th>
                                                @foreach ($kri as $k)
                                                <th>{{ 'Kriteria '.$loop->iteration }}</th>
                                                @endforeach
                                                <th rowspan="2">Nilai Akhir</th>
                                            </tr>
                                            <tr>
                                                @foreach ($kri as $k)
                                                <th>{{ $k->bobot.'%' }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($jdw as $j)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>{{ $j->getNameMataKuliah($j->klkl_id,$j->prodi) }}</td>
                                                <td>{{ $j->kelas }}</td>
                                                <td>{{ $j->karyawans->nama }}</td>
                                                @foreach ($kri as $k)

                                                @if ($j->cekKriteria($j->kary_nik,$j->klkl_id, $j->prodi) == 'insMon')

                                                @if ($loop->iteration == '1')
                                                <td class="text-warning text-center" colspan="4">
                                                    <b>Instrumen Monev belum dibuat</b>
                                                </td>
                                                @else
                                                <td class="d-none">

                                                </td>
                                                @endif
                                                @elseif ($j->cekKriteria($j->kary_nik,$j->klkl_id, $j->prodi) == 'plot')
                                                @if ($loop->iteration == '1')
                                                <td class="text-danger text-center" colspan="4">
                                                    <b>Plotting belum dibuat</b>
                                                </td>
                                                @else
                                                <td class="d-none">

                                                </td>
                                                @endif
                                                @else
                                                @if($loop->iteration == '1')
                                                <td data-bbt="{{ $k->bobot }}">
                                                    {{ $j->getNilaiKri1($j->kary_nik,$j->klkl_id, $j->prodi, $k->id) }}
                                                </td>
                                                @elseif($loop->iteration == '2')
                                                <td data-bbt="{{ $k->bobot }}">
                                                    {{ $j->getNilaiKri2($j->kary_nik,$j->klkl_id, $j->prodi, $k->id) }}
                                                </td>
                                                @elseif($loop->iteration == '3')
                                                <td data-bbt="{{ $k->bobot }}" data-prodi="{{ $j->prodi }}">
                                                    {{ $j->getNilaiKri3($j->kary_nik,$j->klkl_id, $j->prodi, $j->kelas) }}
                                                </td>
                                                @endif
                                                @endif
                                                @endforeach
                                                @if ($j->cekKriteria($j->kary_nik,$j->klkl_id, $j->prodi) == 'insMon' ||
                                                $j->cekKriteria($j->kary_nik,$j->klkl_id, $j->prodi) == 'plot')
                                                <td class="d-none">

                                                </td>
                                                @else
                                                <td id="naMonev">
                                                    {{ $j->getNilaiAkhir($j->kary_nik,$j->klkl_id, $j->prodi, $j->kelas) }}
                                                </td>
                                                @endif


                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row rangkuman d-none">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Rata-Rata monitoring evaluasi OBE</h4>

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Fakultas</th>
                                                <th>Nama Prodi</th>
                                                <th>Rata-Rata</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($fakul as $f)
                                            <tr>

                                                <td>{{ $f->nama }}</td>
                                                <td>
                                                    @foreach ($f->prodis as $p )
                                                    <div class="my-3">

                                                        {{ $p->nama.' ('.$p->id.')' }}
                                                    </div>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($f->prodis as $p )
                                                    <div class="avgMonev my-3" data-prodi="{{ $p->id }}">
                                                        {{ $p->getAvgMonev($p->id) }}
                                                    </div>
                                                    @endforeach
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
@include('laporan.monev.modal-monev')
@endsection
@push('script')
@include('laporan.monev.script')
@endpush
