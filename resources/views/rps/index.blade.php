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
                    $('#selpenyusun').children("option").each(function () {
                        if ($(this).val() == data.nik) {
                            $(this).remove();
                            $('#selpenyusun').prepend(
                                `<option selected value="${data.nik}">${data.karyawan.nama}</option>`
                            );
                        }
                    });

                }
            })
        })
        $('.btnPenyusun').on('click', function () {
            var id = $(this).data('rps');
            $('#rpsId').val(id);

        })

        $('.selpenyusun').on('change', function () {
            var email = $(this).find(':selected').data('email');
            $('#emailPenyusun').val(email);
        })

        $('.saveRps').on('click', function () {
            var id = $(this).attr('data-id');
            Swal.fire({
                title: 'Perhatian',
                text: "Pastikan file yang akan diupload sudah benar!",
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

        $('.deleteRps').on('click', function (e) {
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

@endpush
