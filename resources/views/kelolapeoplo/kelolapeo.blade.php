@extends('layouts.main')
@section('peoplo', 'active')
@section('step1', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">

            @include('kelolapeoplo.section-header')
            <div class="section-body">
                <div class="d-flex align-items-center my-0">
                    <h2 class="section-title">Kelola PEO</h2>

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
                                <h4>Input PEO</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('peoplo.peo.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Kode PEO</label>
                                        <input type="text" class="form-control @error('kode_peo') is-invalid @enderror"
                                            name="kode_peo" value="PEO-{{ $ite_padded }}" readonly>
                                        @error('kode_peo')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi PEO</label>
                                        <textarea id="" class="form-control  @error('desc_peo') is-invalid @enderror"
                                            name="desc_peo" style="height: 100px"
                                            required>{{ old('desc_peo') }}</textarea>
                                        @error('desc_peo')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Tambah PEO</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar PEO</h4>
                            </div>
                            <div class="card-body">

                                <table class="table table-striped table-responsive" id="tablePeo">
                                    <thead>
                                        <tr>

                                            <th>
                                                Kode PEO
                                            </th>
                                            <th>
                                                <div style="width: 300px">Deskripsi PEO</div>
                                            </th>
                                            <th>Aksi</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($peo as $i)

                                        <tr>

                                            <td>{{ $i->kode_peo }}</td>
                                            <td>{{ $i->deskripsi }}</td>
                                            <td>
                                                <div class="d-flex my-auto">

                                                    <a href="#" class="btn btn-light mr-2 editPeo"
                                                        data-id="{{ $i->id }}" data-toggle="modal"
                                                        data-target="#editPeo"><i class="fas fa-edit"></i>

                                                    </a>
                                                    <form class="@if($i->kode_peo !== $iteration)
                                                d-none
                                                @elseif(in_array($i->id, $peoplo))
                                                d-none
                                                @endif" action="{{ route('peoplo.peo.delete', $i->id) }}"
                                                        method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <a href="#" class="btn btn-danger deletePeo"><i
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
            "lengthMenu": [
                [3, 10, 20, -1],
                [3, 10, 20, "All"]
            ]
        });

        $('#tablePeo').on('click', '.editPeo', function () {
            var id = $(this).attr('data-id');

            $.ajax({
                url: "{{ route('peoplo.peo.edit') }}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    console.log(data);
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
