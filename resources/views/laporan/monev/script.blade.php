<script src="{{ asset('assets/js/chart.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        const tabelMonev = $('#lapMonev').DataTable({
            responsive: true,
            autoWidth: false,
        });

        $('input[type=radio][name=optlaporan]').change(function () {
            if ($(this).val() == 'monev') {
                $('.monev').removeClass('d-none');
                $('.rangkuman').addClass('d-none');
            } else if ($(this).val() == 'rangkuman') {
                $('.rangkuman').removeClass('d-none');
                $('.monev').addClass('d-none');

            }
        })

        var ctx_pro = document.getElementById('rata_prodi').getContext('2d');
        var ctx_fak = document.getElementById('rata_fak').getContext('2d');

        var rata = @json($rata_fak);

        var chartProdi = new Chart(ctx_pro, {
            type: 'bar',
            data: {
                labels: rata.map(item => item.prodis.map(data => data.nama)).flat(),
                datasets: [{
                    label: 'Rata Monev Prodi',
                    data: rata.map(item => item.prodis.map(data => data.rata)).flat(),
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
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

        var chartFak = new Chart(ctx_fak, {
            type: 'bar',
            data: {
                labels: rata.map(item => item.nama).flat(),
                datasets: [{
                    label: 'Rata Monev Fakultas',
                    data: rata.map(item => item.rata).flat(),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
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

    });

</script>
