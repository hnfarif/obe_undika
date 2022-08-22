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

        $('.jmlBadges').each(function () {
            var sum = 0;
            var badges = $(this).prev().text();
            $('.badges').each(function () {
                var bdg = $(this).text();
                if (bdg == badges) {
                    sum++;
                }
            })
            $(this).text(sum);
        })

        $('.proBadges').each(function () {
            var sum = 0;
            var pro = 0;
            var jml = parseFloat($(this).prev().text());
            $('.badges').each(function () {
                sum++;
            })

            pro = jml / sum * 100;
            $(this).text(pro.toFixed(2));
        })

        $('.nilaiBadges').each(function () {
            var jmlNa = 0;
            var jmlBadges = parseFloat($(this).prev().prev().text());
            var badges = $(this).prev().prev().prev().text();
            $('.badges').each(function () {
                var bdg = $(this).text();
                if (bdg == badges) {
                    jmlNa += parseFloat($(this).prev().text());

                }
            })
            var nilai = jmlNa / jmlBadges;
            $(this).text(nilai.toFixed(2));
        })

        // $('.jmlKelas').each(function () {
        //     var sum = 0;
        //     var badges = $(this).data('badges');
        //     $('.badges').each(function () {
        //         var bdg = $(this).text();
        //         if (bdg == badges && ) {
        //             sum++;
        //         }
        //     })
        //     $(this).text(sum);
        // })
    });

</script>
