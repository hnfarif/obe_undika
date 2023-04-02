<script>
    $('.transAgd').on('click', async function () {
        var sts = $(this).data('sts');

        if (sts == '1') {
            const confirmed = await showAlert('Ubah RPS?',
                'Jika RPS akan diubah maka status RPS dinyatakan belum selesai dan RPS tidak dapat dipakai untuk penilaian CLO selama status RPS masih dalam proses perubahan',
                'warning', 'Ya, Ubah RPS!')
            if (confirmed) {
                var result = await changeStatus(sts, "{{ $rps->id }}");
            }
        } else {
            const confirmed = await showAlert('Perhatian!',
                'Pastikan Agenda Pembelajaran sudah selesai, karena data akan digunakan untuk Penilaian CLO!',
                'warning', 'Ya, Selesaikan RPS!')

            if (confirmed) {
                var result = await changeStatus(sts, "{{ $rps->id }}");
            }
        }
    })

    async function showAlert(title, text, icon, confirmButtonText) {
        const result = await Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmButtonText,
        })
        return result.value;
    }

    async function changeStatus(sts, rps_id) {
        var dataAjax = [];
        $.ajax({
            url: "{{ route('rps.transferAgenda') }}",
            type: "PUT",
            dataType: "JSON",
            data: {
                '_token': "{{ csrf_token() }}",
                'is_done': sts,
                'rps_id': rps_id,
            },
            success: function (data) {
                if (data.status == 'success') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 3000
                    })
                }
            }

        })
    }

</script>
