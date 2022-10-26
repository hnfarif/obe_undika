@extends('layouts.main')
@section('peoplo', 'active')
@section('step3', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">

            @if (auth()->user()->role == 'kaprodi')

            @include('kelolapeoplo.role.mapping.prodi')

            @elseif (auth()->user()->role == 'dosen')

            @include('kelolapeoplo.role.mapping.dosen')

            @endif


        </section>
    </div>
    @include('layouts.footer')
</div>

@endsection
@push('script')
<script>
    $(document).ready(function () {

        $('#tableMap').DataTable({
            'lengthMenu': [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"]
            ],
        });
        $('#tableMatriks').DataTable({
            "scrollX": true,
            "responsive": true,
            "autoWidth": false,
            "info": false,
            "paging": false,
            "searching": false,
            "ordering": false,

        });

        $('#tableMap').on('click', '.deletePeoplo', function (e) {

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
