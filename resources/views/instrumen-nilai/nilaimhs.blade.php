@extends('layouts.main')
@section('instrumen-nilai', 'active')
@section('content')
<style>
    table.dataTable.table-striped.DTFC_Cloned tbody tr:nth-of-type(odd) {
        background-color: #F3F3F3;
    }

    table.dataTable.table-striped.DTFC_Cloned tbody tr:nth-of-type(even) {
        background-color: white;
    }

</style>
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

                @if ($startFill <= $now) <div class="alert alert-info alert-has-icon">
                    <div class="alert-icon"><i class="far fa-lightbulb"></i> </div>
                    <div class="alert-body">
                        <div class="alert-title">Minggu Ke {{ $week }}</div>
                        Harap mengisi nilai mahasiswa pada
                        @foreach ($dtlAgd->where('agd_id',
                        $getPekan->id)->where('penilaian_id', '<>', null)->unique('clo_id') as $da)
                        {{ $da->clo->kode_clo }}
                        @endforeach pada penilaian
                        @foreach ($dtlAgd->where('agd_id',
                        $getPekan->id)->where('penilaian_id', '<>', null)->unique('penilaian_id') as $key => $pen)
                                @if ($loop->last)
                                {{ $pen->penilaian->btk_penilaian ?? '' }}
                                @else
                                {{ $pen->penilaian->btk_penilaian.', ' ?? '' }}
                                @endif
                        @endforeach
                        , sebelum tanggal {{ date_format($endFill, 'd-m-Y') }}.
                    </div>

                </div>
                @endif

                <div class="d-flex align-items-center my-0">
                    <h2 class="section-title titleClo">Instrumen Nilai Mahasiswa</h2>
                    <div class="ml-auto">
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="optvclo" value="ttgMk" class="selectgroup-input">
                                <span class="selectgroup-button">Tentang MK</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="optvclo" value="penClo" class="selectgroup-input" checked="">
                                <span class="selectgroup-button">Penilaian CLO</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="optvclo" value="konvAak" class="selectgroup-input">
                                <span class="selectgroup-button">Konversi AAK</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="optvclo" value="rangClo" class="selectgroup-input">
                                <span class="selectgroup-button">Rangkuman CLO</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row ttgMk d-none">
                    <div class="col-12 col-md-6 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Deskripsi Mata Kuliah</h4>
                            </div>
                            <div class="card-body">
                                <table class="table-sm table-responsive">
                                    <thead>
                                        <tr class="">
                                            <th style="min-width: 200px;">Program Studi</th>
                                            <td style="width: 100%;">{{ $mk->prodi->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama MK</th>
                                            <td style="width: 100%;">{{ $mk->nama }}</td>
                                        </tr>

                                        <tr>
                                            <th>Kelas</th>
                                            <td style="width: 100%;">{{ $jdw->kelas }}</td>
                                        </tr>

                                        <tr>
                                            <th>Dosen</th>
                                            <td style="width: 100%;">{{ $instru->karyawan->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Semester</th>
                                            <td style="width: 100%;">{{ $instru->semester }}</td>
                                        </tr>
                                        <tr>
                                            <th>Target Nilai Min MK</th>
                                            <td style="width: 100%;">
                                                <form action="{{ route('penilaian.putNilaiMin') }}" method="POST"
                                                    class="d-flex">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" value="{{ $idIns }}" name="idIns">
                                                    <input class="form-control w-25" type="number" name="nilai_min_mk"
                                                        id="nilai_min_mk" required value="{{ $instru->nilai_min_mk }}"
                                                        @if ($instru->nilai_min_mk)
                                                    readonly @endif>

                                                    <button type="submit"
                                                        class="btn btn-sm btn-primary ml-3 @if ($instru->nilai_min_mk) d-none @endif btnSaveNilaiMk">
                                                        <i class="fas fa-save">
                                                        </i>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-primary ml-3 @if (!$instru->nilai_min_mk) d-none @endif  btnEditNilaiMk">
                                                        <i class="fas fa-edit">
                                                        </i>
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Target CLO</h4>
                            </div>
                            <div class="card-body">
                                <table class="table-sm table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>ID CLO</th>
                                            <th>Presentase</th>
                                            <th>Target Nilai (minimal)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dtlAgd->unique('clo_id') as $da)
                                        <tr class="text-center">
                                            <td>{{ $da->clo->kode_clo }}</td>
                                            <td>{{ $dtlAgd->where('penilaian_id', '<>', null)->where('clo_id', $da->clo_id)->sum('bobot') }}
                                                %
                                            </td>
                                            <td>{{ $da->clo->nilai_min }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row penClo" id="penClo">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header ">
                                <h4>Daftar Nilai Mahasiswa</h4>
                                <button class="btn btn-primary ml-auto btnSimpanNilai" disabled><i
                                        class="fas fa-save"></i> Simpan
                                    Penilaian
                                    CLO</button>
                            </div>
                            <div class="card-body">

                                <table class="table table-striped table-responsive" width="100%" id="tableIns">
                                    <thead>
                                        <tr>

                                            <th rowspan="4" class="align-middle text-center">NIM</th>
                                            <th rowspan="4" class="align-middle text-center">Nama Mahasiswa</th>
                                            @foreach ($dtlAgd->unique('clo_id') as $da)

                                            <th
                                                colspan="{{ $dtlAgd->where('clo_id', $da->clo_id)->where('penilaian_id', '<>', null)->count() }}">

                                                {{ $da->clo->kode_clo }}

                                            </th>
                                            <th rowspan="4" class="align-middle text-center bg-light">

                                                Total
                                                {{ $da->clo->kode_clo }}
                                            </th>
                                            <th rowspan="4" class="align-middle text-center bg-light">
                                                Nilai Konversi
                                            </th>
                                            <th rowspan="4" class="align-middle text-center bg-light">
                                                Status Kelulusan (T/TL)
                                            </th>
                                            @endforeach

                                            <th rowspan="4" class="align-middle text-center ">Nilai Mentah Akhir
                                                OBE
                                            </th>

                                            <th rowspan="4" class="align-middle text-center ">Nilai Huruf OBE</th>

                                            <th rowspan="4" class="align-middle text-center">Status
                                                Kelulusan OBE (L/TL)
                                            </th>
                                        </tr>
                                        <tr>
                                            @foreach ($dtlAgd->unique('clo_id')->sortBy('agd_id') as $cl)
                                            @foreach ($dtlAgd->where('clo_id', $cl->clo_id)->where('penilaian_id', '<>', null) as
                                            $pen)

                                            <th class="
                                            @if ($pen->agd_id == $getPekan->id)
                                            bg-info text-white

                                            @endif
                                            ">
                                                {{ $pen->penilaian->btk_penilaian.'-'.$pen->agendaBelajar->pekan}}
                                            </th>
                                            @endforeach
                                            @endforeach
                                        </tr>
                                        <tr>
                                            @foreach ($dtlAgd->unique('clo_id')->sortBy('agd_id') as $cl)
                                            @foreach ($dtlAgd->where('clo_id', $cl->clo_id)->where('penilaian_id', '<>', null) as
                                            $pen)

                                            <th class=" @if ($pen->agd_id == $getPekan->id)
                                                bg-info text-white
                                                @endif ">{{ $pen->penilaian->jenis}}</th>
                                            @endforeach
                                            @endforeach

                                        </tr>
                                        <tr>
                                            @foreach ($dtlAgd->unique('clo_id')->sortBy('agd_id') as $cl)
                                            @foreach ($dtlAgd->where('clo_id', $cl->clo_id)->where('penilaian_id', '<>', null) as
                                            $pen)

                                            <th class="bbtPen  @if ($pen->agd_id == $getPekan->id)
                                                bg-info text-white
                                            @endif" data-jns="{{ $pen->penilaian->jenis }}">{{ $pen->bobot.'%'}}</th>
                                            @endforeach
                                            @endforeach

                                        </tr>

                                    </thead>
                                    <tbody>
                                        @foreach ($krs as $k)
                                        <tr>
                                            <td>
                                                {{ $k->mhs_nim }}
                                            </td>
                                            <td>

                                                {{ $k->mahasiswa->nama }}
                                            </td>
                                            @foreach ($dtlAgd->unique('clo_id')->sortBy('agd_id') as $cl)
                                            @foreach ($dtlAgd->where('clo_id', $cl->clo_id)->where('penilaian_id', '<>', null) as
                                            $pen)

                                            <td>
                                                <input type="hidden" id="idDtlAgd" value="{{ $pen->id }}">
                                                <input type="hidden" id="bobot" value="{{ $pen->bobot }}">
                                                <input type="hidden" id="nim" value="{{ $k->mhs_nim }}">
                                                <input type="number"
                                                    value="{{ $pen->detailInstrumenNilai->where('mhs_nim', $k->mhs_nim)
                                                    ->where('ins_nilai_id', $idIns)->first()->nilai ?? '' }}"
                                                    max="100"
                                                    min="0"
                                                    class="form-control text-center nilai" data-cl="{{ $cl->clo_id }}"
                                                    data-jns ="{{ $pen->penilaian->jenis }}"
                                                    style="min-width:60px;" @if (!$pen->agendaBelajar->cekDate($pen->agendaBelajar->tgl_nilai, $now) || $isRead)
                                                    readonly
                                                    @endif >
                                            </td>
                                            @endforeach
                                            <td class="text-center align-middle ttlClo" data-cl="{{ $cl->clo_id }}"></td>

                                            <td class="text-center align-middle nKvs"
                                            data-sumbobot="{{ $dtlAgd->where('penilaian_id', '<>', null)->where('clo_id', $cl->clo_id)->sum('bobot') }}" data-cl="{{ $cl->clo_id }}">

                                            </td>

                                            <td class="text-center align-middle stsLulus" data-cl="{{ $cl->clo_id }}"
                                            data-nilaimin="{{ $cl->clo->nilai_min }}"
                                            >

                                            </td>
                                            @endforeach

                                            <td class="align-middle text-center naObe" ></td>

                                            <td class="align-middle text-center nhObe"></td>

                                            <td class="align-middle text-center stsaLulus"></td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2"></th>
                                            @foreach ($dtlAgd->unique('clo_id') as $da)

                                            <th class="text-right" colspan="{{ $dtlAgd->where('clo_id', $da->clo_id)->where('penilaian_id', '<>', null)->count() }}">
                                            Rata - Rata untuk {{ $da->clo->kode_clo }}
                                            </th>

                                            <th class="text-center align-middle avgTtl" data-cl="{{ $da->clo_id }}"></th>

                                            <th class="text-center align-middle avgKvs" data-cl="{{ $da->clo_id }}">
                                            </th>

                                            <th class="text-center align-middle avgStsLulus"
                                            data-cl="{{ $da->clo_id }}"
                                            data-nilaimin="{{ $da->clo->nilai_min }}"
                                            >

                                            </th>
                                            @endforeach
                                        </tr>
                                    </tfoot>
                                </table>


                            </div>
                        </div>

                    </div>
                </div>

                <div class="row rangClo d-none">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                               <h4>Rangkuman CLO</h4>
                               <button class="btn btn-primary ml-auto btnSaveSum" disabled><i
                                class="fas fa-save"></i>Simpan Rangkuman</button>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-responsive" width="100%" id="tableSummary">
                                    <thead>
                                        <tr class="text-center align-middle">
                                            <th style="min-width: 100px;">ID CLO</th>
                                            <th>Target CLO</th>
                                            <th style="min-width: 100px;">Rata - rata Nilai Capaian CLO</th>
                                            <th>Keterangan</th>
                                            <th>Jumlah Mahasiswa memenuhi target</th>
                                            <th>Jumlah Mahasiswa belum memenuhi target</th>
                                            <th>Penyebab Kegagalan</th>
                                            <th>Langkah Perbaikan</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        @foreach ($dtlAgd->unique('clo_id') as $da)

                                        <tr class="text-center">
                                            <td style="width:100px;" class="align-middle">
                                                {{ $da->clo->kode_clo }}
                                            </td>
                                            <td class="tgtClo align-middle">
                                                {{ $da->clo->nilai_min }}
                                            </td>
                                            <td class="align-middle rangAvgKvs" data-cl="{{ $da->clo_id }}">

                                            </td>
                                            <td class="align-middle rangKet">

                                            </td>
                                            <td class="align-middle rangJmlLulus" data-cl="{{ $da->clo_id }}">

                                            </td>
                                            <td class="align-middle rangJmlTl" data-cl="{{ $da->clo_id }}">

                                            </td>
                                            <td>
                                                <textarea class="form-control mt-2 mb-2 csFail"  id="csFail" style="width:200px; height: 80px;"
                                                @if ($isRead)
                                                    readonly
                                                @endif
                                                data-clo="{{ $da->clo_id }}"
                                                data-ins="{{ $idIns }}"
                                                data-sts="csFail"
                                                >{{ $summary->where('clo_id', $da->clo_id)->first()->sbb_gagal ?? ' ' }}</textarea>
                                            </td>
                                            <td>
                                                <textarea class="form-control mt-2 mb-2 improvClo" id="improvClo" style="width:200px; height: 80px;"
                                                @if ($isRead)
                                                    readonly
                                                @endif
                                                data-clo="{{ $da->clo_id }}"
                                                data-ins="{{ $idIns }}"
                                                data-sts="improvClo">{{ $summary->where('clo_id', $da->clo_id)->first()->perbaikan ?? ' ' }}</textarea>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-md-12 mb-5 mr-auto">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Grafik Ketercapaian CLO</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="cloChart" width="20" height="20"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row konvAak d-none">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>                                Konversi AAK
                                </h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-responsive" width="100%" id="tableKonv">
                                    <thead>
                                        <tr class="align-middle text-center">
                                            <th class="align-middle" rowspan="2">NIM</th>
                                            <th class="align-middle" rowspan="2">Nama Mahasiswa</th>
                                            @foreach ($dtlAgd->where('penilaian_id', '<>', null)->map(function($d){return $d->penilaian;})->unique('jenis') as $da)

                                            <th>{{ $da->jenis }}</th>
                                            @endforeach
                                            <th class="align-middle" rowspan="2" >Nilai Mentah Akhir AAK</th>
                                            <th class="align-middle" rowspan="2">Nilai Huruf AAK</th>
                                            <th class="align-middle"  rowspan="2">Status Kelulusan AAK (L/TL)</th>
                                        </tr>
                                        <tr class="text-center align-middle">
                                            @foreach ($dtlAgd->where('penilaian_id', '<>', null)->map(function($d){return $d->penilaian;})->unique('jenis') as $da)

                                            <th class="bbtKonv" data-jns="{{ $da->jenis }}"></th>

                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($krs as $k)
                                        <tr class="text-center align-middle">
                                            <td>
                                                {{ $k->mhs_nim }}
                                            </td>
                                            <td>
                                                {{ $k->mahasiswa->nama }}
                                            </td>
                                            @foreach ($dtlAgd->where('penilaian_id', '<>', null)->map(function($d){return $d->penilaian;})->unique('jenis') as $da)

                                            <td class="nilaiKonv" data-jns="{{ $da->jenis }}" data-nim="{{ $k->mhs_nim }}">
                                            ></td>

                                            @endforeach
                                            <td class="naAak"></td>
                                            <td class="nhAak"></td>
                                            <td class="stsLulusAak"></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </section>
    </div>
    @include('layouts.footer')
</div>
@endsection
@push('script')
@include('instrumen-nilai.script-nilaimhs')
@endpush
