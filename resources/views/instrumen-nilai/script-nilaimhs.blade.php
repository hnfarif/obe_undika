<script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
<script>
    var data = Array();

    $(document).ready(function () {
        $('#tableIns').DataTable({
            paging: false,
            searching: false,
            info: false,
            scrollCollapse: true,
            scroller: true,
            select: true,
            fixedColumns: {
                left: 2
            }
        });


    })

    $('.btnSimpanNilai').on('click', function () {

        $.ajax({
            url: "{{ route('penilaian.clo.store') }}",
            type: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                'dataNilai': data,
                'idIns': "{{ $idIns }}"
            },
            success: function (data) {
                Swal.fire({
                    title: 'Berhasil',
                    text: data.success,
                    type: 'success',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    if (result.value) {
                        location.reload();
                    }
                })
            }

        })
    })

    $('#tableIns').on('blur', '.nilai', function () {

        var temp = {
            'nim': $(this).closest('td').find('#nim').val(),
            'nilai': $(this).val(),
            'dtl_id': $(this).closest('td').find('#idDtlAgd').val()
        };

        data.forEach(element => {
            if (element.dtl_id == temp.dtl_id && element.nim == temp.nim) {
                data.splice(data.indexOf(element), 1);
            }

        });

        if (temp.nilai > 100) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Nilai tidak boleh lebih dari 100',
            })
            $(this).val('');
        } else if (temp.nilai != '') {

            data.push(temp);
        }

        if (data.length > 0) {
            $('.btnSimpanNilai').removeAttr('disabled');
        } else {
            $('.btnSimpanNilai').attr('disabled', 'disabled');
        }

        console.log(data);
    })

</script>
