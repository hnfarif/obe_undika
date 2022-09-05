@extends('layouts.main')
@section('rps', 'active')
@section('step1', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">
            <div class="section-body">

                @if (auth()->user()->role == 'dosen')
                @include('rps.role.dosen')
                @else
                @include('rps.role.another')
                @endif

            </div>


        </section>
    </div>
    @include('layouts.footer')
</div>


@include('rps.modal')
@endsection
@push('script')

<script>
    $(document).ready(function () {
        $('#table').DataTable();
        $('.editRps').on('click', function () {
            var id = $(this).attr('data-id');

            $.ajax({
                url: "{{ route('rps.edit') }}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    console.log(data);
                    $(".titleRps").html("Ubah Data RPS " + data.nama_mk);
                    $("#rps").val(data.id);
                    $("#rumpun_mk").val(data.rumpun_mk);
                    $('#ketua_rumpun').children("option").each(function () {
                        if ($(this).val() == data.nik) {
                            $(this).remove();
                            $('#ketua_rumpun').prepend(
                                `<option selected value="${data.nik}">${data.karyawan.nama}</option>`
                            );
                        }
                    });
                    $("#semester").val(data.semester);
                    $('#sts_aktif').children("option").each(function () {
                        if ($(this).val() == data.is_active) {
                            $(this).remove();
                            if (data.is_active == 1) {
                                $('#sts_aktif').prepend(
                                    `<option selected value="${data.is_active}">Ya</option>`
                                );
                            } else {
                                $('#sts_aktif').prepend(
                                    `<option selected value="${data.is_active}">Tidak</option>`
                                );
                            }
                        }
                    });
                    // $("#deskripsi").val(data.deskripsi);
                }
            })
        })

        var chkSmt = [];
        var dataSmt = [];


        $('.dataSmt').each(function () {
            dataSmt.push($(this).val());

        })

        $('.saveRps').on('click', function () {
            var id = $(this).attr('data-id');
            Swal.fire({
                title: 'Perhatian',
                text: "Pastikan file yang akan diupload sudah benar, file tidak dapat diubah lagi",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!'
            }).then((result) => {
                if (result.value) {
                    $('#saveRps').modal('show');
                    $('#mrps_id').val(id);
                }
            })
        })
    });

</script>

@endpush
