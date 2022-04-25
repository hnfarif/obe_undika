@extends('layouts.main')
@section('peoplo', 'active')
@section('step2', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">
            @include('kelolapeoplo.section-header')

            <div class="section-body">
                <div class="d-flex align-items-center my-0">
                    <h2 class="section-title">Kelola PLO</h2>

                </div>
                @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Sukses!</strong> {{ session()->get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @elseif (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal!</strong> {{ session()->get('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <div class="row">
                    @if (in_array(auth()->user()->role, ['kaprodi', 'bagian']))
                    @include('kelolapeoplo.RolePlo.in-role')
                    @else
                    @include('kelolapeoplo.RolePlo.out-role')
                    @endif
                </div>
            </div>


        </section>
    </div>
    @include('layouts.footer')
</div>

<div class="modal fade" role="dialog" id="editPlo">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah PLO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('peoplo.plo.update') }}" method="POST">
                    @method('put')
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label>Kode PLO</label>
                        <input type="text" class="form-control @error('kode_plo') is-invalid @enderror" name="kode_plo"
                            id="kode_plo" readonly>
                        @error('kode_plo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Deskripsi PLO</label>
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
        $('#tablePlo').DataTable({
            'autoWidth': false,
        });

        $('#tablePlo').on('click', '.editPlo', function () {
            var id = $(this).attr('data-id');

            $.ajax({
                url: "{{ route('peoplo.plo.edit') }}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    $("#id").val(data.id);
                    $("#kode_plo").val(data.kode_plo);
                    $("#deskripsi").val(data.deskripsi);
                }
            })
        })

        $('#tablePlo').on('click', '.deletePlo', function (e) {

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
