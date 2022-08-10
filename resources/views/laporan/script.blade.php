<script>
    $(document).ready(function () {
        const tabelMonev = $('#lapMonev').DataTable({
            responsive: true,
            autoWidth: false,
        });

        var tabelFilDosen = $('#tabelFilDosen').DataTable({
            "drawCallback": function () {
                $(this.api().table().header()).hide();

            },
            responsive: true,
            autoWidth: false,
            'pageLength': 5,
            'searching': true,
            'paging': true,
            'info': false,
            'lengthChange': false,

        });


        tabelMonev.rows().every(function () {
            const node = this.node();
            var kri3 = parseFloat($(node).find('td:last').prev().text());
            var kri2 = parseFloat($(node).find('td:last').prev().prev().text());
            var kri1 = parseFloat($(node).find('td:last').prev().prev().prev().text());

            var bbt3 = parseFloat($(node).find('td:last').prev().data('bbt') / 100);
            var bbt2 = parseFloat($(node).find('td:last').prev().prev().data('bbt') / 100);
            var bbt1 = parseFloat($(node).find('td:last').prev().prev().prev().data('bbt') / 100);

            var na = (kri3 * bbt3) + (kri2 * bbt2) + (kri1 * bbt1);
            $(node).find('td:last').text(na.toFixed(2));

        });

        tabelFilDosen.rows().every(function () {
            const node = this.node();
            var data = @json(request('dosen'));
            var val = $(node).find('td:first').find('input').val();

            if (data && data.includes(val)) {
                $(node).find('td:first').find('input').prop('checked', true);
            }

        })

        $('input[type=radio][name=optlaporan]').change(function () {
            if ($(this).val() == 'monev') {
                $('.monev').removeClass('d-none');
                $('.rangkuman').addClass('d-none');
            } else if ($(this).val() == 'rangkuman') {
                $('.rangkuman').removeClass('d-none');
                $('.monev').addClass('d-none');

            }
        })

        $('.avgMonev').each(function () {
            var id = $(this).data('prodi');
            var count = 0;
            var sum = 0;
            tabelMonev.rows().every(function () {
                const node = this.node();
                var na = parseFloat($(node).find('td:last').text());
                var prodi = $(node).find('td:last').prev().data('prodi');

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
