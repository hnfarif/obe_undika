@extends('layouts.main')
@section('rps', 'active')
@section('penilaian', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">

            @include('rps.section-header')
            <div class="section-body">
                <div class="d-flex align-items-center my-0">
                    <h2 class="section-title">Penilaian</h2>

                </div>
                @if (session()->has('message'))
                <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" role="alert">
                    {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="row">
                    @if (!$rps->is_done)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Bentuk Penilaian</h4>

                            </div>
                            <div class="card-body">
                                <form action="{{ route('penilaian.store', $rps->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Bentuk Penilaian</label>
                                        <input type="text" name="btk_penilaian" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis Penilaian</label>
                                        <select name="jenis" class="form-control select2">
                                            <option value="TGS">TGS</option>
                                            <option value="QUI">QUI</option>
                                            <option value="PRK">PRK</option>
                                            <option value="PRS">PRS</option>
                                            <option value="RES">RES</option>
                                            <option value="PAP">PAP</option>
                                            <option value="LAI">LAI</option>
                                            <option value="UTS">UTS</option>
                                            <option value="UAS">UAS</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Tambah Bentuk Penilaian</button>
                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>
                    @endif
                    <div class="col-12 col-md-6 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Bentuk Penilaian</h4>
                            </div>
                            <div class="card-body">

                                <table class="table table-striped" id="table" width="100%">
                                    <thead class="text-center">
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>
                                                Bentuk Penilaian
                                            </th>
                                            <th>
                                                Jenis Penilaian
                                            </th>

                                            <th>
                                                Aksi
                                            </th>

                                        </tr>

                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($penilaian as $i)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $i->btk_penilaian }}
                                            </td>
                                            <td>
                                                {{ $i->jenis }}
                                            </td>
                                            <td>
                                                @if (!$rps->is_done)
                                                <div class="d-flex my-auto">

                                                    <a href="#" class="btn btn-light mr-2 editPenilaian"
                                                        data-id="{{ $i->id }}" data-toggle="modal"
                                                        data-target="#editPenilaian"><i class="fas fa-edit"></i>

                                                    </a>
                                                    <form action="{{ route('penilaian.delete', $i->id) }}"
                                                        method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <input type="hidden" name="rps_id" value="{{ $rps->id }}">
                                                        <button class="btn btn-danger delPenilaian"><i
                                                                class="fas fa-trash"></i>

                                                        </button>
                                                    </form>
                                                </div>
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


        </section>
    </div>
    @include('layouts.footer')
</div>

<div class="modal fade" role="dialog" id="editPenilaian">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Penilaian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('penilaian.update') }}" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="rps_id" value="{{ $rps->id }}">
                    <div class="form-group">
                        <label>Bentuk Penilaian</label>
                        <input type="text" name="btk_penilaian" class="form-control" id="btk_penilaian">
                    </div>
                    <div class="form-group">
                        <label>Jenis Penilaian</label>
                        <select name="jenis" id="jenis" class="form-control select2">
                            <option value="TGS">TGS</option>
                            <option value="QUI">QUI</option>
                            <option value="PRK">PRK</option>
                            <option value="PRS">PRS</option>
                            <option value="RES">RES</option>
                            <option value="PAP">PAP</option>
                            <option value="LAI">LAI</option>
                            <option value="UTS">UTS</option>
                            <option value="UAS">UAS</option>
                        </select>
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
        $('#table').DataTable({
            "ordering": true,
            "paging": true,
            "info": false,
            "searching": true,
            "showNEntries": false,
            "lengthChange": false,

        });
        $('#table').on('click', '.editPenilaian', function () {
            var id = $(this).attr('data-id');

            $.ajax({
                url: "{{ route('penilaian.edit') }}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    $("#id").val(data.id);
                    $("#btk_penilaian").val(data.btk_penilaian);
                    $('#jenis').children("option").each(function () {
                        if ($(this).val() == data.jenis) {
                            $(this).remove();
                            $('#jenis').prepend(
                                `<option selected value="${data.jenis}">${data.jenis}</option>`
                            );
                        }
                    });
                }
            })
        })

        $('#table').on('click', '.delPenilaian', function (e) {

            var form = $(this).closest('form');
            var name = $(this).data('name');
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Kamu tidak dapat mengembalikan data yang sudah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6777ef',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.value) {
                    form.submit();
                }

            })
        })
    })

</script>

@endpush
