<script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
<script src="{{ asset('assets/js/chart.js') }}"></script>
<script>
    var data = Array();
    var dataSummary = Array();

    var sumCapai = 0;
    var sumNoCapai = 0;

    var sumMhsCapai = 0;
    var sumMhsNoCapai = 0;

    $(document).ready(function () {
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

        $('#tableKonv').DataTable({
            paging: false,
            autoWidth: false,
            searching: false,
            info: false,
            scrollCollapse: true,
            scroller: true,
            select: true,
            fixedColumns: {
                left: 2
            },


        });

        $('#tableSummary').DataTable({
            paging: false,
            autoWidth: false,
            searching: false,
            info: false,
        });

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

            var nMin = $('.nilai_min_mk').text();
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

        $('input[type=radio][name=optvclo]').change(function () {
            if ($(this).val() == 'penClo') {
                $('.penClo').removeClass('d-none');
                $('.rangClo').addClass('d-none');
                $('.konvAak').addClass('d-none');
                $('.ttgMk').addClass('d-none');
                $('.titleClo').text('Instrumen Nilai Mahasiswa')
            } else if ($(this).val() == 'rangClo') {
                $('.penClo').addClass('d-none');
                $('.rangClo').removeClass('d-none');
                $('.konvAak').addClass('d-none');
                $('.ttgMk').addClass('d-none');
                $('.titleClo').text('Rangkuman Ketercapaian CLO')
            } else if ($(this).val() == 'konvAak') {
                $('.penClo').addClass('d-none');
                $('.rangClo').addClass('d-none');
                $('.ttgMk').addClass('d-none');
                $('.konvAak').removeClass('d-none');
                $('.titleClo').text('Konversi AAK')
            } else {
                $('.penClo').addClass('d-none');
                $('.rangClo').addClass('d-none');
                $('.konvAak').addClass('d-none');
                $('.ttgMk').removeClass('d-none');
                $('.titleClo').text('Tentang Mata Kuliah')
            }
        })

        $('.rangAvgKvs').each(function (i, v) {

            var rangDataCl = $(this).data('cl');
            var getKvs = '';
            $('.penClo').find('table').find('tfoot').find('tr').find('.avgKvs').each(function () {
                var dataCl = $(this).data('cl');
                if (dataCl == rangDataCl) {
                    getKvs = $(this).text();
                }
            });

            $(this).text(getKvs);
        })

        $('.rangKet').each(function (i, v) {


            var getAvg = parseFloat($(this).prev().text());
            var getTargetClo = parseInt($(this).prev().prev().text());

            if (getAvg < getTargetClo) {
                $(this).text('Tidak Tercapai');
                sumNoCapai++;
            } else {
                $(this).text('Tercapai');
                sumCapai++;
            }

        })

        $('.rangJmlLulus').each(function (i, v) {
            var sum = 0;
            var dataCl = $(this).data('cl');
            $('.penClo').find('table').find('tbody').find('tr').find('.stsLulus').each(function () {
                if ($(this).data('cl') == dataCl) {
                    sum += +($(this).text() == 'L' ? 1 : 0);
                }

            })
            $(this).text(sum);
        })

        $('.rangJmlTl').each(function (i, v) {
            var sum = 0;
            var dataCl = $(this).data('cl');
            $('.penClo').find('table').find('tbody').find('tr').find('.stsLulus').each(function () {
                if ($(this).data('cl') == dataCl) {
                    sum += +($(this).text() == 'TL' ? 1 : 0);
                }

            })
            $(this).text(sum);
        })

        $('.bbtKonv').each(function (i, v) {

            var sum = 0;
            var dataJns = $(this).data('jns');

            $('.penClo').find('table').find('thead').find('tr').find('.bbtPen').each(function () {
                if ($(this).data('jns') == dataJns) {
                    sum += +parseFloat($(this).text());
                }
            })

            $(this).text(sum + '%');

        });

        $('.nilaiKonv').each(function (i, v) {

            var sum = 0;
            var dataJns = $(this).data('jns');
            var bobotJns = 0;
            var dataNim = $(this).data('nim');

            $('.penClo').find('table').find('tbody').find('tr').find('.nilai').each(function () {
                var bbt = $(this).closest('td').find('#bobot').val();
                var nim = $(this).closest('td').find('#nim').val();
                if ($(this).data('jns') == dataJns && nim == dataNim) {
                    sum += +parseFloat($(this).val() * bbt);
                }
            })

            $('.konvAak').find('table').find('thead').find('tr').find('.bbtKonv').each(function () {
                if ($(this).data('jns') == dataJns) {
                    bobotJns = parseFloat($(this).text().replace('%', ''));
                }

            })

            $(this).text((sum / bobotJns).toFixed(0));
        });

        $('.naAak').each(function (i, v) {
            var sum = 0;

            $(this).closest('tr').find('.nilaiKonv').each(function (j, v) {
                var bbt = parseFloat($(this).closest('table').find('thead').find('tr').find(
                    '.bbtKonv').eq(
                    j).text().replace('%', ''));

                sum += parseFloat($(this).text()) * bbt / 100;

            })
            $(this).text(Math.round(sum));
        })

        $('.nhAak').each(function (i, v) {

            var naAak = parseFloat($(this).prev().text());

            if (naAak < 40) {
                $(this).text('E');
            } else if (naAak >= 40 && naAak < 55) {
                $(this).text('D');

            } else if (naAak >= 55 && naAak < 60) {
                $(this).text('C');
            } else if (naAak >= 60 && naAak < 65) {
                $(this).text('C+');
            } else if (naAak >= 65 && naAak < 75) {
                $(this).text('B');
            } else if (naAak >= 75 && naAak < 80) {
                $(this).text('B+');
            } else if (naAak >= 80) {
                $(this).text('A');
            }

        })

        $('.stsLulusAak').each(function (i, v) {
            var naAak = parseFloat($(this).prev().prev().text());
            var nMin = $(".nilai_min_mk").text();
            if (naAak >= nMin) {
                $(this).text('L');
            } else {
                $(this).text('TL');
            }
        })

        $('.btnEditNilaiMk').click(function () {
            $('.btnSaveNilaiMk').removeClass('d-none');
            $(this).addClass('d-none');
        })


        $('.ttlCapai').text(sumCapai);
        $('.ttlNoCapai').text(sumNoCapai);

        $('.ttlMhsCapai').text(sumMhsCapai + ' Mahasiswa');
        $('.ttlMhsNoCapai').text(sumMhsNoCapai + ' Mahasiswa');

        $('.preCapai').text(Math.round(sumCapai / (sumCapai + sumNoCapai) * 100) + '%');
        $('.preNoCapai').text(Math.round(sumNoCapai / (sumCapai + sumNoCapai) * 100) + '%');

        $('.preMhsCapai').text(Math.round(sumMhsCapai / (sumMhsCapai + sumMhsNoCapai) * 100) + '%');

        $('.preMhsNoCapai').text(Math.round(sumMhsNoCapai / (sumMhsCapai + sumMhsNoCapai) * 100) + '%');

        const dataChart = {
            labels: ['Total CLO tercapai', 'Total CLO tidak tercapai', 'Total Mahasiswa tercapai',
                'Total Mahasiswa tidak tercapai'
            ],
            datasets: [{

                    backgroundColor: ['#9EA1D4', '#FD8A8A'],
                    data: [sumCapai, sumNoCapai]
                },
                {

                    backgroundColor: ['#86C8BC', '#65647C'],
                    data: [sumMhsCapai, sumMhsNoCapai]
                }
            ]
        }

        const config = {
            type: 'pie',
            data: dataChart,

            options: {
                title: {
                    display: true,
                    text: 'Grafik Ketercapaian CLO'
                },
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            generateLabels: function (chart) {
                                // Get the default label list
                                const original = Chart.overrides.pie.plugins.legend.labels
                                    .generateLabels;
                                const labelsOriginal = original.call(this, chart);

                                // Build an array of colors used in the datasets of the chart
                                let datasetColors = chart.data.datasets.map(function (e) {
                                    return e.backgroundColor;
                                });
                                datasetColors = datasetColors.flat();

                                // Modify the color and hide state of each label
                                labelsOriginal.forEach(label => {
                                    // There are twice as many labels as there are datasets. This converts the label index into the corresponding dataset index
                                    label.datasetIndex = (label.index - label.index % 2) / 2;

                                    // The hidden state must match the dataset's hidden state
                                    label.hidden = !chart.isDatasetVisible(label.datasetIndex);

                                    // Change the color to match the dataset
                                    label.fillStyle = datasetColors[label.index];
                                });

                                return labelsOriginal;
                            }
                        },
                        onClick: function (mouseEvent, legendItem, legend) {
                            // toggle the visibility of the dataset from what it currently is
                            legend.chart.getDatasetMeta(
                                legendItem.datasetIndex
                            ).hidden = legend.chart.isDatasetVisible(legendItem.datasetIndex);
                            legend.chart.update();
                        }

                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const labelIndex = (context.datasetIndex * 2) + context.dataIndex;
                                return context.chart.data.labels[labelIndex] + ': ' + context
                                    .formattedValue;
                            }
                        }
                    }
                }

            }
        }
        const cloChart = new Chart($('#cloChart'), config);

    })

    $('.btnSimpanNilai').on('click', function () {

        $.ajax({
            url: "{{ route('penilaian.clo.store') }}",
            type: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                'dataNilai': data,
                'idIns': "{{ $idIns }}",
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

                if (data.error) {

                    location.reload();

                } else {
                    Swal.fire({
                        position: 'middle',
                        icon: 'success',
                        title: data.success,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }

            }

        })
    })

    $('#tableIns').on('blur', '.nilai', function () {

        var temp = {
            'nim': $(this).closest('td').find('#nim').val(),
            'nilai': $(this).val(),
            'dtl_id': $(this).closest('td').find('#idDtlAgd').val()
        };

        data.forEach(element => {
            if (element.dtl_id == temp.dtl_id && element.nim == temp.nim) {
                data.splice(data.indexOf(element), 1);
            }

        });

        if (temp.nilai > 100 || temp.nilai < 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Nilai tidak boleh lebih dari 100 atau kurang dari 0',
            })
            $(this).val('');
        } else if (temp.nilai != '') {

            data.push(temp);
        }

        if (data.length > 0) {
            $('.btnSimpanNilai').removeAttr('disabled');
        } else {
            $('.btnSimpanNilai').attr('disabled', 'disabled');
        }

    })

    $('.btnSaveSum').on('click', function () {

        $.ajax({
            url: "{{ route('penilaian.storeSummary') }}",
            type: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                'dataSum': dataSummary,
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
                Swal.close();
                Swal.fire({
                    position: 'middle',
                    icon: 'success',
                    title: data.success,
                    showConfirmButton: false,
                    timer: 1500
                })
                setTimeout(() => {
                    location.reload();
                }, 1500);

            },

        })
    })

    $('#tableSummary').on('blur', '.csFail , .improvClo', function () {

        var temp = {
            'idClo': $(this).data('clo'),
            'idIns': $(this).data('ins'),
            'desc': $(this).val(),
            'sts': $(this).data('sts')

        };

        dataSummary.forEach(element => {
            if (element.idClo == temp.idClo && element.idIns == temp.idIns && element.sts == temp.sts) {
                dataSummary.splice(dataSummary.indexOf(element), 1);
            }

        });

        if (temp.desc != '') {
            dataSummary.push(temp);
        }

        if (dataSummary.length > 0) {
            $('.btnSaveSum').removeAttr('disabled');
        } else {
            $('.btnSaveSum').attr('disabled', 'disabled');
        }

    })

</script>
