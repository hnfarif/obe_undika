<script src="{{ asset('assets/js/intro.js') }}"></script>
@include('rps.script')
<script>
    $(document).ready(function () {
        $('#table').DataTable({
            "ordering": true,
            "paging": true,
            "info": false,
            "searching": true,
            "showNEntries": false,
            "lengthChange": false,

        });

        $('#table').on('click', '.editPenilaian', function () {
            var id = $(this).attr('data-id');

            $.ajax({
                url: "{{ route('penilaian.edit') }}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    $("#id").val(data.id);
                    $("#btk_penilaian").val(data.btk_penilaian);
                    $('#jenis').children("option").each(function () {
                        if ($(this).val() == data.jenis) {
                            $(this).remove();
                            $('#jenis').prepend(
                                `<option selected value="${data.jenis}">${data.jenis}</option>`
                            );
                        }
                    });
                }
            })
        })

        $('#table').on('click', '.delPenilaian', function (e) {

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

        $('#introClo').click(function () {
            introJs().setOptions({
                steps: [{
                        intro: "Selamat datang di menu Penilaian, di menu ini Anda dapat mengelola data Penilaian apa saja yang digunakan selama perkuliahan. Data ini digunakan untuk menyusun agenda pembelajaran.",
                        title: "Hi there!",
                    },
                    {
                        element: document.querySelector('.intro-form'),
                        intro: "Form ini digunakan untuk menambahkan data bentuk penilaian yang diinginkan. Pastikan data yang diinputkan sudah sesuai!",
                    },
                    {
                        element: document.querySelector('.intro-data'),
                        intro: "Data yang telah ditambahkan akan ditampilkan pada tabel ini. Anda dapat mengedit dan menghapus data yang telah ditambahkan.",
                    },


                ],
            }).start();
        });
    })

</script>
