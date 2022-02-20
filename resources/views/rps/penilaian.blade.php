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

                        <div class="form-group">
                            <label>Bentuk Penilaian</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Jenis Penilaian</label>
                            <select class="form-control select2">
                                <option>TGS</option>
                                <option>QUI</option>
                                <option>PRK</option>
                                <option>PRS</option>
                                <option>RES</option>
                                <option>PAP</option>
                                <option>LAI</option>
                                <option>UTS</option>
                                <option>UAS</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-primary">Tambah Bentuk Penilaian</button>
                        </div>

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

                        <table class="table table-striped table-responsive" width="100%">
                            <thead>
                                <tr>
                                    <th rowspan="3" class="align-middle">#</th>
                                    <th rowspan="3" class="align-middle">Kode CLO</th>
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
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"> <strong>Total per penilaian (%)</strong> </td>
                                    <td><strong>6</strong></td>
                                    <td><strong>6</strong></td>
                                    <td><strong>6</strong></td>
                                    <td><strong>6</strong></td>
                                    <td><strong>6</strong></td>
                                    <td><strong>6</strong></td>
                                    <td><strong>6</strong></td>

                                </tr>
                            </tfoot>
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

</script>
@endpush
@section('script')
<script>
    $(document).ready(function () {
        // $('.table').DataTable();


        var colom = [];
        $.ajax({
            url: '',
            method: 'get',
            async: false,
            success: function (data) {
                colom = data;
            }
        })

        var table_detail = $('.table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('data-penilaian') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'kode_clo',
                    name: 'kode_clo'
                },
                {
                    data: 'pendapat',
                    name: 'pendapat'
                },
                {
                    data: 'mandiri',
                    name: 'mandiri'
                },
                {
                    data: 'kelompok',
                    name: 'kelompok'
                },
                {
                    data: 'presentasi',
                    name: 'presentasi'
                },
                {
                    data: 'uts',
                    name: 'uts'
                },
                {
                    data: 'uas',
                    name: 'uas'
                },
                {
                    data: 'total_bobot',
                    name: 'total_bobot'
                },
                {
                    data: 'target_lls',
                    name: 'target_lls'
                },
                {
                    data: 'nilai_min',
                    name: 'nilai_min'
                }

                // {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/id.json'
            },
            createdRow: function (row, data, dataIndex) {
                console.log(data)
                $(row).find('td:eq(3)').addClass('updateqty');
                $(row).find('td:eq(3)').attr('data-idbarang', data['kode_clo']);
                $.each($('td:eq(2)', row), function (colIndex) {
                    $(this).attr('contenteditable', 'true');
                });
                $.each($('td:eq(3)', row), function (colIndex) {
                    $(this).attr('contenteditable', 'true');
                });
                $.each($('td:eq(4)', row), function (colIndex) {
                    $(this).attr('contenteditable', 'true');
                });
                $.each($('td:eq(5)', row), function (colIndex) {
                    $(this).attr('contenteditable', 'true');
                });
            }
        })
    })

</script>
@endsection
