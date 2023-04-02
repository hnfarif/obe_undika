<script src="{{ asset('assets/js/page/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/js/intro.js') }}"></script>
<script>
    $('#tableAgd').DataTable({
        scrollY: 500,
        scrollX: true,
        scroller: true,
        columnDefs: [{
            type: 'natural',
            targets: 0
        }]
    });


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
                    'rps_id': "{{ $rps->id }}",
                },
                success: function (data) {
                    $('#responsi').val(data.mata_kuliah.sks * 60);
                    $('#belajarMandiri').val(data.mata_kuliah.sks * 60);
                    $('#responsi').attr('readonly', 'readonly');
                    $('#belajarMandiri').attr('readonly', 'readonly');
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
            "url": "{{ route('materi.edit', $rps->id) }}",
            "type": "GET",
            "data": {
                'status': 'kajian',
                'detail_id': function () {
                    return $('#idDtl').val()
                },
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
            "url": "{{ route('materi.edit', $rps->id) }}",
            "type": "GET",
            "data": {
                'status': 'materi',
                'detail_id': function () {
                    return $('#idDtl').val()
                },
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

    var tablePustaka = $('#tablePustaka').DataTable({
        "searching": false,
        'paging': false,
        'info': false,
        'ordering': true,
        processing: true,
        serverSide: false,
        ajax: {
            "url": "{{ route('materi.edit', $rps->id) }}",
            "type": "GET",
            "data": {
                'status': 'pustaka',
                'detail_id': function () {
                    return $('#idDtl').val()
                },
            }
        },
        columns: [{
                data: "jdl_ptk",
                name: "judul"
            },
            {
                data: "bab_ptk",
                name: "bab"
            },
            {
                data: "hal_ptk",
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
            "url": "{{ route('materi.edit', $rps->id) }}",
            "type": "GET",
            "data": {
                'status': 'media',
                'detail_id': function () {
                    return $('#idDtl').val()
                },
            }
        },
        columns: [{
                data: "media_bljr",
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
            "url": "{{ route('materi.edit', $rps->id) }}",
            "type": "GET",
            "data": {
                'status': 'metode',
                'detail_id': function () {
                    return $('#idDtl').val()
                },
            }
        },
        columns: [{
                data: "mtd_bljr",
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
            "url": "{{ route('materi.edit', $rps->id) }}",
            "type": "GET",
            "data": {
                'status': 'pbm',
                'detail_id': function () {
                    return $('#idDtl').val()
                },
            }
        },
        columns: [{
                data: "deskripsi_pbm",
                name: "pbm"
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

    $('#introClo').click(function () {
        introJs().setOptions({
            steps: [{
                    intro: "Selamat datang di menu Agenda Pembelajaran (AP), di menu ini Anda dapat mengelola data AP. Sebelum mengelola data AP, pastikan data CLO dan Penilaian sudah sesuai. Kemudian agar RPS dapat diselesaikan, harap pastikan data bobot pada AP mencapai 100%",
                    title: "Hi there!",
                },
                {
                    element: document.querySelector('.intro-form-ap'),
                    intro: "Tekan tombol ini untuk beralih ke halaman form tambah Agenda Pembelajaran tiap minggunya.",
                },
                {
                    element: document.querySelector('.intro-table-ap'),
                    intro: "Data yang ditambahkan akan ditampilkan pada tabel ini. Anda dapat mengedit dan menghapus data yang telah ditambahkan.",
                },


            ],
        }).start();
    });

    $(document).ready(function () {
        var llo = [];
        $('.sn-capai').summernote({
            toolbar: [],

        });

        $('.sn-pen').summernote({
            toolbar: [],

        });

        $('#tableAgd').on('click', '.btnEditAgd', function (e) {
            var id = $(this).data('id');
            $('#idDtl').val(id)
            tableKajian.ajax.reload();
            tableMateri.ajax.reload();
            tablePustaka.ajax.reload();
            tableMedia.ajax.reload();
            tableMetode.ajax.reload();
            tablePbm.ajax.reload();

            $.ajax({
                url: "{{ route('agenda.edit') }}",
                type: "GET",
                data: {
                    id: id,
                    rps_id: "{{ $rps->id }}"
                },
                beforeSend: function () {
                    $("#loadTitle").show();
                },
                success: function (data) {
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

                    $('#kode_llo_opt').children("option").each(function () {
                        if (data.llo) {
                            if ($(this).val() == data.llo_id) {
                                $(this).remove();
                                $('#kode_llo_opt').prepend(
                                    `<option selected data-sts="lloDb" data-index="true" value="${data.llo_id}">${data.llo.kode_llo}</option>`
                                );
                            }
                        } else {
                            $('#kode_llo_opt').val('default').change();
                        }
                    });

                    if (data.praktikum) {
                        if (data.llo) {

                            $('#des_llo').val(data.llo.deskripsi_prak);
                        } else {
                            $('#des_llo').val('');
                        }
                    } else {
                        if (data.llo) {

                            $('#des_llo').val(data.llo.deskripsi);
                        } else {
                            $('#des_llo').val('');
                        }
                    }
                    $('.sn-capai').summernote('code', data.capaian_llo);
                    $('#btk_penilaian').children("option").each(function () {
                        if (data.penilaian) {

                            if ($(this).val() == data.penilaian.id) {
                                $(this).remove();
                                $('#btk_penilaian').append(
                                    `<option selected value="${data.penilaian.id}">${data.penilaian.btk_penilaian} </option>`
                                );
                            }
                        } else {
                            $('#btk_penilaian').val('default').change();
                        }
                    });
                    $('#bbt_penilaian').val(data.bobot)
                    $('.sn-pen').summernote('code', data.deskripsi_penilaian);
                    $('#tm').val(data.tm)
                    $('#sl').val(data.sl)
                    $('#asl').val(data.asl)
                    $('#asm').val(data.asm)
                    $('#responsi').val(data.res_tutor)
                    $('#belajarMandiri').val(data.bljr_mandiri)
                    $('#prak').val(data.praktikum)
                    if (data.praktikum) {
                        $('#radioyes').prop("checked", true);
                        $('#prak').removeAttr('readonly');
                        $('#tm').attr('readonly', 'readonly');
                        $('#sl').attr('readonly', 'readonly');
                        $('#asl').attr('readonly', 'readonly');
                        $('#asm').attr('readonly', 'readonly');

                    } else {
                        $('#radiono').prop("checked", true);
                        $('#prak').attr('readonly', 'readonly');
                        $('#tm').removeAttr('readonly');
                        $('#sl').removeAttr('readonly');
                        $('#asl').removeAttr('readonly');
                        $('#asm').removeAttr('readonly');
                    }
                },
                complete: function () {
                    $("#loadTitle").hide();
                }
            })

        })

        $('#tableAgd').on('click', '.delDtlAgd', function (e) {

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


        $('#btnKajian').click(function () {

            $.ajax({
                url: "{{ route('materi.add') }}",
                type: "GET",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'detail_id': $('#idDtl').val(),
                    'materi': $('#inKajian').val(),
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
                                text: 'Isi dahulu entrian Bahan Kajian anda',
                            })
                        });
                    }
                }
            })
        })

        $('#btnMateri').click(function () {

            $.ajax({
                url: "{{ route('materi.add') }}",
                type: "GET",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'detail_id': $('#idDtl').val(),
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
                                text: 'Isi dahulu entrian Materi anda',
                            })
                        });
                    }
                }
            })
        })

        $('#btnPustaka').click(function () {

            $.ajax({
                url: "{{ route('materi.add') }}",
                type: "GET",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'detail_id': $('#idDtl').val(),
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
                url: "{{ route('materi.add') }}",
                type: "GET",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'detail_id': $('#idDtl').val(),
                    'materi': $('#mediaPembelajaran').val(),
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
                                text: 'Isi dahulu entrian Media Pembelajaran anda',
                            })
                        });
                    }
                }
            })
        })

        $('#btnMetode').click(function () {

            $.ajax({
                url: "{{ route('materi.add') }}",
                type: "GET",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'detail_id': $('#idDtl').val(),
                    'materi': $('#metodePem').val(),
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
                                text: 'Isi dahulu entrian Metode Pembelajaran anda',
                            })
                        });
                    }
                }
            })
        })

        $('#btnPbm').click(function () {

            $.ajax({
                url: "{{ route('materi.add') }}",
                type: "GET",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'detail_id': $('#idDtl').val(),
                    'materi': $('#desPbm').val(),
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
                                text: 'Isi dahulu entrian Pengalaman Belajar Mahasiswa',
                            })
                        });
                    }
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
                        url: "{{ route('materi.remove') }}",
                        type: "GET",
                        dataType: "JSON",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'detail_id': $(this).data('kajian'),
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
                        url: "{{ route('materi.remove') }}",
                        type: "GET",
                        dataType: "JSON",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'detail_id': $(this).data('materi'),
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

        $('#tablePustaka').on('click', '.delpustaka', function () {

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
                        url: "{{ route('materi.remove') }}",
                        type: "GET",
                        dataType: "JSON",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'detail_id': $(this).data('pustaka'),
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
                        url: "{{ route('materi.remove') }}",
                        type: "GET",
                        dataType: "JSON",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'detail_id': $(this).data('media'),
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
                        url: "{{ route('materi.remove') }}",
                        type: "GET",
                        dataType: "JSON",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'detail_id': $(this).data('metode'),
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

        $('#tablePbm').on('click', '.delpbm', function () {

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
                        url: "{{ route('materi.remove') }}",
                        type: "GET",
                        dataType: "JSON",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'detail_id': $(this).data('pbm'),
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
                    'kode_llo': $('#kode_llo_opt').val(),
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

        $("#kode_llo_opt, input[type=radio][name=praktikum]").on('change', function () {
            var kode_llo = $("#kode_llo_opt").val();
            var isPrak = $("input[type=radio][name=praktikum]:checked").val();
            var db = ($('#kode_llo_opt option:selected').attr('data-sts') == 'lloDb') ? true : false;
            $.ajax({
                url: "{{ route('create.getLlo') }}",
                type: "GET",
                dataType: "JSON",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'rps_id': "{{ $rps->id }}",
                    'kode_llo': kode_llo,
                    'isDb': db,
                    'isIndex': $('#kode_llo_opt option:selected').attr('data-index'),
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
@include('rps.script')
