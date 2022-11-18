<script>
    $("#tableJdw").DataTable();
    $('input[type=radio][name=optrangclo]').change(function () {
        if ($(this).val() == 'insTdkTercapai') {
            $('.insTdkTercapai').removeClass('d-none');
            $('.insTercapai').addClass('d-none');
        } else if ($(this).val() == 'insTercapai') {
            $('.insTercapai').removeClass('d-none');
            $('.insTdkTercapai').addClass('d-none');

        }
    })

</script>
