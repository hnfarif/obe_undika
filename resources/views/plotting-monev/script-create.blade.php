<script>
    $(document).ready(function () {

        var tableMonev = $('#tableMonev').DataTable({
            "searching": false,
            'paging': true,
            'info': false,
            'ordering': true,
            processing: true,
            serverSide: false,
            ajax: {
                "url": "{{ route('monev.listMonev') }}",
                "data": {
                    'nikAdm': '{{ Auth::user()->nik }}'
                }
            },
            columns: [{
                    data: "mkName",
                    name: "mkName"
                },
                {
                    data: "nameDosPeng",
                    name: "nameDosPeng"
                },
                {
                    data: "aksi",
                    name: "aksi"
                },
            ],
            createdRow: function (row, data, dataIndex) {
                // Set the data-status attribute, and add a class
                $(row).find('td:eq(0)').attr('style', 'width:350px;');
            }

        })

        $('#btnAddDosen').click(function () {

            $.ajax({
                url: "{{ route('monev.addDosen') }}",
                type: "GET",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'nikAdmin': "{{ Auth::user()->nik }}",
                    'dosPeng': $('#dosen_pengajar').val(),
                    'nameDosPeng': $('#dosen_pengajar').find(':selected').data('karyname'),
                    'mkId': $('#dosen_pengajar').find(':selected').data('klkl'),
                    'mkName': $('#dosen_pengajar').find(':selected').data('namamk'),
                },
                success: function (data) {

                    if ($.isEmptyObject(data.error)) {
                        tableMonev.ajax.reload();
                    } else {
                        data.error.forEach(element => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops, Terdapat Data yang kosong!',
                                text: 'Isi dahulu data Dosen Pengajar',
                            })
                        });
                    }
                }
            })
        })

        $('#tableMonev').on('click', '.delMonev', function () {

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
                    $.ajax({
                        url: "{{ route('monev.deleteMonev') }}",
                        type: "GET",
                        dataType: "JSON",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'nikAdmin': "{{ Auth::user()->nik }}",
                            'nik': $(this).data('nik'),
                            'mk': $(this).data('mk'),

                        },
                        success: function (data) {
                            tableMonev.ajax.reload();
                        }

                    })
                }

            })
        })
    })

</script>
