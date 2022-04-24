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

                <div class="row">
                    <div class="col-12 col-md-8 col-lg-12">
                        <div class="my-3">
                            <a href="{{ route('rps.plottingmk') }}" type="button" class="btn btn-primary"><i
                                    class="fas fa-plus"></i> Entri
                                Plotting
                                Mata Kuliah</a>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar RPS</h4>
                                <div class="btn-group ml-auto">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                        aria-expanded="false">
                                        <i></i>
                                        Filter
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                                        <div class="dropdown-title">Semester</div>
                                        <div class="form-group form-check-inline">
                                            <div class="form-check">
                                                <div class="checkbox-wrapper">
                                                    @foreach ($rps->unique('semester') as $i)

                                                    <input type="checkbox" class="form-check-input dataSmt"
                                                        id="smt-{{ $loop->iteration }}"
                                                        value="{{ $i->semester }}">{{ $i->semester }}
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown-title">Aktif</div>
                                        <div class="form-group form-check-inline">
                                            <div class="form-check">
                                                <div class="checkbox-wrapper">
                                                    <input type="checkbox" class="form-check-input" value="1">Ya
                                                    <input type="checkbox" class="form-check-input" value="0">Tidak
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-striped table-responsive" id="table">

                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                #
                                            </th>
                                            <th>Kode MK</th>
                                            <th>
                                                Mata Kuliah
                                            </th>
                                            <th>Rumpun MK</th>
                                            <th>
                                                <div style="min-width: 150px;">Ketua Rumpun</div>
                                            </th>
                                            <th>Penyusun</th>
                                            <th>Semester</th>
                                            <th>SKS</th>
                                            <th>Aktif</th>
                                            <th>Status</th>
                                            <th>
                                                <div style="min-width: 165px;">
                                                    Action
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rps as $i)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>{{ substr($i->kurlkl_id,4) }}</td>
                                            <td>{{ $i->nama_mk }}</td>
                                            <td>{{ $i->rumpun_mk }}</td>
                                            <td>{{ $i->karyawan->nama }}</td>
                                            <td>
                                                @if ($i->penyusun)
                                                {{ $i->penyusun }}
                                                @else
                                                <button class="btn btn-primary" data-toggle="modal"
                                                    data-target="#modalPenyusun"><i class="fas fa-plus"></i></button>
                                                @endif

                                            </td>
                                            <td>
                                                {{ $i->semester }}
                                            </td>
                                            <td>
                                                {{ $i->matakuliah->sks }}
                                            </td>
                                            <td>
                                                @if ($i->is_active)
                                                {{ 'Ya' }}
                                                @else
                                                {{ 'Tidak' }}
                                                @endif

                                            </td>
                                            <td>
                                                @if ($i->is_done)
                                                <div class="badge badge-success">Done</div>
                                                @else
                                                <div class="badge badge-warning">To do</div>
                                                @endif

                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    @if ($i->is_done)
                                                    <a href="{{ asset('storage/'.$i->file_rps) }}" target="_blank"
                                                        class="btn btn-primary mr-2 flex-grow">Lihat
                                                        File Rps</a>
                                                    @else
                                                    <a href="{{ route('clo.index', $i->id) }}"
                                                        class="btn btn-light mr-2 flex-grow">Buat
                                                        Rps</a>
                                                    @endif

                                                    <button class="btn btn-info editRps flex-grow" data-toggle="modal"
                                                        data-target="#editRps" data-id="{{ $i->id }}">Ubah</button>
                                                </div>
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
    </div>
    @include('layouts.footer')
</div>
{{-- modal set email --}}
<div class="modal fade" role="dialog" id="modalPenyusun">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Dosen Penyusun</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Dosen</label>
                    <select class="form-control select2">
                        <option>Dosen 1</option>
                        <option>Dosen 2</option>
                        <option>Dosen 3</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
{{-- modal edit data RPS --}}
<div class="modal fade" role="dialog" id="editRps">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titleRps">Ubah data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('rps.update') }}" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="rps_id" id="rps">
                    <div class="form-group">
                        <label>Nama Rumpun Mata Kuliah</label>
                        <input type="text" id="rumpun_mk" name="rumpun_mk"
                            class="form-control @error('rumpun_mk') is-invalid @enderror"
                            placeholder="cth : PENGELOLAAN DATA DAN INFORMASI" required>
                        @error('rumpun_mk')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Ketua Rumpun</label>
                        <select id="ketua_rumpun"
                            class="form-control select2 @error('ketua_rumpun') is-invalid @enderror" name="ketua_rumpun"
                            required>

                            @foreach ($dosens as $i)
                            <option value="{{ $i->nik }}">{{ $i->nama }}
                            </option>

                            @endforeach
                        </select>
                        @error('ketua_rumpun')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Semester Pembuatan</label>
                        <input type="text" id="semester" name="semester"
                            class="form-control @error('semester') is-invalid @enderror"
                            placeholder="cth : 201, 202, 211" required>
                        @error('semester')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Status Aktif</label>
                        <select class="form-control select2 @error('ketua_rumpun') is-invalid @enderror"
                            name="sts_aktif" id="sts_aktif">
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                        @error('sts_aktif')
                        <div class="alert alert-danger alert-dismissible show fade ">{{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @enderror
                    </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

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



        // $('.smt:checked').each(function () {
        // });
        // if (!$(this).checked) {

        // } else {
        //     chkSmt.push($(this).val());
        //     localStorage.setItem('checkedSmt', JSON.stringify(chkSmt));
        // }
        // $(this).change(function () {
        // if ($(this).attr('checked', 'checked')) {
        // } else {
        //
        // }
        // })
    });

</script>

@endpush
