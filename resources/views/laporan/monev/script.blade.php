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


    });

</script>
