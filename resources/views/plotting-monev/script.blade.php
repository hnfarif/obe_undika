<script>
    $(document).ready(function () {
        $('#tableMonev').DataTable();
        $('#tableKri').DataTable({
            autoWidth: false,
        });

        $('input[type=radio][name=optvclo]').change(function () {
            if ($(this).val() == 'plot') {
                $('.plot').removeClass('d-none');
                $('.kriMon').addClass('d-none');
            } else if ($(this).val() == 'kriMon') {
                $('.kriMon').removeClass('d-none');
                $('.plot').addClass('d-none');

            }
        })

    })

</script>
