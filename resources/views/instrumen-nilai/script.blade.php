<script src="{{ asset('assets/js/chart.js') }}" type="text/javascript"></script>
<script>
    $("#tableJdw").DataTable();

    $(document).ready(function () {

        var filter = {};

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

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Total MK tidak tercapai", "Total MK tercapai"],
                datasets: [{
                    label: 'Total Mata Kuliah',
                    data: [],
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
        });

        $('#filDataCapaiClo').on('click', function () {
            $('#filInsClo').modal('hide');
            filter = {
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
                data: {
                    'fakultas': filter ? filter.fakultas : '',
                    'prodi': filter ? filter.prodi : '',
                },
                beforeSend: function () {
                    swal.fire({
                        title: 'Mohon Tunggu',
                        html: 'Sedang memuat Grafik',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading()
                        }
                    });
                },
                success: function (data) {
                    if ($.isEmptyObject(data.error)) {
                        swal.close();
                        myChart.data.datasets[0].data = [data.jmlInsTdkLulus, data.jmlInsLulus];
                        myChart.update();

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
