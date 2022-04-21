@extends('layouts.main')
@section('rps', 'active')
@section('agenda', 'active')
@section('content')
<style>
    .ui-menu .ui-menu-item a {
        background: red;
        height: 10px;
        font-size: 8px;
    }

</style>

<section class="section">
    @include('rps.section-header')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="section-title mt-0">Table Tambah Data Agenda Pembelajaran</div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 col-lg-12 mb-3 d-flex">
                <button type="button" class="btn btn-primary" id="btnFormClo" data-toggle="modal"
                    data-target="#formAgenda"> <i class="fas fa-plus"></i> Tambah data</button>
                <form class="ml-auto" action="{{ route('agenda.store', $rps->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="week" id="week">
                    <button type="submit" class="btn btn-success ml-auto" id="btnSaveAgd"> <i class="fas fa-save"></i>
                        Simpan Data</button>

                </form>
            </div>

        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12 mb-3">
                <label>Pilih Minggu</label>
                <select class="form-control @error('week') is-invalid @enderror select2" id="optweek" required>
                    <option selected disabled> Pilih Minggu</option>
                    @for ($i = 1; $i <= 14; $i++) <option value="{{ $i }}">{{ 'Minggu Ke '.$i }}</option>
                        @endfor
                </select>
                @error('week')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>
        </div>
        <div class="row row-input">

            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-responsive" id="tableLlo">
                            <thead>
                                <tr>

                                    <th rowspan="2" class="align-middle text-center">Kode CLO</th>
                                    <th rowspan="2" class="align-middle text-center">Kode LLO</th>
                                    <th rowspan="2" class="align-middle text-center">
                                        <div style="min-width: 100px;">
                                            Deskripsi LLO
                                        </div>
                                    </th>
                                    <th rowspan="2" class="align-middle text-center">
                                        <div style="min-width: 150px;">
                                            Ketercapaian
                                        </div>
                                    </th>
                                    <th rowspan="2" class="align-middle text-center">
                                        <div style="min-width: 150px;">
                                            Bentuk Penilaian
                                        </div>
                                    </th>
                                    <th rowspan="2" class="align-middle text-center">
                                        <div style="min-width: 150px;">
                                            Pengalaman Belajar
                                        </div>
                                    </th>
                                    <th rowspan="2" class="align-middle text-center">
                                        <div style="min-width: 150px;">
                                            Materi
                                        </div>
                                    </th>
                                    <th rowspan="2" class="align-middle text-center">
                                        <div style="min-width: 150px;">
                                            Metode
                                        </div>
                                    </th>
                                    <th colspan="4">

                                        <div class="align-middle text-center" style="min-width: 150px;">
                                            Kuliah (menit/mg)
                                        </div>
                                    </th>
                                    <th rowspan="2" class="align-middle text-center">
                                        Responsi dan Tutorial
                                        (menit/mg)

                                    </th>
                                    <th rowspan="2" class="align-middle text-center">
                                        Belajar Mandiri
                                        (menit/mg)

                                    </th>
                                    <th rowspan="2" class="align-middle text-center">
                                        Praktikum
                                        (menit/mg)

                                    </th>
                                    <th rowspan="2" class="align-middle text-center">Aksi</th>
                                </tr>
                                <tr>
                                    <th>TM</th>
                                    <th>SL</th>
                                    <th>ASL</th>
                                    <th>ASM</th>
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

@include('rps.agenda.modalagd')

@endsection
@push('script')
<script>
    var tableLlo = $('#tableLlo').DataTable({
        "lengthMenu": [
            [3, 10, 20, -1],
            [3, 10, 20, "All"]
        ],
        // scrollY: 300,
        scrollX: true,
        scroller: true,
        processing: true,
        serverSide: false,
        ajax: "{{ route('agenda.create', $rps->id) }}",
        columns: [{
                data: "clo_id",
                name: "clo_id"
            },
            {
                data: "kode_llo",
                name: "kode_llo"
            },
            {
                data: "des_llo",
                name: "des_llo"
            },
            {
                data: "capai_llo",
                name: "capai_llo"
            },
            {
                data: "btk_penilaian",
                name: "btk_penilaian"
            },
            {
                data: "pbm",
                name: "pbm"
            },
            {
                data: "materi",
                name: "materi"
            },
            {
                data: "metode",
                name: "metode"
            },
            {
                data: "tm",
                name: "tm"
            },
            {
                data: "sl",
                name: "sl"
            },
            {
                data: "asl",
                name: "asl"
            },
            {
                data: "asm",
                name: "asm"
            },
            {
                data: "responsi",
                name: "responsi"
            },
            {
                data: "belajarMandiri",
                name: "belajarMandiri"
            },
            {
                data: "prak",
                name: "prak"
            },
            {
                data: "aksi",
                name: "aksi"
            },

        ]
    });

    var tableMateri = $('#tableMateri').DataTable({
        "drawCallback": function () {
            $(this.api().table().header()).hide();
        },
        "searching": false,
        'paging': false,
        'info': false,
        'ordering': true,
        processing: true,
        serverSide: false,
        ajax: {
            'url': "{{ route('materi.get', $rps->id) }}",
            'type': 'GET',
            'data': {
                'status': 'materi'
            }
        },
        columns: [{
                data: "materi",
                name: "materi"
            },
            {
                data: "aksi",
                name: "aksi"
            },
        ],
        createdRow: function (row, data, dataIndex) {
            // Set the data-status attribute, and add a class
            $(row).find('td:eq(0)').attr('style', 'width:350px;');
        }

    })

    var tableKajian = $('#tableKajian').DataTable({
        "drawCallback": function () {
            $(this.api().table().header()).hide();
        },
        "searching": false,
        'paging': false,
        'info': false,
        'ordering': true,
        processing: true,
        serverSide: false,
        ajax: {
            "url": "{{ route('materi.get', $rps->id) }}",
            "data": {
                'status': 'kajian'
            }
        },
        columns: [{
                data: "kajian",
                name: "kajian"
            },
            {
                data: "aksi",
                name: "aksi"
            },
        ],
        createdRow: function (row, data, dataIndex) {
            // Set the data-status attribute, and add a class
            $(row).find('td:eq(0)').attr('style', 'width:350px;');
        }

    })

    var tablePustaka = $('#tablePustaka').DataTable({
        "searching": false,
        'paging': false,
        'info': false,
        'ordering': true,
        processing: true,
        serverSide: false,
        ajax: {
            "url": "{{ route('materi.get', $rps->id) }}",
            "data": {
                'status': 'pustaka'
            }
        },
        columns: [{
                data: "judul",
                name: "judul"
            },
            {
                data: "bab",
                name: "bab"
            },
            {
                data: "halaman",
                name: "halaman"
            },
            {
                data: "aksi",
                name: "aksi"
            },
        ],
        createdRow: function (row, data, dataIndex) {
            // Set the data-status attribute, and add a class
            $(row).find('td:eq(0)').attr('style', 'width:115px;');
            $(row).find('td:eq(1)').attr('style', 'width:115px;');
            $(row).find('td:eq(2)').attr('style', 'width:115px;');
            $(row).find('td:eq(3)').attr('style', 'width:40px;');
        }

    })

    var tableMedia = $('#tableMedia').DataTable({
        "drawCallback": function () {
            $(this.api().table().header()).hide();
        },
        "searching": false,
        'paging': false,
        'info': false,
        'ordering': true,
        processing: true,
        serverSide: false,
        ajax: {
            "url": "{{ route('materi.get', $rps->id) }}",
            "data": {
                'status': 'media'
            }
        },
        columns: [{
                data: "media",
                name: "media"
            },
            {
                data: "aksi",
                name: "aksi"
            },
        ],
        createdRow: function (row, data, dataIndex) {
            // Set the data-status attribute, and add a class
            $(row).find('td:eq(0)').attr('style', 'width:350px;');
        }

    })

    var tableMetode = $('#tableMetode').DataTable({
        "drawCallback": function () {
            $(this.api().table().header()).hide();
        },
        "searching": false,
        'paging': false,
        'info': false,
        'ordering': true,
        processing: true,
        serverSide: false,
        ajax: {
            "url": "{{ route('materi.get', $rps->id) }}",
            "data": {
                'status': 'metode'
            }
        },
        columns: [{
                data: "metode",
                name: "metode"
            },
            {
                data: "aksi",
                name: "aksi"
            },
        ],
        createdRow: function (row, data, dataIndex) {
            // Set the data-status attribute, and add a class
            $(row).find('td:eq(0)').attr('style', 'width:350px;');
        }

    })

    var tablePbm = $('#tablePbm').DataTable({
        "drawCallback": function () {
            $(this.api().table().header()).hide();
        },
        "searching": false,
        'paging': false,
        'info': false,
        'ordering': true,
        processing: true,
        serverSide: false,
        ajax: {
            "url": "{{ route('materi.get', $rps->id) }}",
            "data": {
                'status': 'pbm'
            }
        },
        columns: [{
                data: "desPbm",
                name: "desPbm"
            },
            {
                data: "aksi",
                name: "aksi"
            },
        ],
        createdRow: function (row, data, dataIndex) {
            // Set the data-status attribute, and add a class
            $(row).find('td:eq(0)').attr('style', 'width:350px;');
        }

    })

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

        $('#btnMateri').click(function () {

            $.ajax({
                url: "{{ route('materi.store') }}",
                type: "GET",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'rps_id': "{{ $rps->id }}",
                    'materi': $('#inMateri').val(),
                    'status': 'materi'
                },
                success: function (data) {
                    if ($.isEmptyObject(data.error)) {
                        tableMateri.ajax.reload();
                        $('#inMateri').val('');
                        $('#accMateri').attr('aria-expanded', 'true');
                        $('#materi').attr('class', 'accordion-body collapse show');
                    } else {
                        data.error.forEach(element => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops, Terdapat Data yang kosong!',
                                text: 'Isi dahulu data materi anda',
                            })
                        });
                    }
                }
            })
        })

        $('#btnKajian').click(function () {

            $.ajax({
                url: "{{ route('materi.store') }}",
                type: "GET",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'rps_id': "{{ $rps->id }}",
                    'kajian': $('#inKajian').val(),
                    'status': 'kajian'
                },
                success: function (data) {

                    if ($.isEmptyObject(data.error)) {

                        tableKajian.ajax.reload();
                        $('#inKajian').val('');
                        $('#accKajian').attr('aria-expanded', 'true');
                        $('#kajian').attr('class', 'accordion-body collapse show');
                    } else {
                        data.error.forEach(element => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops, Terdapat Data yang kosong!',
                                text: 'Isi dahulu data Bahan Kajian anda',
                            })
                        });
                    }
                }
            })
        })

        $('#btnPustaka').click(function () {

            $.ajax({
                url: "{{ route('materi.store') }}",
                type: "GET",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'rps_id': "{{ $rps->id }}",
                    'id': 0,
                    'judul': $('#judul').val(),
                    'bab': $('#bab').val(),
                    'halaman': $('#halaman').val(),
                    'status': 'pustaka'
                },
                success: function (data) {
                    if ($.isEmptyObject(data.error)) {
                        tablePustaka.ajax.reload();
                        $('#judul').val('');
                        $('#bab').val('');
                        $('#halaman').val('');
                        $('#accPustaka').attr('aria-expanded', 'true');
                        $('#pustaka').attr('class', 'accordion-body collapse show');
                    } else {
                        data.error.forEach(element => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops, Terdapat Data yang kosong!',
                                text: element,
                            })
                        });
                    }
                }
            })
        })

        $('#btnMedia').click(function () {

            $.ajax({
                url: "{{ route('materi.store') }}",
                type: "GET",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'rps_id': "{{ $rps->id }}",
                    'media': $('#mediaPembelajaran').val(),
                    'status': 'media'
                },
                success: function (data) {
                    if ($.isEmptyObject(data.error)) {
                        tableMedia.ajax.reload();
                        $('#mediaPembelajaran').val('');
                        $('#accMedia').attr('aria-expanded', 'true');
                        $('#media').attr('class', 'accordion-body collapse show');
                    } else {
                        data.error.forEach(element => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops, Terdapat Data yang kosong!',
                                text: 'Harap isi data media pembelajaran anda',
                            })
                        });
                    }
                }
            })
        })

        $('#btnMetode').click(function () {

            $.ajax({
                url: "{{ route('materi.store') }}",
                type: "GET",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'rps_id': "{{ $rps->id }}",
                    'metode': $('#metodePem').val(),
                    'status': 'metode'
                },
                success: function (data) {
                    if ($.isEmptyObject(data.error)) {
                        tableMetode.ajax.reload();
                        $('#metodePem').val('');
                        $('#accMetode').attr('aria-expanded', 'true');
                        $('#metode').attr('class', 'accordion-body collapse show');
                    } else {
                        data.error.forEach(element => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops, Terdapat Data yang kosong!',
                                text: element,
                            })
                        });
                    }
                }
            })
        })

        $('#btnPbm').click(function () {

            $.ajax({
                url: "{{ route('materi.store') }}",
                type: "GET",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'rps_id': "{{ $rps->id }}",
                    'desPbm': $('#desPbm').val(),
                    'status': 'pbm'
                },
                success: function (data) {
                    if ($.isEmptyObject(data.error)) {
                        tablePbm.ajax.reload();
                        $('#desPbm').val('');
                        $('#accPbm').attr('aria-expanded', 'true');
                        $('#pbm').attr('class', 'accordion-body collapse show');
                    } else {
                        data.error.forEach(element => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops, Terdapat Data yang kosong!',
                                text: element,
                            })
                        });
                    }
                }
            })
        })

        $('#addLlo').click(function () {

            $.ajax({
                url: "{{ route('llo.session.store') }}",
                type: "GET",
                dataType: "JSON",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'rps_id': "{{ $rps->id }}",
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
                    'status': ['pustaka', 'media', 'metode', 'pbm', 'materi', 'kajian']
                },
                success: function (data) {
                    if ($.isEmptyObject(data.error) && $.isEmptyObject(data.errBbt) && $
                        .isEmptyObject(data.errMnt)) {
                        // console.log(data.listLlo);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Data Anda telah ditambahkan!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $('#clo_id').val('default').change();
                        $('#kode_llo').val('');
                        $('#des_llo').val('');
                        $('.sn-capai').summernote('code', '');
                        $('#btk_penilaian').val('');
                        $('#bbt_penilaian').val('');
                        $('#des_penilaian').val('');
                        $('#tm').val('');
                        $('#sl').val('');
                        $('#asl').val('');
                        $('#asm').val('');
                        $('#formAgenda').modal('hide');
                        tableLlo.ajax.reload();
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

        $('#tableLlo').on('click', '.deleteLlo', function () {

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
                    $.ajax({
                        url: "{{ route('llo.session.delete') }}",
                        type: "GET",
                        dataType: "JSON",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'rps_id': "{{ $rps->id }}",
                            'kodeClo': $(this).data('clo'),
                            'kodeLlo': $(this).data('llo'),
                        },
                        success: function (data) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: data.success,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            tableLlo.ajax.reload();
                        }

                    })
                }

            })
        })

        $('#tableMateri').on('click', '.delMateri', function () {

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
                    $.ajax({
                        url: "{{ route('materi.session.delete') }}",
                        type: "GET",
                        dataType: "JSON",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'rps_id': "{{ $rps->id }}",
                            'materi': $(this).data('materi'),
                            'status': 'materi',

                        },
                        success: function (data) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: data.success,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            tableMateri.ajax.reload();
                        }

                    })
                }

            })
        })

        $('#tableKajian').on('click', '.delKajian', function () {

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
                    $.ajax({
                        url: "{{ route('materi.session.delete') }}",
                        type: "GET",
                        dataType: "JSON",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'rps_id': "{{ $rps->id }}",
                            'kajian': $(this).data('kajian'),
                            'status': 'kajian',

                        },
                        success: function (data) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: data.success,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            tableKajian.ajax.reload();
                        }

                    })
                }

            })
        })

        $('#tablePustaka').on('click', '.delPustaka', function () {

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
                    $.ajax({
                        url: "{{ route('materi.session.delete') }}",
                        type: "GET",
                        dataType: "JSON",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'rps_id': "{{ $rps->id }}",
                            'id': $(this).data('pustaka'),
                            'status': 'pustaka',

                        },
                        success: function (data) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: data.success,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            tablePustaka.ajax.reload();
                        }

                    })
                }

            })
        })

        $('#tableMedia').on('click', '.delMedia', function () {

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
                    $.ajax({
                        url: "{{ route('materi.session.delete') }}",
                        type: "GET",
                        dataType: "JSON",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'rps_id': "{{ $rps->id }}",
                            'media': $(this).data('media'),
                            'status': 'media',

                        },
                        success: function (data) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: data.success,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            tableMedia.ajax.reload();
                        }

                    })
                }

            })
        })

        $('#tableMetode').on('click', '.delMetode', function () {

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
                    $.ajax({
                        url: "{{ route('materi.session.delete') }}",
                        type: "GET",
                        dataType: "JSON",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'rps_id': "{{ $rps->id }}",
                            'metode': $(this).data('metode'),
                            'status': 'metode',

                        },
                        success: function (data) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: data.success,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            tableMetode.ajax.reload();
                        }

                    })
                }

            })
        })

        $('#tablePbm').on('click', '.delPbm', function () {

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
                    $.ajax({
                        url: "{{ route('materi.session.delete') }}",
                        type: "GET",
                        dataType: "JSON",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'rps_id': "{{ $rps->id }}",
                            'desPbm': $(this).data('pbm'),
                            'status': 'pbm',

                        },
                        success: function (data) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: data.success,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            tablePbm.ajax.reload();
                        }

                    })
                }

            })
        })

        $('#formAgenda').on('hidden.bs.modal', function (e) {
            $(this)
                .find(
                    "#kode_llo,#bbt_penilaian,#inKajian,#inMateri,#judul,#bab,#halaman,#mediaPembelajaran,#metodePem,#tm,#sl,#asl,#asm,textarea,select"
                )
                .val('')
                .end()
                .find(".select2")
                .val('default')
                .change();
            $('.sn-capai').summernote('code', '');
            $('.sn-pen').summernote('code', '');

        })

        $('#optweek').on('change', function () {
            var week = $(this).val();
            $("#week").val(week);

        });

        $('#kode_llo').autocomplete({
            source: llo
        })
    })

</script>
@endpush
