<script src="{{ asset('assets/js/chart.js') }}" type="text/javascript"></script>
<script>
    $("#tableJdw").DataTable();

    $(document).ready(function () {

        $(".btnUbahNilai").on('click', function () {

            $.ajax({
                url: "{{  route('penilaian.cekrps') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    'kode_mk': $(this).data('mk'),
                    'nik': $(this).data('nik'),
                    'kelas': $(this).data('kelas'),
                },
                success: function (data) {
                    if ($.isEmptyObject(data.error)) {
                        window.location.href = data.url;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops, Ada yang salah!',
                            text: data.error,
                        })

                    }
                }

            })
        })
        var ctx = document.getElementById('grangclo').getContext('2d');

        $('#filDataCapaiClo').on('click', function () {
            $('#filInsClo').modal('hide');
            var filter = {
                "fakultas": $("input[name='fakultas[]']").map(function () {
                    if ($(this).is(':checked')) {
                        return $(this).val();
                    }
                }).get(),
                "prodi": $("input[name='prodi[]']").map(function () {
                    if ($(this).is(':checked')) {
                        return $(this).val();
                    }
                }).get(),
            }
            loadGrafik(filter);
        })

        loadGrafik();

        function loadGrafik(filter) {

            $.ajax({
                url: "{{ route('penilaian.rangkumCapaiClo') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    'fakultas': filter ? filter.fakultas : '',
                    'prodi': filter ? filter.prodi : '',
                },
                beforeSend: function () {
                    $('.loadGrafik').html(
                        '<div class="text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i> Harap tunggu sebentar, sedang memuat grafik ...</div>'
                    );
                },
                success: function (data) {
                    if ($.isEmptyObject(data.error)) {
                        $('.loadGrafik').html('');
                        var config = {
                            type: 'bar',
                            data: {
                                labels: ["Total MK tidak tercapai", "Total MK tercapai"],
                                datasets: [{
                                    label: 'Total Mata Kuliah',
                                    data: [data.jmlInsTdkLulus, data.jmlInsLulus],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }

                                },
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                }
                            }
                        }

                        var myChart = new Chart(ctx, config);

                        if (filter) {
                            myChart.destroy();
                            myChart = new Chart(ctx, config);
                        }

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops, Ada yang salah!',
                            text: 'Terjadi kesalahan saat mengambil data',
                        })

                    }
                },
            })
        }
    });

</script>
