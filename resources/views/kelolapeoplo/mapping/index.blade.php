@extends('layouts.main')
@section('peoplo', 'active')
@section('step3', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">
            @include('kelolapeoplo.section-header')

            @if (in_array(auth()->user()->role, ['kaprodi', 'bagian']))
            @include('kelolapeoplo.RoleMapping.in-role')
            @else
            @include('kelolapeoplo.RoleMapping.out-role')

            @endif



        </section>
    </div>
    @include('layouts.footer')
</div>

@endsection
@push('script')
<script>
    $(document).ready(function () {

        $('#tableMap').DataTable();

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
