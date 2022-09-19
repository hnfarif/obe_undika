<script>
    $(document).ready(function () {

        var tableMonev = $('#tableMonev').DataTable({
            columnDefs: [{
                orderable: false,
                targets: 9
            }],
        });

        tableMonev.on('click', '.selectAll', function () {
            if (this.checked) {
                tableMonev.rows().nodes().to$().find('input[type="checkbox"]').each(function () {
                    this.checked = true;
                });


            } else {
                tableMonev.rows().nodes().to$().find('input[type="checkbox"]').each(function () {
                    this.checked = false;
                });
            }
        });

        $('.btnSave').on('click', function () {
            tableMonev.rows().nodes().to$().find('input[type="checkbox"]').each(function () {
                if (this.checked) {
                    $('#formPlotting').append('<input type="hidden" name="mk_monev[]" value="' +
                        this.value + '">');
                }
            });
            $('#formPlotting').submit();
        });

    })

</script>
