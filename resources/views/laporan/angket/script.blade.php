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

    });

</script>
