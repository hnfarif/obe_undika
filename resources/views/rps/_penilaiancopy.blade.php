@extends('layouts.main')
@section('rps', 'active')
@section('penilaian', 'active')
@section('content')
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

</style>
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
                    <div class="col-12 col-md-6 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Bentuk Penilaian</h4>
                                <div class="ml-auto">
                                    <button type="button" class="btn btn-primary ubahNilai"><i class="fas fa-edit"></i>
                                        Edit data penilaian</button>
                                    <button type="button" class="btn btn-danger d-none batalNilai"><i
                                            class="fas fa-times"></i>
                                        Batal</button>
                                    <button type="button" class="btn btn-primary d-none" id="swalSave"><i
                                            class="fas fa-check"></i>
                                        Ubah data penilaian</button>
                                </div>

                            </div>
                            <div class="card-body">

                                <table class="table table-striped table-responsive" width="100%" id="tablePen">
                                    <thead>
                                        <tr>
                                            <th rowspan="4" class="align-middle text-center">#</th>
                                            <th rowspan="4" class="align-middle text-center">
                                                <div style="min-width: 200px;">
                                                    Kode CLO
                                                </div>
                                            </th>
                                            <th colspan="{{ $penilaian->count() }}">
                                                Bobot per bentuk penilaian (%)
                                            </th>
                                            <th rowspan="4" class="align-middle">
                                                <div style="min-width:100px;">Total Bobot per CLO (%)</div>
                                            </th>
                                            <th rowspan="4" class="align-middle">Target Kelulusan(%)</th>
                                            <th rowspan="4" class="align-middle">
                                                <div style="width: 65px;">Nilai Min</div>
                                            </th>
                                        </tr>
                                        <tr class="d-none" id="btnDitDel">
                                            @foreach ($penilaian as $p)

                                            <th>
                                                <div class="d-flex">

                                                    <button type="button" class="btn btn-light mr-1 editPenilaian"
                                                        data-id="{{ $p->id }}" data-toggle="modal"
                                                        data-target="#editPenilaian">
                                                        <i class="fas fa-edit my-auto"></i>
                                                    </button>
                                                    <form action="{{ route('penilaian.delete', $p->id) }}"
                                                        method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <input type="hidden" name="rps_id" value="{{ $rps->id }}">
                                                        <button type="button" class="btn btn-danger delPenilaian">
                                                            <i class="fas fa-trash my-auto"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </th>
                                            @endforeach

                                        </tr>
                                        <tr>
                                            @foreach ($penilaian as $p)
                                            <th>

                                                {{ $p->btk_penilaian }}
                                            </th>
                                            @endforeach

                                        </tr>
                                        <tr>
                                            @foreach ($penilaian as $j)
                                            <th>
                                                <input type="hidden" class="idBtk" value="{{ $j->id }}">
                                                <div style="min-width: 65px;">{{ $j->jenis }}</div>
                                            </th>
                                            @endforeach
                                        </tr>

                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($clo as $i)

                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <input type="hidden" id="idClo" value="{{ $i->id }}">

                                                {{ $i->kode_clo }}
                                            </td>

                                            @foreach ($i->penilaians->sortBy('id') as $p)
                                            <td><input type="number" min="0" max="100"
                                                    value="{{ $p->getBobot($p->id,$i->id) }}"
                                                    class="form-control text-center bobot" readonly>
                                            </td>
                                            @endforeach
                                            @if ($i->penilaians->count() > 0)
                                            <td class="align-middle"><strong
                                                    id="ttlClo{{ $loop->iteration }}">{{ $i->getTotalClo($i->id) }}</strong>
                                            </td>
                                            <td><input type="number" min="0" max="100"
                                                    value="{{ $i->getLulusNilai($i->id)['lulus'] }}"
                                                    class="form-control text-center clo" readonly></td>
                                            <td><input type="number" min="0" max="100"
                                                    value="{{ $i->getLulusNilai($i->id)['nilai'] }}"
                                                    class="form-control text-center clo" readonly></td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="text-center">
                                        <tr>
                                            <td colspan="2"> <strong>Total per penilaian (%)</strong> </td>
                                            @foreach ($penilaian as $i)
                                            <td><strong
                                                    id="ttlperBobot{{ $loop->iteration }}">{{ $i->getTotalPenilaian($i->id) }}</strong>
                                            </td>
                                            @endforeach

                                            <td><strong id="ttlperClo">{{ $total }}</strong></td>

                                        </tr>
                                    </tfoot>
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
        var data = Array();
        var clo = Array();
        var btkNilai = Array();

        $('#tablePen').DataTable({
            "paging": false,
            "searching": false,
            "showNEntries": false,
            "info": false,
        });

        $('.ubahNilai').click(function () {

            $('.bobot').removeAttr('readonly');
            $('.clo').removeAttr('readonly');
            $('.ubahNilai').addClass('d-none');
            $('.batalNilai').removeClass('d-none');
            $('#btnDitDel').removeClass('d-none');
            $('#swalSave').removeClass('d-none');

        });

        $('.batalNilai').click(function () {
            location.reload();

        })

        $('#table').on('click', '.editPenilaian', function () {

            $.ajax({
                url: "{{ route('penilaian.edit') }}",
                type: "GET",
                data: {
                    id: $(this).data('id')
                },
                success: function (data) {
                    $('#id').val(data.id);
                    $('#btk_penilaian').val(data.btk_penilaian);
                    $('#jenis').children("option").each(function () {
                        if ($(this).val() == data.jenis) {
                            $(this).remove();
                            $('#jenis').prepend(
                                `<option selected value="${data.jenis}">${data.jenis}</option>`
                            );
                        }
                    });


                }
            });
        });

        $('#tablePen').on('click', '.delPenilaian', function (e) {

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

        $('#swalSave').click(function () {
            var ttlperClo = $('#ttlperClo').text();
            if (ttlperClo != 100) {
                Swal.fire('Total bobot per CLO harus sama dengan 100%', '',
                    'error');
            } else {
                Swal.fire({
                    title: 'Do you want to save the changes?',
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    denyButtonText: `Don't save`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $('.ubahNilai').addClass('d-none');
                        $('.batalNilai').addClass('d-none');
                        $('#btnDitDel').addClass('d-none');
                        $('#swalSave').addClass('d-none');

                        $.ajax({
                            url: "{{ route('penilaian.updateBobot') }}",
                            type: "PUT",
                            data: {
                                '_token': "{{ csrf_token() }}",
                                'btkNilai': btkNilai,
                                'bobot': data,
                                'clo': clo,
                            },
                            success: function (data) {


                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener(
                                            'mouseenter', Swal
                                            .stopTimer)
                                        toast.addEventListener(
                                            'mouseleave', Swal
                                            .resumeTimer)
                                    }
                                })

                                Toast.fire({
                                    icon: 'success',
                                    title: 'Data berhasil diubah'
                                })
                                setTimeout(() => {

                                    location.reload();
                                }, 2000);

                            }
                        });
                        // Swal.fire('Saved!', '', 'success')
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
                    }
                })
            }

        })

        $('#tablePen').on('keyup', '.bobot , .clo', function () {

            $("table tbody tr").each(function (i, v) {

                data[i] = Array();
                clo[i] = Array();


                $(this).children('td').each(function (ii, vv) {


                    if (ii == 1) {
                        //get data kode CLO
                        // data[i][ii] = $(this).text().trim();

                        data[i][ii] = $(this).find('#idClo').val();
                        clo[i][ii] = $(this).find('#idClo').val();
                    } else if (ii >= 2) {

                        if ($(this).find('.bobot').val()) {

                            data[i][ii] = $(this).find('.bobot').val();

                        } else if ($(this).find('.clo').val()) {

                            clo[i][ii] = $(this).find('.clo').val();
                        }

                    }

                });

            })

            $.ajax({
                url: "{{ route('penilaian.getTotal') }}",
                type: "GET",
                data: {
                    bobotClo: data
                },
                dataType: "JSON",
                success: function (data) {
                    console.log(data);
                    for (let i = 0; i < data[0].length; i++) {
                        $('#ttlClo' + (i + 1)).text(data[0][i][0]);
                    }
                    $('#ttlperClo').text(data[1]);
                    if (data[1] > 100) {
                        Swal.fire(
                            'Total bobot per CLO tidak boleh lebih dari 100%',
                            '',
                            'error');
                    }
                    for (let j = 0; j < data[2].length; j++) {
                        $('#ttlperBobot' + (j + 1)).text(data[2][j][0]);

                    }
                }
            });

            console.log(data);
            console.log(clo);
        })

        $("table tr").each(function (i, v) {
            $(this).children('th').each(function (jj, vv) {

                if ($(this).find('.idBtk').val()) {

                    btkNilai[jj] = $(this).find('.idBtk').val();
                }

            })
        });
        console.log(btkNilai);


    })

</script>
@endpush
