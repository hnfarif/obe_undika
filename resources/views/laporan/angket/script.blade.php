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

    });

</script>
