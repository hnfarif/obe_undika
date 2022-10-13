<script src="{{ asset('assets/js/page/daterangepicker.js') }}"></script>
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
                'mk_id': "{{ $rps->kurlkl_id }}",
            },
            success: function (data) {
                $('#responsi').val(data * 60);
                $('#belajarMandiri').val(data * 60);
            }

        })
    }

    $('input[type=radio][name=praktikum]').change(function () {
        if (this.value == '1') {

            $.ajax({
                url: "{{ route('kuliah.getSks') }}",
                type: 'GET',
                data: {
                    'mk_id': "{{ $rps->kurlkl_id }}",
                },
                success: function (data) {

                    $('#responsi').val('');
                    $('#belajarMandiri').val('');
                    $('#tm').val('');
                    $('#sl').val('');
                    $('#asl').val('');
                    $('#asm').val('');
                    $('#tm').attr('readonly', 'readonly');
                    $('#sl').attr('readonly', 'readonly');
                    $('#asl').attr('readonly', 'readonly');
                    $('#asm').attr('readonly', 'readonly');
                    $('#prak').removeAttr('readonly');
                }

            })
        } else if (this.value == '0') {
            $.ajax({
                url: "{{ route('kuliah.getSks') }}",
                type: 'GET',
                data: {
                    'mk_id': "{{ $rps->kurlkl_id }}",
                },
                success: function (data) {
                    $('#responsi').val(data * 60);
                    $('#belajarMandiri').val(data * 60);
                    $('#prak').attr('readonly', 'readonly');
                    $('#tm').removeAttr('readonly');
                    $('#sl').removeAttr('readonly');
                    $('#asl').removeAttr('readonly');
                    $('#asm').removeAttr('readonly');
                    $('#prak').val('');
                }

            })
        }
    });

    $(document).ready(function () {


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
            const d = new Date();
            let ms = d.valueOf();
            var llo = '';
            if ($('#kode_llo_opt').val()) {
                llo = $('#kode_llo_opt').val();
            } else if ($('#kode_llo').val()) {
                llo = $('#kode_llo').val();
            }

            $(".invalid-feedback").attr('hidden', 'hidden');
            $(".form-control + span").removeClass('is-invalid');
            $(".form-control").removeClass('is-invalid');

            $.ajax({
                url: "{{ route('llo.session.store') }}",
                type: "GET",
                dataType: "JSON",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'rps_id': "{{ $rps->id }}",
                    'idRow': ms,
                    'week': $('#optweek').val(),
                    'clo_id': $('#clo_id').val(),
                    'kode_llo': llo.toUpperCase(),
                    'des_llo': $('#des_llo').val(),
                    'capai_llo': $('#capai_llo').val(),
                    'btk_penilaian': $('#btk_penilaian').val(),
                    'bbt_penilaian': $('#bbt_penilaian').val(),
                    'des_penilaian': $('#des_penilaian').val(),
                    'isPrak': $('input[type=radio][name=praktikum]:checked').val(),
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
                        $(".invalid-feedback").attr('hidden', 'hidden');
                        $(".form-control + span").removeClass('is-invalid');
                        $(".form-control").removeClass('is-invalid');
                        if (data.error) {
                            var validation = "";
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops, Terdapat Data yang error!',
                                text: "Mohon perbaiki data Anda!",
                            })

                            data.error.forEach(element => {

                                if (element.includes("format")) {
                                    validation = "format";
                                } else {
                                    validation = "field"
                                }

                                var mySubString = element.substring(
                                    element.indexOf("The ") + 4,
                                    element.lastIndexOf(" " + validation),


                                );
                                var key = mySubString.split(' ').join('_')

                                $("#" + key + " + span").addClass('is-invalid');
                                $("#" +
                                    key + "_opt + span").addClass('is-invalid');
                                $("#" +
                                    key).addClass('is-invalid');
                                $(".inv" + key)
                                    .removeAttr('hidden');
                                $(".inv" + key).text(
                                    element);

                            });



                        } else if (data.errBbt) {

                            Array.from(data.errBbt).forEach(element => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops, ada kesalahan!',
                                    text: 'Maaf data bobot penilaian yang anda masukkan dijumlahkan melebihi 100%, Harap perbaiki data anda',
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

        $('.delAll').on('click', function () {
            var status = $(this).data('status');

            $.ajax({
                url: "{{ route('materi.session.deleteall') }}",
                type: "GET",
                dataType: "JSON",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'rps_id': "{{ $rps->id }}",
                    'status': status,
                },
                success: function (data) {
                    if (status == 'kajian') {
                        tableKajian.ajax.reload();
                    } else if (status == 'materi') {
                        tableMateri.ajax.reload();
                    } else if (status == 'pustaka') {
                        tablePustaka.ajax.reload();
                    } else if (status == 'media') {
                        tableMedia.ajax.reload();
                    } else if (status == 'metode') {
                        tableMetode.ajax.reload();
                    } else if (status == 'pbm') {
                        tablePbm.ajax.reload();
                    }
                }

            })
        });

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
                            'idRow': $(this).data('id'),
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

        $('#tableMateri').on('click', '.delmateri', function () {

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

        $('#tableKajian').on('click', '.delkajian', function () {

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

        $('#tableMedia').on('click', '.delmedia', function () {

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

        $('#tableMetode').on('click', '.delmetode', function () {

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
                    "#kode_llo,#kode_llo_opt,#bbt_penilaian,#inKajian,#inMateri,#judul,#bab,#halaman,#mediaPembelajaran,#metodePem,#tm,#sl,#asl,#asm,textarea,select"
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

        $('#btnFormClo').on('click', function () {
            var week = $("#week").val();

            if (!week) {
                $('#formAgenda').modal('hide');
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Silahkan pilih minggu terlebih dahulu!',
                })
            }

            $.ajax({
                url: "{{ route('create.session.getLlo') }}",
                type: "GET",
                dataType: "JSON",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'rps_id': "{{ $rps->id }}",
                },
                success: function (data) {

                    $("#kode_llo_opt").select2("destroy");
                    $("#kode_llo_opt").select2();

                    if ($("#recentSession").children().length > 0 && data > 0) {
                        $('#recentSession').children("option").remove();
                        data.forEach(element => {
                            $("#recentSession").append(
                                '<option value="' + element +
                                '" data-sts="lloSes">' + element +
                                '</option>');

                        });

                    } else if (data == 0) {
                        $('#recentSession').children("option").remove();
                        $("#recentSession").append(
                            '<option value="0" disabled>Tidak ada data</option>');

                    } else {
                        $('#recentSession').children("option").remove();
                        data.forEach(element => {
                            $("#recentSession").append(
                                '<option value="' + element +
                                '" data-sts="lloSes">' + element +
                                '</option>');
                        });
                    }


                }
            })
        })

        $("#addNewLlo").on('click', function () {
            $('#inNewLlo').removeAttr('hidden');
            $('#sltLlo').attr('hidden', 'hidden');
            $('#kode_llo_opt').val('default').change();
            $('#des_llo').val('');


        })

        $("#cancelAddNewLlo").on('click', function () {
            $('#inNewLlo').attr('hidden', 'hidden');
            $('#sltLlo').removeAttr('hidden');
            $('#kode_llo').val('');

        })

        $("#kode_llo_opt, input[type=radio][name=praktikum]").on('change', function () {
            var kode_llo = $("#kode_llo_opt").val();
            var isPrak = $("input[type=radio][name=praktikum]:checked").val();
            var db = ($('#kode_llo_opt option:selected').attr('data-sts') == 'lloDb') ? 'lloDb' : '';

            $.ajax({
                url: "{{ route('create.getLlo') }}",
                type: "GET",
                dataType: "JSON",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'rps_id': "{{ $rps->id }}",
                    'kode_llo': kode_llo,
                    'isDb': db,
                    'isPrak': isPrak,
                },
                beforeSend: function () {
                    $("#loadDesc").show();
                },
                success: function (data) {
                    $("#des_llo").val(data)
                },
                complete: function (data) {
                    $("#loadDesc").hide();
                }
            })


        });

    });

</script>
