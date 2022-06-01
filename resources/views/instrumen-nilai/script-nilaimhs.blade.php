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

        $('.ttlClo').each(function (i, v) {
            var sum = 0;
            var dataCl = $(this).data('cl');
            $(this).prevAll('td').find('.nilai').each(function () {
                var bbt = $(this).closest('td').find('#bobot').val();
                if ($(this).data('cl') == dataCl) {
                    sum += +($(this).val() * (bbt / 100));
                }
            });
            $(this).text(sum);
        });

        $('.nKvs').each(function (i, v) {

            var sumBbt = $(this).data('sumbobot');
            var ttlClo = parseFloat($(this).prev().text());
            if (sumBbt == 0) {
                sumBbt = 1;
            }
            var nKvs = (ttlClo / sumBbt) * 100;
            $(this).text(nKvs.toFixed(2));
        });

        $('.stsLulus').each(function (i, v) {
            var nilaiMin = $(this).data('nilaimin');
            var nKvs = parseFloat($(this).prev().text());
            if (nKvs >= nilaiMin) {
                $(this).text('L');
            } else {
                $(this).text('TL');
            }
        });

        $('.avgTtl').each(function (i, v) {
            var arr = [];
            var sum = 0;
            var dataCl = $(this).data('cl');
            $(this).closest('table').find('tbody').find('tr').find('.ttlClo').each(function () {
                var dataCl2 = $(this).data('cl');
                if (dataCl == dataCl2) {
                    arr.push(parseFloat($(this).text()));
                }
            });

            for (var number of arr) {
                sum += number;
            }

            var avg = sum / arr.length;
            $(this).text(avg.toFixed(2));
        })
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
                    position: 'top-end',
                    icon: 'success',
                    title: data.success,
                    showConfirmButton: false,
                    timer: 1500
                })
                setTimeout(() => {
                    location.reload();
                }, 1500);
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

        if (temp.nilai > 100 || temp.nilai < 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Nilai tidak boleh lebih dari 100 atau kurang dari 0',
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
