<script src="{{ asset('assets/js/intro.js') }}"></script>
<script>
    $(document).ready(function () {

        var tableMonev = $('#tableMonev').DataTable({
            columnDefs: [{
                orderable: false,
                targets: 9
            }],
        });

        $('#introClo').click(function () {
            introJs().setOptions({
                steps: [{
                        intro: "Selamat datang di Form Entri Plotting Monev!",
                        title: "Hi there!",
                    },
                    {
                        element: document.querySelector('.intro-1'),
                        intro: "Pilih Dosen yang melakukan monev!",
                    },
                    {
                        element: document.querySelector('.intro-2'),
                        intro: "Pada tabel ini berisi data mata kuliah yang memiliki RPS yang sudah diselesaikan. Untuk memilih data, tekan checkbox pada bagian kolom paling kanan!",
                    },
                    {
                        element: document.querySelector('.intro-3'),
                        intro: "Jika sudah selesai, tekan tombol ini untuk menyimpan data!",
                    },

                ],
            }).start();
        })

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
