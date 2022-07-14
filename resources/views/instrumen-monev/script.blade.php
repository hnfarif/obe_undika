<script>
    $(document).ready(function () {
        $('#tableMonev').DataTable({
            'responsive': true,
            'info': false,
            'paging': false,
            'searching': false,
            'ordering': false,

        });
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

        $('#tableKri').on('click', '.editKri', function () {
            var id = $(this).attr('data-id');

            $.ajax({
                url: "{{ route('monev.showCriteria') }}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {

                    $("#kri_id").val(data.id);
                    $("#kategori").val(data.kategori);
                    $("#kriteria_penilaian").val(data.kri_penilaian);
                    $("#bobot").val(data.bobot);
                    $("#deskripsi").val(data.deskripsi);
                }
            })
        })
        $('#tableKri').on('click', '.delKri', function (e) {

            var form = $(this).closest('form');
            var name = $(this).data('name');
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Kamu tidak dapat mengembalikan data yang sudah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6777ef',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.value) {
                    form.submit();
                }

            })


        })

    })

</script>
