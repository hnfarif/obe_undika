<script>
    $(document).ready(function () {
        const tabelAngket = $('#lapAngket').DataTable({
            responsive: true,
            autoWidth: false,
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

        $('.avgAngket').each(function () {
            var id = $(this).data('prodi');
            var count = 0;
            var sum = 0;
            tabelAngket.rows().every(function () {
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
    });

</script>
