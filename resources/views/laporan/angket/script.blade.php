<script src="{{ asset('assets/js/chart.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        const tabelAngket = $('#lapAngket').DataTable({
            responsive: true,
            autoWidth: false,
            columnDefs: [{
                targets: [0, 1, 3],
                className: 'text-center'
            }],

        });

        $('input[type=radio][name=optlaporan]').change(function () {
            if ($(this).val() == 'angket') {
                $('.angket').removeClass('d-none');
                $('.rangkuman').addClass('d-none');
            } else if ($(this).val() == 'rangkuman') {
                $('.rangkuman').removeClass('d-none');
                $('.angket').addClass('d-none');

            }
        })

        var ctx_pro = document.getElementById('rata_prodi').getContext('2d');
        var ctx_fak = document.getElementById('rata_fak').getContext('2d');

        var chartProdi = new Chart(ctx_pro, {
            type: 'bar',
            data: {
                labels: JSON.parse('@json($rata_prodi->pluck("nama")->toArray())'),
                datasets: [{
                    label: 'Total Mata Kuliah',
                    data: JSON.parse('@json($rata_prodi->pluck("rata")->toArray())'),
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
                labels: JSON.parse('@json($rata_fak->pluck("nama")->toArray())'),
                datasets: [{
                    label: 'Total Mata Kuliah',
                    data: JSON.parse('@json($rata_fak->pluck("rata")->toArray())'),
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
