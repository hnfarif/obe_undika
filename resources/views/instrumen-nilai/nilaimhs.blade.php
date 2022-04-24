@extends('layouts.main')
@section('instrumen-nilai', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">

            {{-- @include('rps.section-header') --}}
            <div class="section-body">
                <div class="d-flex align-items-center my-0">
                    <h2 class="section-title">Instrumen Nilai Mahasiswa</h2>

                </div>
                {{-- <p class="section-lead">Masukkan, ubah data PEO </p> --}}

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Nilai Mahasiswa</h4>
                            </div>
                            <div class="card-body">

                                <table class="table table-striped table-responsive" width="100%">
                                    <thead>
                                        <tr>
                                            <th rowspan="3">#</th>
                                            <th rowspan="3">NIM</th>
                                            <th rowspan="3">Nama Mahasiswa</th>
                                            <th colspan="5">CLO-01</th>
                                            <th rowspan="3" class="align-text-top">Total CLO-01</th>
                                            <th colspan="5">CLO-02</th>
                                            <th rowspan="3" class="align-text-top">Total CLO-02</th>

                                        </tr>
                                        <tr>
                                            <th>Menyampaikan Pendapat</th>
                                            <th>Tugas Mandiri</th>
                                            <th>Menyampaikan Pendapat</th>
                                            <th>Tugas Mandiri</th>
                                            <th>Tugas Kelompok</th>
                                            <th>Tugas Kelompok</th>
                                            <th>Tugas Kelompok</th>
                                            <th>Tugas Kelompok</th>
                                            <th>Tugas Kelompok</th>
                                            <th>Tugas Kelompok</th>
                                        </tr>
                                        <tr>
                                            <th>TGS</th>
                                            <th>TGS</th>
                                            <th>TGS</th>
                                            <th>TGS</th>
                                            <th>TGS</th>
                                            <th>TGS</th>
                                            <th>TGS</th>
                                            <th>TGS</th>
                                            <th>TGS</th>
                                            <th>TGS</th>

                                        </tr>

                                    </thead>
                                    <tbody>
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
@endsection
@section('script')
<script src="{{ asset('assets/js/page/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/page/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
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
            ajax: "{{ route('data-nilai-mhs') }}",
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
                    data: 'total_bobot',
                    name: 'total_bobot'
                },
                {
                    data: 'total_bobot',
                    name: 'total_bobot'
                },
                {
                    data: 'total_bobot',
                    name: 'total_bobot'
                },
                {
                    data: 'total_bobot',
                    name: 'total_bobot'
                },
                {
                    data: 'total_bobot',
                    name: 'total_bobot'
                },
                {
                    data: 'total_bobot',
                    name: 'total_bobot'
                },

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
