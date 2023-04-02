<script src="{{ asset('assets/js/intro.js') }}"></script>
@include('rps.script')
<script>
    $(document).ready(function () {
        var dataRanah = ["Kognitif", "Psikomotorik", "Afektif"];
        $('#tableClo').DataTable();

        $('#introClo').click(function () {
            introJs().setOptions({
                steps: [{
                        intro: "Selamat datang di halaman kelola RPS",
                        title: "Hi there!",
                    },
                    {
                        element: document.querySelector('.intro-1'),
                        intro: "Klik tombol ini untuk mengelola CLO. Harap susun CLO dahulu dan pastikan sudah sesuai, karena data CLO akan digunakan untuk menyusun agenda pembelajaran",
                    },
                    {
                        element: document.querySelector('.intro-2'),
                        intro: "Klik tombol ini untuk mengelola Penilaian. Pastikan data Penilaian sudah sesuai, karena data Penilaian akan digunakan untuk menyusun agenda pembelajaran",
                    },
                    {
                        element: document.querySelector('.intro-3'),
                        intro: "Klik tombol ini untuk mengelola Agenda Pembelajaran. Pastikan data Agenda Pembelajaran sudah sesuai tiap minggunya dan jumlah keseluruhan bobot mencapai 100%, untuk melihatnya di menu Rangkuman ",
                    },
                    {
                        element: document.querySelector('.intro-4'),
                        intro: "Klik tombol ini untuk melihat Rangkuman. Rangkuman ini berisi data Agenda Pembelajaran yang sudah dirangkum",
                    },
                    {
                        element: document.querySelector('.intro-5'),
                        intro: "Klik tombol ini untuk menyelesaikan / Ubah RPS. Jika tombol ini berwarna kuning maka RPS belum selesai, jika tombol ini berwarna biru maka RPS sudah selesai dan tombol akan berubah menjadi tombol Ubah RPS",
                    },
                    {
                        element: document.querySelector('.intro-desc'),
                        intro: "Di halaman ini pada kolom Mata Kuliah. Anda dapat mengisi deskripsi mata kuliah",
                        position: 'right'
                    },
                    {
                        element: document.querySelector('.intro-clo'),
                        intro: "Di halaman ini pada kolom Tabel CLO. Anda dapat mengelola data CLO pada mata kuliah ini. Pastikan data CLO sudah sesuai agar dapat digunakan untuk menyusun agenda pembelajaran",
                    },

                ],
            }).start();
        })

        $('.btnUbah').click(function () {
            $('.form-control').removeAttr('readonly');
            $('.descMk').removeAttr('disabled');
            $('.btnSimpan').removeClass('d-none')
            $('.btnBatal').removeClass('d-none')
            $('.btnUbah').addClass('d-none')
            $('.descMk').focus();
        })


        $('.btnBatal').click(function () {
            location.reload();

        })

        $('#tableClo').on('click', '.editClo', function () {
            var id = $(this).attr('data-id');
            $(".optranah").html('');
            $(".inputtags").tagsinput('removeAll');
            $("#ploid").html('');
            $.ajax({
                url: "{{ route('clo.edit') }}",
                type: "GET",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function (data) {

                    $("#id").val(data.clo.id);
                    $("#rps").val(data.clo.rps_id);
                    $("#kode_clo").val(data.clo.kode_clo);
                    $("#deskripsi").val(data.clo.deskripsi);
                    $("#target_lulus").val(data.clo.tgt_lulus);
                    $("#nilai_min").val(data.clo.nilai_min);
                    let ranahArray = data.clo.ranah_capai.split(' ');
                    dataRanah.forEach(element => {
                        if (ranahArray.includes(element)) {

                            $(".optranah").append(
                                `<option selected value="${element}">${element}</option>`
                            );
                        } else {
                            $(".optranah").append(
                                `<option value="${element}">${element}</option>`
                            );
                        }
                    });
                    let bloomArray = data.clo.lvl_bloom.split(',');
                    bloomArray.forEach(element => {
                        $(".inputtags").tagsinput('add', element);

                    });

                    var plos = Array();

                    data.plo.forEach(element => {
                        plos.push(element.id);
                    });

                    data.allplo.forEach(element => {

                        if (plos.includes(element.id)) {
                            $("#ploid").append(
                                `<option selected value="${element.id}">${element.kode_plo} - ${element.deskripsi}</option>`
                            );
                        } else {
                            $("#ploid").append(
                                `<option value="${element.id}">${element.kode_plo} - ${element.deskripsi}</option>`
                            );
                        }
                    });


                }
            })
        })

        $('#tableClo').on('click', '.deletePlo', function (e) {

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
    });

</script>
