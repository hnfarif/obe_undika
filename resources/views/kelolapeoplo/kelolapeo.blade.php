@extends('layouts.main')
@section('peoplo', 'active')
@section('step1', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">
            @if (auth()->user()->role == 'kaprodi')

            @include('kelolapeoplo.role.peo.prodi')
            @elseif (auth()->user()->role == 'dosen')
            @include('kelolapeoplo.role.peo.dosen')
            @else

            @include('kelolapeoplo.role.peo.another')

            @endif

        </section>
    </div>
    @include('layouts.footer')
</div>
<div class="modal fade" role="dialog" id="editPeo">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah PEO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('peoplo.peo.update') }}" method="POST">
                    @method('put')
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label>Kode PEO</label>
                        <input type="text" class="form-control @error('kode_peo') is-invalid @enderror" name="kode_peo"
                            id="kode_peo" readonly>
                        @error('kode_peo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Deskripsi PEO</label>
                        <textarea class="form-control  @error('deskripsi') is-invalid @enderror" name="deskripsi"
                            id="deskripsi" style="height: 100px" required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('script')

<script>
    $(document).ready(function () {
        $('#tablePeo').DataTable({
            'autoWidth': false,
        });
        $('#tblProdi').DataTable({
            "autoWidth": false,
            "responsive": true,

        });

        $('#tablePeo').on('click', '.editPeo', function () {
            var id = $(this).attr('data-id');

            $.ajax({
                url: "{{ route('peoplo.peo.edit') }}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {

                    $("#id").val(data.id);
                    $("#kode_peo").val(data.kode_peo);
                    $("#deskripsi").val(data.deskripsi);
                }
            })
        })

        $('#tablePeo').on('click', '.deletePeo', function (e) {

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
    })

</script>

@endpush
