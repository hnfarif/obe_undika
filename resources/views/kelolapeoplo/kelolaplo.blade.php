@extends('layouts.main')
@section('peoplo', 'active')
@section('step2', 'active')
@section('content')
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
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Input PLO</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('peoplo.plo.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Kode PLO</label>
                                <input type="text" class="form-control @error('kode_plo') is-invalid @enderror"
                                    name="kode_plo" value="PLO-{{ $ite_padded }}" readonly>
                                @error('kode_plo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Deskripsi PLO</label>
                                <textarea id="" class="form-control  @error('desc_plo') is-invalid @enderror"
                                    name="desc_plo" style="height: 100px" required>{{ old('desc_plo') }}</textarea>
                                @error('desc_plo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Tambah PLO</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar PLO</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-responsive" id="tablePlo">
                            <thead>
                                <tr>

                                    <th>
                                        Kode PLO
                                    </th>
                                    <th>
                                        <div style="width: 300px">Deskripsi PLO</div>
                                    </th>
                                    <th>Aksi</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($plo as $i)

                                <tr>

                                    <td>{{ $i->kode_plo }}</td>
                                    <td>{{ $i->deskripsi }}</td>
                                    <td>
                                        <div class="d-flex my-auto">

                                            <a href="#" class="btn btn-light mr-2 editPlo" data-id="{{ $i->id }}"
                                                data-toggle="modal" data-target="#editPlo"><i class="fas fa-edit"></i>

                                            </a>
                                            <form class="@if($i->kode_plo !== $iteration)
                                                d-none
                                                @elseif(in_array($i->id, $peoplo))
                                                d-none
                                                @endif" action="{{ route('peoplo.plo.delete', $i->id) }}"
                                                method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <input name="_method" type="hidden" value="DELETE">
                                                <a href="#" class="btn btn-danger deletePlo"><i
                                                        class="fas fa-trash"></i>

                                                </a>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>


                    </div>
                </div>

            </div>
        </div>
    </div>


</section>
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
            "lengthMenu": [
                [3, 10, 20, -1],
                [3, 10, 20, "All"]
            ]
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
