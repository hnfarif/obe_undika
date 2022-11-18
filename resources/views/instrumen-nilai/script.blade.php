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

        $('input[type=radio][name=optrangclo]').change(function () {
            if ($(this).val() == 'dafIns') {
                $('.dafIns').removeClass('d-none');
                $('.rangCapaiClo').addClass('d-none');
            } else if ($(this).val() == 'rangCapaiClo') {
                $('.dafIns').addClass('d-none');
                $('.rangCapaiClo').removeClass('d-none');

            }
        })

        var ctx = document.getElementById('grangclo').getContext('2d');
        $.ajax({
            url: "{{ route('penilaian.rangkumCapaiClo') }}",
            type: 'GET',
            dataType: 'json',
            beforeSend: function () {
                $('.loadGrafik').html(
                    '<div class="text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i> Harap tunggu sebentar ....</div>'
                );
            },
            success: function (data) {
                if ($.isEmptyObject(data.error)) {
                    $('.loadGrafik').html('');
                    const myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ["Total MK tidak tercapai", "Total MK tercapai"],
                            datasets: [{
                                    label: ['Total Mata Kuliah tidak tercapai'],
                                    data: [data.jmlInsTdkLulus],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',

                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',

                                    ],
                                    borderWidth: 1
                                },
                                {
                                    label: 'Total Mata Kuliah tercapai',
                                    data: [90],
                                    backgroundColor: [
                                        'rgba(54, 162, 235, 0.2)',
                                    ],
                                    borderColor: [
                                        'rgba(54, 162, 235, 1)',
                                    ],
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }

                            }
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops, Ada yang salah!',
                        text: 'Terjadi kesalahan saat mengambil data',
                    })

                }
            },
        })

    });

</script>
