@extends('layouts.main')
@section('rps', 'active')
@section('step1', 'active')
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
                <div class="my-3 d-flex">
                    <a href="{{ route('rps.plottingrps') }}" type="button" class="btn btn-primary"><i
                            class="fas fa-plus"></i> Entri Plotting RPS</a>
                    <button class="btn btn-light ml-auto" data-toggle="modal" data-target="#filRps">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <form class="card-header-form ml-3" action="{{ route('rps.index') }}">
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
                    @foreach ($rps as $r)

                    <div class="col-12 col-md-12 col-lg-4">
                        <div class="card @if($r->is_done == 1) card-success @else card-warning
                        @endif">
                            <div class="card-header" style="height: 100px;">
                                <div class="d-block">
                                    <h4 class="text-dark">{{ $r->nama_mk }} ({{ substr($r->kurlkl_id,4) }})</h4>
                                    <p class="m-0">{{ $r->matakuliah->prodi->nama }}</p>
                                </div>
                                <div class="card-header-action ml-auto">
                                    <a data-collapse="#{{ substr($r->kurlkl_id,4) }}" class="btn btn-icon btn-info"
                                        href="#"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="collapse" id="{{ substr($r->kurlkl_id,4) }}">
                                <div class="card-body">
                                    <b>Rumpun Mata Kuliah</b>
                                    <p>{{ $r->rumpun_mk }}</p>
                                    <b>Fakultas</b>
                                    <p class="">{{ $r->matakuliah->prodi->fakultas->nama }}</p>
                                    <div class="row">
                                        <div class="col-12">
                                            <div>
                                                <b>Ketua Rumpun</b>
                                                <p class="">{{ $r->karyawan->nama }}</p>
                                            </div>
                                            <div>
                                                <b>Penyusun</b>
                                                <div>
                                                    @if ($r->penyusun)
                                                    {{ $r->penyusun }}
                                                    @else
                                                    <button class="btn btn-primary" data-toggle="modal"
                                                        data-target="#modalPenyusun"><i
                                                            class="fas fa-plus"></i></button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-between">
                                            <div>
                                                <b>Semester</b>
                                                <p>{{ $r->semester }}</p>
                                            </div>
                                            <div>
                                                <b>SKS</b>
                                                <p>{{ $r->sks }}</p>
                                            </div>
                                            <div>
                                                <b>Status</b>
                                                <div>
                                                    @if ($r->is_done)
                                                    <div class="badge badge-success">Done</div>
                                                    @else
                                                    <div class="badge badge-warning">To do</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                @if ($r->file_rps)
                                <a href="{{ asset('storage/'.$r->file_rps) }}" target="_blank"
                                    class="btn btn-primary mr-1 "> <i class="fas fa-file-pdf"></i> Lihat PDF</a>
                                @else
                                <button type="button" class="btn btn-warning mr-1 saveRps" data-id="{{ $r->id }}"><i
                                        class="fas fa-file-upload"></i> Upload
                                    RPS </button>
                                @endif
                                <a href="{{ route('clo.index', $r->id) }}" class="btn btn-light mr-1 ">Edit Rps</a>
                                <button class="btn btn-info editRps" data-toggle="modal" data-target="#editRps"
                                    data-id="{{ $r->id }}"><i class="fas fa-edit"></i></button>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
                @if ($rps->hasPages())
                <div class="pagination-wrapper d-flex justify-content-end">
                    {{ $rps->links() }}
                </div>

                @endif
            </div>


        </section>
    </div>
    @include('layouts.footer')
</div>


@include('rps.modal')
@endsection
@push('script')

<script>
    $(document).ready(function () {
        $('#table').DataTable();
        $('#table').on('click', '.editRps', function () {
            var id = $(this).attr('data-id');

            $.ajax({
                url: "{{ route('rps.edit') }}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    console.log(data);
                    $(".titleRps").html("Ubah Data RPS " + data.nama_mk);
                    $("#rps").val(data.id);
                    $("#rumpun_mk").val(data.rumpun_mk);
                    $('#ketua_rumpun').children("option").each(function () {
                        if ($(this).val() == data.nik) {
                            $(this).remove();
                            $('#ketua_rumpun').prepend(
                                `<option selected value="${data.nik}">${data.karyawan.nama}</option>`
                            );
                        }
                    });
                    $("#semester").val(data.semester);
                    $('#sts_aktif').children("option").each(function () {
                        if ($(this).val() == data.is_active) {
                            $(this).remove();
                            if (data.is_active == 1) {
                                $('#sts_aktif').prepend(
                                    `<option selected value="${data.is_active}">Ya</option>`
                                );
                            } else {
                                $('#sts_aktif').prepend(
                                    `<option selected value="${data.is_active}">Tidak</option>`
                                );
                            }
                        }
                    });
                    // $("#deskripsi").val(data.deskripsi);
                }
            })
        })

        var chkSmt = [];
        var dataSmt = [];


        $('.dataSmt').each(function () {
            dataSmt.push($(this).val());

        })

        $('.saveRps').on('click', function () {
            var id = $(this).attr('data-id');
            Swal.fire({
                title: 'Perhatian',
                text: "Pastikan file yang akan diupload sudah benar, file tidak dapat diubah lagi",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!'
            }).then((result) => {
                if (result.value) {
                    $('#saveRps').modal('show');
                    $('#mrps_id').val(id);
                }
            })
        })
    });

</script>

@endpush
