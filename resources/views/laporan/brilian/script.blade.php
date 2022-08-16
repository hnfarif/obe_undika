<script>
    $(document).ready(function () {
        const tabelBrilian = $('#lapBrilian').DataTable({
            responsive: true,
            autoWidth: false,
        });



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

    });

</script>
