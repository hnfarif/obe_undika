<script>
    $(document).ready(function () {
        var plotMonev = $('#tableMonev').DataTable();

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

        $('#btnPlot').on('click', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('monev.checkCriteria') }}",
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    if (data.status) {
                        window.location.href = "{{ route('monev.plotting.create') }}";
                    } else {
                        Swal.fire({
                            title: 'Ups, Ada yang salah!',
                            text: "Bobot Kriteria Peniliaian belum mencapai 100%, harap periksa kembali!",
                            icon: 'error',
                            confirmButtonText: 'Oke'
                        })
                    }
                }
            })
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
