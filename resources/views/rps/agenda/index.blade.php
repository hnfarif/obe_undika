@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/introjs/introjs.css') }}">
@endpush
@section('rps', 'active')
@section('agenda', 'active')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker/daterangepicker.css') }}">
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">
            @include('rps.section-header')

            <div class="section-body">
                @include('rps.breadcrumb')
                @if (session()->has('message'))
                <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" role="alert">
                    {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="row ">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card ">
                            <div class="card-header">
                                <h4>Daftar Agenda Pembelajaran</h4>
                                @if (auth()->user()->nik == $rps->penyusun && $rps->is_done == '0')
                                <a href="{{ route('agenda.create', $rps->id) }}" type="button"
                                    class="btn btn-primary ml-auto align-self-center expanded intro-form-ap"><i
                                        class="fas fa-plus"></i> Entri
                                    Agenda
                                    Pembelajaran</a>
                                @endif
                            </div>
                            <div class="card-body intro-table-ap">
                                <div class="table-responsive">

                                    <table class="table table-striped" id="tableAgd">
                                        <thead>
                                            <tr class="text-center">
                                                <th rowspan="2" class="align-middle">Minggu Ke</th>
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
                                                <th rowspan="2" class="align-middle">
                                                    Belajar Mandiri
                                                    (menit/mg)

                                                </th>
                                                <th rowspan="2" class="align-middle">
                                                    Praktikum
                                                    (menit/mg)

                                                </th>
                                                <th rowspan="2" class="align-middle" style="min-width: 80px;">Tanggal
                                                </th>
                                                <th rowspan="2" class="align-middle">Aksi</th>
                                            </tr>
                                            <tr>
                                                <th>*TM</th>
                                                <th>*SL</th>
                                                <th>
                                                    <div style="min-width: 50px;">
                                                        *ASL
                                                    </div>
                                                </th>
                                                <th>
                                                    <div style="min-width: 50px;">
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
                                                    {!! '- '.$mk->jdl_ptk.', bab '.$mk->bab_ptk.', hal
                                                    '.$mk->hal_ptk.'<br>'
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
                                                <td class="d-flex">
                                                    @if (auth()->user()->nik == $rps->penyusun && $rps->is_done == '0')
                                                    <button id="btnEditAgd" data-toggle="modal"
                                                        data-target="#editAgenda" data-id="{{ $i->id }}"
                                                        class="btn btn-light mr-1 my-auto btnEditAgd"><i
                                                            class="fas fa-edit"></i>

                                                    </button>

                                                    <form
                                                        action="{{ route('agenda.delete', ['id' => $i->id, 'rps' => $rps->id]) }}"
                                                        method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="submit"
                                                            class="btn btn-danger my-auto delDtlAgd"><i
                                                                class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endif
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
            <div>
                <ul style="list-style-type:none">
                    <li><b>*TM</b> = Tatap Muka</li>
                    <li><b>*SL</b> = Synchronous Learning</li>
                    <li><b>*ASL</b> = Asynchronous Learning</li>
                    <li><b>*ASM</b> = Assessment</li>
                </ul>
            </div>
        </section>
    </div>
    @include('layouts.footer')
</div>
@include('rps.agenda.modalagdedit')
@endsection
@push('script')
<script src="//cdn.datatables.net/plug-ins/1.12.0/sorting/natural.js"></script>
@include('rps.agenda.script-index')
@endpush
