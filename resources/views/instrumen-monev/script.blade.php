<script src="//cdn.datatables.net/plug-ins/1.12.0/sorting/natural.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
<script>
    $(document).ready(function () {

        var data = Array();

        var sumMhsCapai = 0;
        var sumMhsNoCapai = 0;

        // var tableRps = $('#tableRps').DataTable({
        //     scrollY: 500,
        //     scrollX: true,
        //     scroller: true,
        //     autoWidth: false,
        //     columns: [{
        //             width: "100px"
        //         },
        //         {
        //             width: "100px"
        //         },
        //         {
        //             width: "150px"
        //         },
        //         {
        //             width: "150px"
        //         },
        //         {
        //             width: "150px"
        //         },
        //         {
        //             width: "150px"
        //         },
        //         {
        //             width: "150px"
        //         },
        //         {
        //             width: "150px"
        //         },
        //         {
        //             width: "150px"
        //         },
        //         {
        //             width: "150px"
        //         },
        //         {
        //             width: "150px"
        //         },
        //         {
        //             width: "150px"
        //         },
        //         {
        //             width: "150px"
        //         },
        //         {
        //             width: "150px"
        //         },
        //         {
        //             width: "150px"
        //         },
        //     ],
        //     columnDefs: [{
        //         type: 'natural',
        //         targets: 0
        //     }]
        // });

        // tableRps.columns.adjust().draw();


        $('#tableMonevKri2').DataTable({
            'info': false,
            'paging': false,
            'searching': false,
            'ordering': false,

        });


        $('#tableIns').DataTable({
            paging: false,
            searching: false,
            info: false,
            scrollCollapse: true,
            scroller: true,
            select: true,
            fixedColumns: {
                left: 2
            }
        });



        $('input[type=radio][name=optMon]').change(function () {
            if ($(this).val() == 'monev') {
                $('.monev').removeClass('d-none');
                $('.insNilai').addClass('d-none');
                $('.bap').addClass('d-none');
                $('.rps').addClass('d-none');
            } else if ($(this).val() == 'insNilai') {
                $('.insNilai').removeClass('d-none');
                $('.monev').addClass('d-none');
                $('.bap').addClass('d-none');
                $('.rps').addClass('d-none');

            } else if ($(this).val() == 'bap') {
                $('.bap').removeClass('d-none');
                $('.monev').addClass('d-none');
                $('.insNilai').addClass('d-none');
                $('.rps').addClass('d-none');
            } else if ($(this).val() == 'rps') {
                $('.rps').removeClass('d-none');
                $('.monev').addClass('d-none');
                $('.insNilai').addClass('d-none');
                $('.bap').addClass('d-none');
            }
        })

        $('#tableKri').on('click', '.editKri', function () {
            var id = $(this).attr('data-id');

            $.ajax({
                url: "{{ route('monev.showCriteria') }}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {

                    $("#kri_id").val(data.id);
                    $("#kategori").val(data.kategori);
                    $("#kriteria_penilaian").val(data.kri_penilaian);
                    $("#bobot").val(data.bobot);
                    $("#deskripsi").val(data.deskripsi);
                }
            })
        })
        $('#tableKri').on('click', '.delKri', function (e) {

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
        $('.eval-kri-1').each(function (i, v) {
            var sum = 0;
            var count = 0;

            $('#kri-1').find('tbody').find('tr').find('.nilai-kri-1').each(function (j, v) {
                if ($(this).text() != 0) {
                    sum += +parseFloat($(this).text());
                    count++;
                }
            })
            // console.log(sum);
            var avg = sum / parseFloat(count);
            $(this).text(avg.toFixed(2));
        })

        $('.ttlClo').each(function (i, v) {
            var sum = 0;
            var dataCl = $(this).data('cl');
            $(this).prevAll('td').find('.nilai').each(function () {
                var bbt = $(this).closest('td').find('#bobot').val();
                if ($(this).data('cl') == dataCl) {
                    sum += +($(this).val() * (bbt / 100));
                }
            });
            $(this).text(sum.toFixed(2));
        });

        $('.nKvs').each(function (i, v) {

            var sumBbt = $(this).data('sumbobot');
            var ttlClo = parseFloat($(this).prev().text());
            if (sumBbt == 0) {
                sumBbt = 1;
            }
            var nKvs = (ttlClo / sumBbt) * 100;
            $(this).text(nKvs.toFixed(2));
        });

        $('.stsLulus').each(function (i, v) {
            var nilaiMin = $(this).data('nilaimin');
            var nKvs = parseFloat($(this).prev().text());
            if (nKvs >= nilaiMin) {
                $(this).text('L');

            } else {
                $(this).text('TL');

            }
        });

        $('.avgTtl').each(function (i, v) {
            var arr = [];
            var sum = 0;
            var dataCl = $(this).data('cl');
            $(this).closest('table').find('tbody').find('tr').find('.ttlClo').each(function () {
                var dataCl2 = $(this).data('cl');
                if (dataCl == dataCl2) {
                    arr.push(parseFloat($(this).text()));
                }
            });

            for (var number of arr) {
                sum += number;
            }

            var avg = sum / arr.length;
            $(this).text(avg.toFixed(2));
        })

        $('.avgKvs').each(function (i, v) {

            var arr = [];
            var sum = 0;
            var dataCl = $(this).data('cl');

            $(this).closest('table').find('tbody').find('tr').find('.nKvs').each(function () {
                var dataCl2 = $(this).data('cl');
                if (dataCl == dataCl2) {
                    arr.push(parseFloat($(this).text()));
                }
            });

            for (var number of arr) {
                sum += number;
            }

            var avg = sum / arr.length;
            $(this).text(avg.toFixed(2));
        })

        $('.avgStsLulus').each(function (i, v) {
            var getKvs = parseFloat($(this).prev().text());
            var getNilaiMin = $(this).data('nilaimin');
            if (getKvs >= getNilaiMin) {
                $(this).text('L');
            } else {
                $(this).text('TL');
            }


        })

        $('.naObe').each(function (i, v) {
            var sum = 0;

            $(this).prevAll('.nKvs').each(function (i, v) {
                var bbt = $(this).data('sumbobot');
                var nKvs = parseFloat($(this).text());
                sum += (nKvs * (bbt / 100));
            });

            $(this).text(Math.round(sum));
        });

        $('.nhObe').each(function (i, v) {

            var naObe = parseFloat($(this).prev().text());

            if (naObe < 40) {
                $(this).text('E');
            } else if (naObe >= 40 && naObe < 55) {
                $(this).text('D');

            } else if (naObe >= 55 && naObe < 60) {
                $(this).text('C');
            } else if (naObe >= 60 && naObe < 65) {
                $(this).text('C+');
            } else if (naObe >= 65 && naObe < 75) {
                $(this).text('B');
            } else if (naObe >= 75 && naObe < 80) {
                $(this).text('B+');
            } else if (naObe >= 80) {
                $(this).text('A');
            }

        })

        $('.stsaLulus').each(function (i, v) {

            var nMin = $('#nilai_min_mk').val();
            var arrLulus = [];

            var naObe = parseFloat($(this).prev().prev().text());


            if (nMin) {


                $(this).prevAll('.stsLulus').each(function (i, v) {

                    arrLulus.push($(this).text());
                })

                if (!arrLulus.includes('TL') && naObe >= nMin) {
                    $(this).text('L')
                    sumMhsCapai++;
                } else {
                    $(this).text('TL')
                    sumMhsNoCapai++;
                }

            } else {
                $(this).text('isi nilai min mk');
            }
        })

        $('.jml').each(function (i, v) {
            var count = 0;
            $('.stsaLulus').each(function (i, v) {

                if ($(this).text() == 'L') {
                    count++;
                }
            })
            $(this).text(count);
        })

        $('.ilc').each(function (i, v) {
            var jml = parseFloat($('.jml').text());
            var jmk = parseFloat($('.jmk').text());
            var jmp = parseFloat($('.jmp').text());
            var ilc = jml / (jmk - jmp);
            $(this).text(ilc.toFixed(2));
        })

        $('.eval-clo').each(function (i, v) {
            var ilc = parseFloat($('.ilc').text());
            var eval = ilc * 4;

            $(this).text(eval.toFixed(2));
        });

        $('.preSesuai').each(function (i, v) {
            var sum = 0;
            $(this).prevAll('td').find('.nilai').each(function (i, v) {
                sum += +$(this).val();
            })
            var nilai = sum / 14 * 100;
            $(this).text(Math.round(nilai) + '%');
            // console.log(sum);
        });

        $('.nilaiSesuai').each(function (i, v) {

            var preSesuai = parseFloat($(this).prev().text());

            if (preSesuai > 80) {
                $(this).text('4');
            } else if (preSesuai <= 80 && preSesuai > 70) {

                $(this).text('3');
            } else if (preSesuai <= 70 && preSesuai > 60) {

                $(this).text('2');
            } else if (preSesuai <= 60 && preSesuai > 50) {

                $(this).text('1');
            } else if (preSesuai <= 50) {
                $(this).text('0');
            }

        });

        $('#btnSaveKri2').click(function () {

            $.ajax({
                url: "{{ route('monev.instrumen.store') }}",
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'dataNilai': data,
                    'idInsMon': "{{ $cekInsMon->id }}",
                },
                beforeSend: function () {
                    Swal.fire({
                        title: 'Menyimpan data...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading()
                        }
                    })
                },
                success: function (data) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: data.success,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }

            })
        })

        $('#tableMonevKri2').on('blur', '.nilai', function () {

            var temp = {
                'agd_id': $(this).closest('td').find('#agd').val(),
                'nilai': $(this).val(),
                'kri_id': $(this).closest('td').find('#kri').val()
            };

            data.forEach(element => {
                if (element.agd_id == temp.agd_id && element.kri_id == temp.kri_id) {
                    data.splice(data.indexOf(element), 1);
                }

            });

            if (temp.nilai > 1 || temp.nilai < 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Nilai tidak boleh lebih dari 1 atau kurang dari 0',
                })
                $(this).val('');
            } else if (temp.nilai != '') {

                data.push(temp);
            }

            if (data.length > 0) {
                $('#btnSaveKri2').removeAttr('disabled');
            } else {
                $('#btnSaveKri2').attr('disabled', 'disabled');
            }

        })

        $('.rangKri-1').each(function (i, v) {
            var eval = $('.eval-kri-1').text();

            $(this).text(eval);
        })

        $('.rangKri-2').each(function (i, v) {
            var eval = $('.nilaiSesuai').text();

            $(this).text(eval);
        })

        $('.rangKri-3').each(function (i, v) {
            var eval = $('.eval-clo').text();

            $(this).text(eval);
        })

        $('.rangFinal').each(function (i, v) {
            var bbt1 = parseFloat($('.bbt-kri-1').text());
            var bbt2 = parseFloat($('.bbt-kri-2').text());
            var bbt3 = parseFloat($('.bbt-kri-3').text());

            var nil1 = parseFloat($('.rangKri-1').text());
            var nil2 = parseFloat($('.rangKri-2').text());
            var nil3 = parseFloat($('.rangKri-3').text());

            var res = ((bbt1 * nil1) + (bbt2 * nil2) + (bbt3 * nil3)) / 100;

            $(this).text(res.toFixed(2));
        })
    })

</script>
