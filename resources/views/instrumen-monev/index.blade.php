@extends('layouts.main')
@section('instrumen-monev', 'active')
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

                <div class="d-flex align-items-center my-0">
                    <div class="ml-auto">
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="optMon" value="monev" class="selectgroup-input" checked="">
                                <span class="selectgroup-button">Instrumen Monev</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="optMon" value="insNilai" class="selectgroup-input">
                                <span class="selectgroup-button">Instrumen Nilai CLO</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="optMon" value="bap" class="selectgroup-input">
                                <span class="selectgroup-button">BAP</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="optMon" value="rps" class="selectgroup-input">
                                <span class="selectgroup-button">RPS</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row monev">

                    @foreach ($kri->sortBy('id') as $k)
                    @if($loop->iteration == 1)
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card card-statistic-2 mt-3">
                            <div class="card-stats mb-4">
                                <div class="card-stats-title"> <b>Rangkuman</b>
                                    <hr>
                                </div>
                                <div class="card-stats-items">

                                    <div class="card-stats-item">
                                        <div class="card-stats-item-count rangKri-1"></div>
                                        <div class="card-stats-item-label">Kriteria 1</div>
                                    </div>
                                    <div class="card-stats-item">
                                        <div class="card-stats-item-count rangKri-2"></div>
                                        <div class="card-stats-item-label">Kriteria 2</div>
                                    </div>
                                    <div class="card-stats-item">
                                        <div class="card-stats-item-count rangKri-3"></div>
                                        <div class="card-stats-item-label">Kriteria 3</div>
                                    </div>
                                    <div class="card-stats-item">
                                        <div class="card-stats-item-count rangFinal"></div>
                                        <div class="card-stats-item-label text-bold">Nilai Final</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="d-flex align-items-center my-0">
                            <h2 class="section-title titleClo">Kriteria {{ $loop->iteration }}</h2>
                        </div>
                        <div class="card">
                            <div class="card-body">

                                <table class="table table-bordered table-responsive" width="100%" id="kri-1">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center align-middle">
                                                Kriteria
                                            </th>
                                            <th rowspan="2" class="align-middle ">Keterangan</th>
                                            <th rowspan="2" class="align-middle border">Bobot</th>
                                            @foreach ($dtlAgd->unique('clo_id') as $cl)
                                            <th colspan="{{ $dtlAgd->where('clo_id', $cl->clo_id)->where('penilaian_id', '<>', null)->count() }}"
                                                class="border">
                                                {{ $cl->clo->kode_clo }}
                                            </th>
                                            @endforeach
                                            <th rowspan="2" class="align-middle border">Evaluasi</th>

                                        </tr>
                                        <tr>
                                            @foreach ($dtlAgd->unique('clo_id') as $cl)
                                            @foreach ($dtlAgd->where('clo_id', $cl->clo_id)->where('penilaian_id', '<>', null) as
                                            $pen)

                                            <th class="border">
                                                {{ $pen->penilaian->btk_penilaian}}
                                            </th>

                                            @endforeach
                                            @endforeach

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="min-width: 200px;" rowspan="2" class="">

                                                {{ $k->kri_penilaian }}
                                            </td>
                                            <td class="align-middle text-center border" >
                                                RPS
                                            </td>
                                            <td rowspan="2" class="text-center align-middle border bbt-kri-1">
                                                {{ $k->bobot }}
                                            </td>
                                            @foreach ($dtlAgd->unique('clo_id') as $cl)
                                            @foreach ($dtlAgd->where('clo_id', $cl->clo_id)->where('penilaian_id', '<>', null) as
                                                $pen)

                                                <td class="border">
                                                    {{ 'M'.$pen->agendaBelajar->pekan}}
                                                </td>

                                            @endforeach
                                            @endforeach
                                            <td class="align-middle border eval-kri-1" rowspan="2">
                                                tes
                                            </td>

                                        </tr>

                                        <tr class="eval">

                                            <td class="align-middle text-center border">Evaluasi CLO</td>

                                            @foreach ($dtlAgd->unique('clo_id') as $cl)
                                            @foreach ($dtlAgd->where('clo_id', $cl->clo_id)->where('penilaian_id', '<>', null) as
                                                $pen)

                                                <td class="border nilai-kri-1">
                                                    {{ $dtlInsMon->where('dtl_agd_id', $pen->id)->first()->nilai ?? '' }}
                                                </td>

                                            @endforeach
                                            @endforeach

                                        </tr>


                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                    @elseif ($loop->iteration == 2)
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="d-flex align-items-center my-0">
                            <h2 class="section-title titleClo">Kriteria {{ $loop->iteration }}</h2>

                            <button class="ml-2 btn btn-primary ml-auto" id="btnSaveKri2" disabled> <i class="fas fa-save"></i> Simpan Nilai </button>
                        </div>
                        <div class="card">
                            <div class="card-body">

                                <table class="table table-striped table-responsive" id="tableMonevKri2">
                                    <thead>
                                        <tr class="text-center">
                                            <th>
                                                Kriteria
                                            </th>
                                            <th>Bobot</th>
                                            @foreach ($agd->sortBy('pekan') as $a)
                                            @if (!($a->pekan == '8' || $a->pekan == '16'))

                                            <th>{{ 'M'.$a->pekan }}</th>
                                            @endif
                                            @endforeach
                                            <th>Persentase</th>
                                            <th>Nilai Kesesuaian</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td style="min-width: 150px;">

                                                {{ $k->kri_penilaian }}
                                            </td>
                                            <td class="bbt-kri-2">
                                                {{ $k->bobot }}
                                            </td>
                                            @foreach ($agd->sortBy('pekan') as $a)
                                            @if (!($a->pekan == '8' || $a->pekan == '16'))
                                            <td style="min-width: 50px;">
                                                <input type="hidden" id="agd" value="{{ $a->id }}">
                                                <input type="hidden" id="kri" value="{{ $k->id }}">
                                                <input type="number" class="form-control text-center nilai" min="0" max="4" value="{{ $a->detailInstrumenMonev->where('ins_monev_id', $cekInsMon->id)->where('id_kri', $k->id)->where('agd_id', $a->id)->first()->nilai ?? '' }}">
                                            </td>
                                            @endif
                                            @endforeach
                                            <td class="preSesuai">

                                            </td>
                                            <td class="nilaiSesuai">

                                            </td>
                                        </tr>


                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                    @elseif($loop->iteration == 3)
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="d-flex align-items-center my-0">
                            <h2 class="section-title titleClo">Kriteria {{ $loop->iteration }}</h2>
                        </div>
                        <div class="card">
                            <div class="card-body d-flex">

                                <table class="table table-bordered" id="tableMonevKri3">
                                    <thead>
                                        <tr class="text-center">

                                            <th>
                                                Kriteria
                                            </th>
                                            <th>Keterangan</th>
                                            <th>Bobot (%)</th>
                                            <th>Nilai</th>
                                            <th>Evaluasi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">

                                        <tr>

                                            <td style="min-width: 150px;" rowspan="4">

                                                {{ $k->kri_penilaian }}
                                            </td>
                                            <td>
                                                JML
                                            </td>
                                            <td rowspan="4" class="bbt-kri-3">
                                                {{ $k->bobot }}
                                            </td>

                                            <td class="jml">

                                            </td>
                                            <td rowspan="4" class="eval-clo">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                JMK
                                            </td>
                                            <td class="jmk">
                                                {{ $jmlMhs }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                JMP
                                            </td>
                                            <td class="jmp">
                                                {{ $jmlPre }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                ILC
                                            </td>
                                            <td class="ilc">

                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                                <div class="ml-3">
                                    <p>*JML = Jumlah Mahasiswa Yang Lulus Semua CLO</p>
                                    <p>*JMK = Jumlah Mahasiswa dalam 1 Kelas</p>
                                    <p>*JMP = Jumlah Mahasiswa Terkena Presensi</p>
                                    <p>*ILC = Indeks Lulus CLO</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    @endif
                    @endforeach


                </div>
                <div class="row d-none insNilai">
                    <input type="hidden" id="nilai_min_mk" value="{{ $cekInsNilai->nilai_min_mk }}">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header ">
                                <h4>Daftar Nilai Mahasiswa</h4>
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
                                            @foreach ($dtlAgd->unique('clo_id') as $cl)
                                            @foreach ($dtlAgd->where('clo_id', $cl->clo_id)->where('penilaian_id', '<>', null) as
                                            $pen)

                                            <th class="
                                            @if ($startFill <= $now)
                                                @if ($pen->agd_id == $getPekan->id)
                                                bg-info text-white
                                                @endif
                                            @endif
                                            ">
                                                {{ $pen->penilaian->btk_penilaian}}
                                            </th>
                                            @endforeach
                                            @endforeach
                                        </tr>
                                        <tr>
                                            @foreach ($dtlAgd->unique('clo_id') as $cl)
                                            @foreach ($dtlAgd->where('clo_id', $cl->clo_id)->where('penilaian_id', '<>', null) as
                                            $pen)

                                            <th class=" @if ($startFill <= $now)
                                            @if ($pen->agd_id == $getPekan->id)
                                            bg-info text-white
                                            @endif
                                        @endif">{{ $pen->penilaian->jenis}}</th>
                                            @endforeach
                                            @endforeach

                                        </tr>
                                        <tr>
                                            @foreach ($dtlAgd->unique('clo_id') as $cl)
                                            @foreach ($dtlAgd->where('clo_id', $cl->clo_id)->where('penilaian_id', '<>', null) as
                                            $pen)

                                            <th class="bbtPen  @if ($startFill <= $now)
                                                @if ($pen->agd_id == $getPekan->id)
                                                bg-info text-white
                                                @endif
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
                                            @foreach ($dtlAgd->unique('clo_id') as $cl)
                                            @foreach ($dtlAgd->where('clo_id', $cl->clo_id)->where('penilaian_id', '<>', null) as
                                            $pen)

                                            <td>
                                                <input type="hidden" id="idDtlAgd" value="{{ $pen->id }}">
                                                <input type="hidden" id="bobot" value="{{ $pen->bobot }}">
                                                <input type="hidden" id="nim" value="{{ $k->mhs_nim }}">
                                                <input type="number"
                                                    value="{{ $pen->detailInstrumenNilai->where('mhs_nim', $k->mhs_nim)
                                                    ->where('ins_nilai_id', $insNilai)->first()->nilai ?? '' }}"
                                                    max="100"
                                                    min="0"
                                                    class="form-control text-center nilai" data-cl="{{ $cl->clo_id }}"
                                                    data-jns ="{{ $pen->penilaian->jenis }}"
                                                    style="min-width:60px;" readonly>
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
                <div class="row d-none bap">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Berita Acara Perkuliahan</h4>
                            </div>
                            <div class="card-body">

                                <table class="table table-striped table-responsive" width="100%" id="bap">
                                    <thead>
                                        <tr>
                                            <th>Pertemuan</th>
                                            <th>Tujuan</th>
                                            <th>Pokok Bahasan</th>
                                            <th>Realisasi</th>
                                            <th>Catatan</th>
                                            <th>Tanggal Entry</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dtlBap->sortBy('kode_bap') as $db)
                                        <tr>
                                            <td>{{ $bapCol->where('kode_bap', $db->kode_bap)->first()->pertemuan ?? '' }}</td>
                                            <td> {{ $bapCol->where('kode_bap', $db->kode_bap)->first()->tujuan ?? '-' }}</td>
                                            <td>
                                                {{ $bapCol->where('kode_bap', $db->kode_bap)->first()->pokok_bahasan ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $db->realisasi }}
                                            </td>
                                            <td>
                                                {{ $db->catatan ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $db->convertDate($db->waktu_entry) }}
                                            </td>
                                        </tr>
                                        @endforeach


                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row d-none rps">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card ">
                            <div class="card-header">
                                <h4>Daftar Agenda Pembelajaran</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-responsive" id="tableRps" width="100%">
                                    <thead>
                                        <tr class="text-center">
                                            <th rowspan="2" class="align-middle">
                                                Minggu Ke
                                            </th>
                                            <th rowspan="2" class="align-middle">Kode CLO</th>
                                            <th rowspan="2" class="align-middle">
                                                <div style="min-width: 150px;">
                                                    Kode LLO
                                                </div>
                                            </th>
                                            <th rowspan="2" class="align-middle">
                                                <div style="min-width: 150px;">
                                                    Bentuk Penilaian
                                                </div>
                                            </th>
                                            <th rowspan="2" class="align-middle">
                                                <div style="min-width: 150px;">
                                                    Pengalaman Belajar
                                                </div>
                                            </th>
                                            <th rowspan="2" class="align-middle">
                                                <div style="min-width: 150px;">
                                                    Materi
                                                </div>
                                            </th>
                                            <th rowspan="2" class="align-middle">
                                                <div style="min-width: 150px;">
                                                    Metode
                                                </div>
                                            </th>
                                            <th colspan="4" class="align-middle">

                                                <div style="min-width: 150px;">
                                                    Kuliah (menit/mg)
                                                </div>
                                            </th>
                                            <th rowspan="2" class="align-middle">
                                                Responsi dan Tutorial
                                                (menit/mg)

                                            </th>
                                            <th  rowspan="2" class="align-middle">
                                                Belajar Mandiri
                                                (menit/mg)

                                            </th>
                                            <th  rowspan="2" class="align-middle">
                                                Praktikum
                                                (menit/mg)

                                            </th>
                                            <th  rowspan="2" class="align-middle" style="min-width: 80px;">Tanggal</th>

                                        </tr>
                                        <tr>

                                            <th>
                                                *TM

                                            </th>
                                            <th>
                                                <div>
                                                    *SL
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    *ASL
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    *ASM
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($agenda as $key => $i)
                                        <tr>
                                            <td class="text-center">
                                                {{ $i->agendaBelajar->pekan }}
                                                @if ($i->agendaBelajar->pekan == 8)
                                                (Ujian Tengah Semester)
                                                @elseif ($i->agendaBelajar->pekan == 16)
                                                (Ujian Akhir Semester)
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $i->clo->kode_clo}}
                                            </td>
                                            <td class="">
                                                @if ($i->llo_id)


                                                @if ($i->praktikum)

                                                {!! '<b>'.$i->llo->kode_llo.'</b>
                                                <br>'.$i->llo->deskripsi_prak.'<br> <b>Ketercapaian
                                                    '.$i->llo->kode_llo.'</b>
                                                <br>'.$i->capaian_llo !!}

                                                @else
                                                {!! '<b>'.$i->llo->kode_llo.'</b> <br>'.$i->llo->deskripsi.'<br>
                                                <b>Ketercapaian '.$i->llo->kode_llo.'</b> <br>'.$i->capaian_llo !!}
                                                @endif
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($i->penilaian_id)
                                                {!! '<b>'.$i->penilaian->btk_penilaian.' :
                                                    '.$i->bobot.'%</b><br>'.$i->deskripsi_penilaian !!}
                                                @else
                                                <b>-</b>
                                                @endif

                                            </td>
                                            <td>
                                                @foreach ($i->materiKuliahs as $mk)
                                                @if ($mk->status == "pbm")

                                                {!! '- '.$mk->deskripsi_pbm.'<br>' !!}
                                                @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                <b>Kajian : </b><br>
                                                @foreach ($i->materiKuliahs as $mk)
                                                @if ($mk->status == "kajian")

                                                {!! '- '.$mk->kajian.'<br>' !!}
                                                @endif
                                                @endforeach
                                                <br>

                                                <b>Materi : </b><br>
                                                @foreach ($i->materiKuliahs as $mk)
                                                @if ($mk->status == "materi")

                                                {!! '- '.$mk->materi.'<br>' !!}
                                                @endif
                                                @endforeach
                                                <br>

                                                <b>Pustaka : </b><br>
                                                @foreach ($i->materiKuliahs as $mk)
                                                @if ($mk->status == "pustaka")
                                                {!! '- '.$mk->jdl_ptk.', bab '.$mk->bab_ptk.', hal '.$mk->hal_ptk.'<br>'
                                                !!}
                                                @endif
                                                @endforeach
                                                <br>

                                                <b>Media Pembelajaran : </b><br>
                                                @foreach ($i->materiKuliahs as $mk)
                                                @if ($mk->status == "media")

                                                {!! '- '.$mk->media_bljr.'<br>' !!}
                                                @endif
                                                @endforeach
                                                <br>
                                            </td>
                                            <td>
                                                @foreach ($i->materiKuliahs as $mk)
                                                @if ($mk->status == "metode")

                                                {!! '- '.$mk->mtd_bljr.'<br>' !!}
                                                @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                {{ $i->tm }}
                                            </td>
                                            <td>
                                                {{ $i->sl }}
                                            </td>
                                            <td>
                                                {{ $i->asl }}
                                            </td>
                                            <td>
                                                {{ $i->asm }}
                                            </td>
                                            <td>
                                                {{ $i->res_tutor }}
                                            </td>
                                            <td>
                                                {{ $i->bljr_mandiri }}
                                            </td>
                                            <td>
                                                {{ $i->praktikum }}
                                            </td>
                                            <td>
                                                @if ($i->penilaian_id)

                                                {{ $i->agendaBelajar->getTglNilaiAttribute($i->agendaBelajar->tgl_nilai) }}
                                                @endif
                                            </td>
                                        </tr>

                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                            @if ($agenda->hasPages())
                            <div class="pagination-wrapper d-flex justify-content-end">
                                {{ $agenda->links() }}
                            </div>
                            @endif
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
@include('instrumen-monev.script')
@endpush
