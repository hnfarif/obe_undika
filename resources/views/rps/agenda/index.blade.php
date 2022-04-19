@extends('layouts.main')
@section('rps', 'active')
@section('agenda', 'active')
@section('content')
<section class="section">
    @include('rps.section-header')

    <div class="section-body">
        {{-- <p class="section-lead">Masukkan data CLO </p> --}}
        @if (session()->has('message'))
        <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" role="alert">
            {{ session()->get('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="row">
            <div class="col-12 col-md-6 col-lg-12 p-0 mb-2 d-flex">
                <a href="{{ route('agenda.create', $rps->id) }}" type="button"
                    class="btn btn-primary ml-3  align-self-center expanded"><i class="fas fa-plus"></i> Entri Agenda
                    Pembelajaran</a>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 col-lg-12 p-0 d-flex">

                <div class="align-items-center pl-3">
                    <h2 class="section-title">Tabel Agenda Pembelajaran</h2>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card ">
                    <div class="card-header">
                        <h4>Daftar Agenda Pembelajaran</h4>
                    </div>
                    <div class="card-body">
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
                                    <th rowspan="2" class="align-middle">Aksi</th>
                                </tr>
                                <tr>
                                    <th>TM</th>
                                    <th>SL</th>
                                    <th>
                                        <div style="min-width: 50px;">
                                            ASL
                                        </div>
                                    </th>
                                    <th>
                                        <div style="min-width: 50px;">
                                            ASM
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($agenda as $key => $i)
                                <tr>
                                    <td class="text-center">
                                        {{ $i->agendaBelajar->pekan }}
                                    </td>
                                    <td class="text-center">
                                        {{ $i->clo->kode_clo}}
                                    </td>
                                    <td class="">
                                        @if ($i->praktikum)

                                        {!! '<b>'.$i->llo->kode_llo.'</b>
                                        <br>'.$i->llo->deskripsi_prak.'<br> <b>Ketercapaian '.$i->llo->kode_llo.'</b>
                                        <br>'.$i->capaian_llo !!}

                                        @else
                                        {!! '<b>'.$i->llo->kode_llo.'</b> <br>'.$i->llo->deskripsi.'<br>
                                        <b>Ketercapaian '.$i->llo->kode_llo.'</b> <br>'.$i->capaian_llo !!}
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
                                        {!! '- '.$mk->jdl_ptk.', bab '.$mk->bab_ptk.', hal '.$mk->hal_ptk.'<br>' !!}
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
                                    <td class="d-flex">

                                        <a href="#" id="btnEditAgd" data-toggle="modal" data-target="#editAgenda"
                                            data-id="{{ $i->id }}" class="btn btn-light mr-1 my-auto"><i
                                                class="fas fa-edit"></i>

                                        </a>
                                        <a href="#" class="btn btn-danger my-auto"><i class="fas fa-trash"></i>

                                        </a>
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
</section>

@include('rps.agenda.modalagdedit')
@endsection
@push('script')
<script>
    $('#tableAgd').DataTable({
        scrollY: 500,
        scrollX: true,
        scroller: true,
    });

    if ($('input[type=radio][name=praktikum]:checked').val() == '0') {
        $.ajax({
            url: "{{ route('kuliah.getSks') }}",
            type: 'GET',
            data: {
                'rps_id': "{{ $rps->id }}",
            },
            success: function (data) {
                $('#responsi').val(data.mata_kuliah.sks * 60);
                $('#belajarMandiri').val(data.mata_kuliah.sks * 60);
            }

        })
    }

    $('input[type=radio][name=praktikum]').change(function () {
        if (this.value == '1') {

            $.ajax({
                url: "{{ route('kuliah.getSks') }}",
                type: 'GET',
                data: {
                    'rps_id': "{{ $rps->id }}",
                },
                success: function (data) {

                    $('#responsi').val('');
                    $('#belajarMandiri').val('');
                    $('#prak').val(data.mata_kuliah.sks * 60);
                }

            })
        } else if (this.value == '0') {
            $.ajax({
                url: "{{ route('kuliah.getSks') }}",
                type: 'GET',
                data: {
                    'rps_id': "{{ $rps->id }}",
                },
                success: function (data) {
                    $('#responsi').val(data.mata_kuliah.sks * 60);
                    $('#belajarMandiri').val(data.mata_kuliah.sks * 60);
                    $('#responsi').attr('readonly', 'readonly');
                    $('#belajarMandiri').attr('readonly', 'readonly');
                    $('#prak').attr('readonly', 'readonly');
                    $('#prak').val('');
                }

            })
        }
    });

    $(document).ready(function () {
        var llo = [];
        $('.sn-capai').summernote({
            toolbar: [],

        });

        $('.sn-pen').summernote({
            toolbar: [],

        });

        $('#tableAgd').on('click', '#btnEditAgd', function () {
            var id = $(this).data('id');

            $.ajax({
                url: "{{ route('agenda.edit') }}",
                type: "GET",
                data: {
                    id: id,
                    rps_id: "{{ $rps->id }}"
                },
                success: function (data) {
                    // console.log(data);
                    $('#idDtl').val(data.id)
                    $('#ttlAgd').html('Edit Agenda Belajar Minggu Ke ' + data.agenda_belajar
                        .pekan + ' ' + data.clo.kode_clo)
                    $('#clo_id').children("option").each(function () {
                        if ($(this).val() == data.clo_id) {
                            $(this).remove();
                            $('#clo_id').prepend(
                                `<option selected value="${data.clo_id}">${data.clo.kode_clo} - ${data.clo.deskripsi} </option>`
                            );
                        }
                    });
                    $('#kode_llo').val(data.llo.kode_llo)
                    if (data.praktikum) {

                        $('#des_llo').val(data.llo.deskripsi_prak)
                    } else {
                        $('#des_llo').val(data.llo.deskripsi)
                    }
                    $('.sn-capai').summernote('code', data.capaian_llo);
                    $('#btk_penilaian').children("option").each(function () {
                        if ($(this).val() == data.penilaian.id) {
                            $(this).remove();
                            $('#btk_penilaian').prepend(
                                `<option selected value="${data.penilaian.id}">${data.penilaian.btk_penilaian} </option>`
                            );
                        }
                    });
                    $('#bbt_penilaian').val(data.bobot)
                    $('.sn-pen').summernote('code', data.deskripsi_penilaian);
                    $('#tm').val(data.tm)
                    $('#sl').val(data.sl)
                    $('#asl').val(data.asl)
                    $('#asm').val(data.asm)
                }

            })

        })

        $('#ubahAgd').click(function () {

            $.ajax({
                url: "{{ route('agenda.update') }}",
                type: "PUT",
                dataType: "JSON",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'rps_id': "{{ $rps->id }}",
                    'idDtl': $('#idDtl').val(),
                    'clo_id': $('#clo_id').val(),
                    'kode_llo': $('#kode_llo').val().toUpperCase(),
                    'des_llo': $('#des_llo').val(),
                    'capai_llo': $('#capai_llo').val(),
                    'btk_penilaian': $('#btk_penilaian').val(),
                    'bbt_penilaian': $('#bbt_penilaian').val(),
                    'des_penilaian': $('#des_penilaian').val(),
                    'tm': $('#tm').val(),
                    'sl': $('#sl').val(),
                    'asl': $('#asl').val(),
                    'asm': $('#asm').val(),
                    'responsi': $('#responsi').val(),
                    'belajarMandiri': $('#belajarMandiri').val(),
                    'prak': $('#prak').val(),
                },
                success: function (data) {
                    if ($.isEmptyObject(data.error) && $.isEmptyObject(data.errBbt) &&
                        $.isEmptyObject(data.errMnt)) {
                        $('#formAgenda').modal('hide');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Data Anda berhasil diubah!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(() => {
                            location.reload();
                        }, 1500);

                    } else {
                        if (data.error) {

                            data.error.forEach(element => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops, Terdapat Data yang kosong!',
                                    text: element,
                                })
                            });
                        } else if (data.errBbt) {

                            Array.from(data.errBbt).forEach(element => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops, ada kesalahan!',
                                    text: 'Maaf data yang anda masukkan dijumlahkan melebihi 100%, Harap perbaiki data anda',
                                })
                            });
                        } else if (data.errMnt) {
                            Array.from(data.errMnt).forEach(element => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops, ada kesalahan!',
                                    text: 'Maaf total menit perkuliahan yang anda masukkan melebihi ' +
                                        $('#responsi').val() +
                                        ' menit, Harap perbaiki data anda',
                                })
                            });
                        }

                    }

                }
            })

        })
    });

</script>
@endpush
