@extends('layouts.main')
@section('rps', 'active')
@section('penilaian', 'active')
@section('content')
<section class="section">

    @include('rps.section-header')
    <div class="section-body">
        <div class="d-flex align-items-center my-0">
            <h2 class="section-title">Penilaian</h2>

        </div>

        {{-- <p class="section-lead">Masukkan, ubah data PEO </p> --}}

        <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Bentuk Penilaian</h4>

                    </div>
                    <div class="card-body">
                        <form action="{{ route('penilaian.store', $rps->id) }}" method="POST">

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
                        <a href="#" type="button" class="btn btn-primary ml-auto" id="swalSave"><i
                                class="fas fa-save"></i>
                            Simpan
                            Penilaian</a>
                    </div>
                    <div class="card-body">

                        <table class="table table-striped table-responsive" width="100%" id="table">
                            <thead>
                                <tr>
                                    <th rowspan="3" class="align-middle text-center">#</th>
                                    <th rowspan="3" class="align-middle text-center">
                                        <div style="width: 100px;">
                                            Kode CLO
                                        </div>
                                    </th>
                                    <th colspan="6">
                                        Bobot per bentuk penilaian (%)
                                    </th>
                                    <th rowspan="3" class="align-middle">Total Bobot per CLO (%)</th>
                                    <th rowspan="3" class="align-middle">Target Kelulusan(%)</th>
                                    <th rowspan="3" class="align-middle">Nilai Min</th>
                                </tr>
                                <tr>
                                    <th>Menyampaikan Pendapat</th>
                                    <th>Tugas Mandiri</th>
                                    <th>Tugas Kelompok</th>
                                    <th>Presentasi</th>
                                    <th>UTS</th>
                                    <th>UAS(Proyek)</th>

                                </tr>
                                <tr>

                                    <th>
                                        TGS
                                    </th>
                                    <th>
                                        TGS
                                    </th>
                                    <th>
                                        TGS
                                    </th>
                                    <th>
                                        TGS
                                    </th>
                                    <th>
                                        TGS
                                    </th>
                                    <th>
                                        TGS
                                    </th>
                                </tr>

                            </thead>
                            <tbody class="text-center">
                                @foreach ($clo as $i)

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $i->kode_clo }}
                                    </td>
                                    <td><input type="text" value="6" class="form-control bobot"></td>
                                    <td><input type="text" value="6" class="form-control bobot"></td>
                                    <td><input type="text" value="6" class="form-control bobot"></td>
                                    <td><input type="text" value="6" class="form-control bobot"></td>
                                    <td><input type="text" value="6" class="form-control bobot"></td>
                                    <td><input type="text" value="6" class="form-control bobot"></td>
                                    <td class="align-middle">6</td>
                                    <td><input type="text" value="6" class="form-control clo"></td>
                                    <td><input type="text" value="6" class="form-control clo"></td>
                                </tr>
                                @endforeach
                            </tbody>
                            {{-- <tfoot>
                                <tr>
                                    <td colspan="2"> <strong>Total per penilaian (%)</strong> </td>
                                    <td><strong>6</strong></td>
                                    <td><strong>6</strong></td>
                                    <td><strong>6</strong></td>
                                    <td><strong>6</strong></td>
                                    <td><strong>6</strong></td>



                                </tr>
                            </tfoot> --}}
                        </table>


                    </div>
                </div>

            </div>
        </div>
    </div>


</section>
@endsection
@push('script')
<script>
    $(document).ready(function () {
        $('#swalSave').click(function () {
            Swal.fire({
                title: 'Do you want to save the changes?',
                showCancelButton: true,
                confirmButtonText: 'Save',
                denyButtonText: `Don't save`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire('Saved!', '', 'success')
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })
        })

        var data = Array();
        var clo = Array();

        $("table tr").each(function (i, v) {
            data[i] = Array();
            clo[i] = Array();
            $(this).children('td').each(function (ii, vv) {

                if (ii == 1) {

                    data[i][ii] = $(this).text().trim();
                } else if (ii >= 2) {
                    if ($(this).find('.bobot').val()) {

                        data[i][ii] = $(this).find('.bobot').val();
                    } else if ($(this).find('.clo').val()) {

                        clo[i][ii] = $(this).find('.clo').val();
                    }

                }
            });
        })

        console.log(data.filter(x => !!x.length));
        console.log(clo.filter(x => !!x.length));




    })

</script>
@endpush
@section('script')
<script>
    $(document).ready(function () {
        // $('.table').DataTable();


        // var colom = [];
        // $.ajax({
        //     url: '',

        //     method: 'get',
        //     async: false,
        //     success: function (data) {
        //         colom = data;
        //     }
        // })

        // var table_detail = $('.table').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     ajax: "{{ route('penilaian.getclo', $rps->id) }}",
        //     columns: [{
        //             data: 'kode_clo',
        //             name: 'kode_clo'
        //         },
        //         {
        //             data: 'kode_clo',
        //             name: 'kode_clo'
        //         },
        //         {
        //             data: 'kode_clo',
        //             name: 'kode_clo'
        //         }

        //         // {data: 'action', name: 'action', orderable: false, searchable: false},
        //     ],
        //     language: {
        //         url: 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/id.json'
        //     },
        //     createdRow: function (row, data, dataIndex) {
        //         console.log(data)
        //         // $(row).find('td:eq(3)').addClass('updateqty');
        //         // $(row).find('td:eq(3)').attr('data-idbarang', data['kode_clo']);

        //         $.each($('td:eq(1)', row), function (colIndex) {
        //             $(this).attr('contenteditable', 'true');
        //         });
        //         $.each($('td:eq(2)', row), function (colIndex) {
        //             $(this).attr('contenteditable', 'true');
        //         });
        //         $.each($('td:eq(3)', row), function (colIndex) {
        //             $(this).attr('contenteditable', 'true');
        //         });
        //         $.each($('td:eq(4)', row), function (colIndex) {
        //             $(this).attr('contenteditable', 'true');
        //         });
        //     }
        // })
    })

</script>
@endsection
