@extends('layouts.main')
@section('rps', 'active')
@section('rangkuman', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">

            @include('rps.section-header')
            <div class="section-body">
                @if ($errors->any())

                @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $error }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endforeach

                @endif
                <div class="d-flex my-0">
                    <h2 class="section-title">Waktu Belajar Mahasiswa</h2>

                    <div class="mt-3 ml-auto">
                        @if ($rps->is_done)
                        <button type="button" disabled class="btn btn-success ml-3 align-self-center saveRps"><i
                                class="fas fa-check"></i> File RPS sudah diupload </button>
                        @else
                        <button type="button" class="btn btn-primary ml-3 align-self-center saveRps"><i
                                class="fas fa-file-upload"></i> Simpan RPS </button>
                        @endif
                    </div>

                </div>
                {{-- <p class="section-lead">Masukkan, ubah data PEO </p> --}}

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar WBM</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>

                                            <tr>

                                                <th>Bentuk Pembelajaran</th>
                                                <th>Total Jam/Semester</th>
                                                <th>Rata-rata Jam/Minggu</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><b>Kuliah</b></td>
                                                <td>
                                                    @foreach ($dataRps as $i)

                                                    {{ $i->matakuliah->sks.' sks * 50 menit * '.$i->agendabelajars->count().' pertemuan = '. ($i->matakuliah->sks*50*$i->agendabelajars->count()).' menit = '.round(($i->matakuliah->sks*50*$i->agendabelajars->count()/60),2). ' jam' }}

                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($dataRps as $i)

                                                    {{ (round(($i->matakuliah->sks*50*$i->agendabelajars->count() ?? 0/60),2). ' jam / '.$i->agendabelajars->count() ?? 0 ." pertemuan = ". round(($i->matakuliah->sks*50*$i->agendabelajars->count()?? 0 /60)/$i->agendabelajars->count() ?? 0,2). ' jam') }}

                                                    @endforeach

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="pl-3">
                                                        Tatap Muka (Luring)
                                                    </div>
                                                </td>
                                                <td>
                                                    @foreach ($kultot as $i)
                                                    @if ($i->tm)

                                                    {{ $i->tm.' menit = '.round(($i->tm/60),2).' jam' }}
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($kultot as $i)
                                                    @if ($i->tm)
                                                    @foreach ($dataRps as $dr)

                                                    {{ round(($i->tm/60), 2).' jam / '.$dr->agendabelajars->count().' pertemuan = '. round(($i->tm/60)/$dr->agendabelajars->count(), 2).' jam'  }}
                                                    @endforeach
                                                    @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="pl-3">
                                                        Synchronous Learning (Tatap Muka Daring)
                                                    </div>
                                                </td>
                                                <td>
                                                    @foreach ($kultot as $i)
                                                    @if ($i->sl)

                                                    {{ $i->sl.' menit = '.round(($i->sl/60),2).' jam' }}
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($kultot as $i)
                                                    @if ($i->sl)
                                                    @foreach ($dataRps as $dr)

                                                    {{ round(($i->sl/60), 2).' jam / '.$dr->agendabelajars->count().' pertemuan = '. round(($i->sl/60)/$dr->agendabelajars->count(), 2).' jam'  }}
                                                    @endforeach
                                                    @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="pl-3">
                                                        Asynchronous Learning
                                                    </div>
                                                </td>
                                                <td>
                                                    @foreach ($kultot as $i)
                                                    @if ($i->asl)

                                                    {{ $i->asl.' menit = '.round(($i->asl/60),2).' jam' }}
                                                    @endif

                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($kultot as $i)
                                                    @if ($i->asl)
                                                    @foreach ($dataRps as $dr)

                                                    {{ round(($i->asl/60), 2).' jam / '.$dr->agendabelajars->count().' pertemuan = '. round(($i->asl/60)/$dr->agendabelajars->count(), 2).' jam'  }}
                                                    @endforeach
                                                    @endif

                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="pl-3">
                                                        Assesment
                                                    </div>
                                                </td>
                                                <td>
                                                    @foreach ($kultot as $i)
                                                    @if ($i->asm)

                                                    {{ $i->asm.' menit = '.round(($i->asm/60),2).' jam' }}
                                                    @endif

                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($kultot as $i)
                                                    @if ($i->asm)
                                                    @foreach ($dataRps as $dr)

                                                    {{ round(($i->asm/60), 2).' jam / '.$dr->agendabelajars->count().' pertemuan = '. round(($i->asm/60)/$dr->agendabelajars->count(), 2).' jam'  }}
                                                    @endforeach
                                                    @endif

                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Responsi dan Tutorial</b>
                                                </td>
                                                <td>
                                                    @foreach ($dataRps as $i)
                                                    @if ($i->matakuliah->sks)

                                                    {{ $i->matakuliah->sks.' * 60 * '.$i->agendabelajars->count().' = '.round(($i->matakuliah->sks*60*$i->agendabelajars->count()),2).' menit = '. round(($i->matakuliah->sks*$i->agendabelajars->count()),2). ' jam' }}
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($dataRps as $i)
                                                    @if ($i->matakuliah->sks)

                                                    {{ round(($i->matakuliah->sks*$i->agendabelajars->count() ?? 0),2).' jam / '.$i->agendabelajars->count() ?? 0 .' pertemuan = '. round(($i->matakuliah->sks*$i->agendabelajars->count() ?? 0)/$i->agendabelajars->count() ?? 0,2).' jam'  }}
                                                    @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Belajar Mandiri</b>
                                                </td>
                                                <td>
                                                    @foreach ($dataRps as $i)
                                                    @if ($i->matakuliah->sks)

                                                    {{ $i->matakuliah->sks.' * 60 * '.$i->agendabelajars->count().' = '.round(($i->matakuliah->sks*60*$i->agendabelajars->count()),2).' menit = '. round(($i->matakuliah->sks*$i->agendabelajars->count()),2). ' jam' }}
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($dataRps as $i)
                                                    @if ($i->matakuliah->sks)

                                                    {{ round(($i->matakuliah->sks*$i->agendabelajars->count() ?? 0 ),2).' jam / '.$i->agendabelajars->count() ?? 0 .' pertemuan = '. round(($i->matakuliah->sks*$i->agendabelajars->count() ?? 0 )/$i->agendabelajars->count() ?? 0 ,2).' jam'  }}
                                                    @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Praktikum</b>
                                                </td>
                                                <td>
                                                    @foreach ($kultot as $i)
                                                    @if ($i->prak)

                                                    {{ $i->prak.' menit = '.round(($i->prak/60),2).' jam' }}
                                                    @endif

                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($kultot as $i)
                                                    @if ($i->prak)
                                                    @foreach ($dataRps as $dr)

                                                    {{ round(($i->prak/60), 2).' jam / '.$dr->agendabelajars->count().' pertemuan = '. round(($i->prak/60)/$dr->agendabelajars->count(), 2).' jam'  }}
                                                    @endforeach
                                                    @endif

                                                    @endforeach
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="d-flex my-0">
                    <h2 class="section-title">Penilaian</h2>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Tabel Penilaian</h4>
                            </div>
                            <div class="card-body">

                                <table class="table table-striped table-bordered table-responsive">
                                    <thead>

                                        <tr class="text-center">
                                            <th rowspan="2">ID CLO</th>
                                            <th colspan="@foreach ($dataRps as $i)
                                        {{ $i->penilaians->count() }}
                                        @endforeach">Bobot per bentuk penilaian (%)</th>
                                            <th rowspan="2">Total Bobot per CLO (%)</th>
                                            <th rowspan="2">Target Kelulusan (% Mhs) </th>

                                        </tr>

                                        <tr class="text-center">
                                            @foreach ($dataRps as $i)
                                            @foreach ($i->penilaians as $p)
                                            <th>{{ $p->btk_penilaian }}</th>
                                            @endforeach
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($dataRps as $i)
                                        @foreach ($i->clos as $c)
                                        <tr class="text-center">
                                            <td>
                                                {{ $c->kode_clo }}
                                            </td>
                                            @foreach ($i->penilaians as $p)
                                            <td>
                                                {{ $c->detailAgendas->where('penilaian_id', $p->id)->sum('bobot') }}
                                            </td>
                                            @endforeach
                                            <td>
                                                {{ $c->getBobotClo($c->id,$i->penilaians) }}
                                            </td>
                                            <td>
                                                {{ $c->tgt_lulus.' % (nilai minimal '.$c->nilai_min.')' }}
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endforeach
                                    </tbody>
                                    <tfoot class="text-center">
                                        <th>Total per Penilaian</th>
                                        @foreach ($dataRps as $i)
                                        @foreach ($i->penilaians as $p)
                                        <th>{{ $p->getBobotPen($p->id, $i->clos) }}</th>
                                        @endforeach
                                        @endforeach
                                        @foreach ($dataRps as $i)
                                        <th>{{ $i->getAllTotal($i->penilaians, $i->clos) }}</th>
                                        @endforeach
                                    </tfoot>

                                </table>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="d-flex my-0">
                    <h2 class="section-title">Pustaka</h2>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <ol>
                            @foreach ($pus as $i)
                            <li>{{ $i->jdl_ptk.', bab '.$i->bab_ptk.', hal '.$i->hal_ptk }}</li>
                            @endforeach

                        </ol>
                    </div>
                </div>

                <div class="d-flex my-0">
                    <h2 class="section-title">Media Pembelajaran</h2>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <ol>
                            @foreach ($med as $m)
                            <li>{{ $m->media_bljr }}</li>
                            @endforeach

                        </ol>
                    </div>
                </div>

                <div class="d-flex my-0">
                    <h2 class="section-title">Pengalaman Belajar Mahasiswa</h2>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <ol>
                            @foreach ($pbm as $pbms)
                            <li>{{ $pbms->deskripsi_pbm }}</li>
                            @endforeach

                        </ol>
                    </div>
                </div>

            </div>
        </section>
    </div>
    @include('layouts.footer')
</div>
<div class="modal fade" role="dialog" id="saveRps">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Simpan RPS
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('rps.file.store', $rps->id) }}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Masukkan File RPS </label>
                        <div class="custom-file">
                            <input class="form-control @error('rps') is-invalid
                            @enderror" type="file" name="rps" id="formFile" required>

                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btnSaveRps" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    $(document).ready(function () {
        $('.saveRps').on('click', function () {
            Swal.fire({
                title: 'Apakah anda yakin ingin menyimpan RPS ini?',
                text: "jika anda menyimpan RPS ini, maka tidak bisa diubah lagi",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!'
            }).then((result) => {
                if (result.value) {
                    $('#saveRps').modal('show');
                }
            })
        })

    })

</script>
@endpush
