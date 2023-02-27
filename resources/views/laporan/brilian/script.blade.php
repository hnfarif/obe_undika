<script src="{{ asset('assets/js/chart.js') }}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script>
    $(document).ready(function () {
        const tabelBrilian = $('#lapBrilian').DataTable({
            responsive: true,
            autoWidth: false,
        });

        $('input[type=radio][name=optlaporan]').change(function () {
            if ($(this).val() == 'brilian') {
                $('.brilian').removeClass('d-none');
                $('.rangkuman').addClass('d-none');
            } else if ($(this).val() == 'rangkuman') {
                $('.rangkuman').removeClass('d-none');
                $('.brilian').addClass('d-none');

            }
        })

        $('.avgBrilian').each(function () {
            var id = $(this).data('prodi');
            var count = 0;
            var sum = 0;
            tabelBrilian.rows().every(function () {
                const node = this.node();
                var na = parseFloat($(node).find('td:last').text());
                var prodi = $(node).find('td:last').data('prodi');

                if (prodi == id) {
                    count++;
                    sum += na;
                }

            })
            var avg = sum / count;
            $(this).text(avg.toFixed(2));

        })

        tabelBrilian.rows().every(function () {
            const node = this.node();
            var skor = parseFloat($(node).find('td:last').prev().text());
            if (skor < 2.5) {
                $(node).find('td:last').text('Bronze');
            } else if (skor >= 2.5 && skor < 3.0) {
                $(node).find('td:last').text('Silver');
            } else if (skor >= 3.0 && skor < 3.5) {
                $(node).find('td:last').text('Gold');
            } else if (skor >= 3.5) {
                $(node).find('td:last').text('Diamond');
            }

        });

        const badges = @json($rangBadge);
        const labelBdg = badges.map(item => item.nama).flat();
        var ctx_pro = document.getElementById('bdgSumPro').getContext('2d');
        var ctx_nilai = document.getElementById('bdgNilai').getContext('2d');

        var chartSumPro = new Chart(ctx_pro, {
            type: 'pie',
            data: {
                labels: labelBdg,
                datasets: [{
                    label: 'Jumlah Badge',
                    data: badges.map(item => item.jumlah).flat(),
                    backgroundColor: [
                        'rgba(148, 93, 65, 0.2)',
                        'rgba(192, 192, 192, 0.2)',
                        'rgba(255, 215, 0, 0.2)',
                        'rgba(112, 209, 244, 0.2)',
                    ],
                    hoverBackgroundColor: [
                        'rgba(148, 93, 65, 0.5)',
                        'rgba(192, 192, 192, 0.5)',
                        'rgba(255, 215, 0, 0.5)',
                        'rgba(112, 209, 244, 0.5)',
                    ],
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        display: true,
                        color: 'black',
                        font: {
                            weight: 'bold',
                            size: 14,
                        },
                        formatter: function (value, context) {
                            return context.chart.data.labels[context.dataIndex];
                        }
                    }
                },
            }

        });

        var chartNilai = new Chart(ctx_nilai, {
            type: 'bar',
            data: {
                labels: labelBdg,
                datasets: [{
                    label: 'Nilai Badges',
                    data: badges.map(item => item.avg).flat(),
                    backgroundColor: [
                        'rgba(148, 93, 65, 0.2)',
                        'rgba(192, 192, 192, 0.2)',
                        'rgba(255, 215, 0, 0.2)',
                        'rgba(112, 209, 244, 0.2)',
                    ],
                    borderColor: [
                        'rgba(148, 93, 65, 1)',
                        'rgba(192, 192, 192, 1)',
                        'rgba(255, 215, 0, 1)',
                        'rgba(112, 209, 244, 1)',
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
