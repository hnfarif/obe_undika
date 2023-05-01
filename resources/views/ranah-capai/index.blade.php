@extends('layouts.main')
@section('ranahcapai', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $errors->first() }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sukses!</strong> {{ session()->get('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Ranah Capaian</h4>
                                <div class="card-header-action">
                                    <button class="btn btn-success" data-toggle="modal" data-target="#imporData">
                                        <i class="fas fa-file-excel"></i> Tambah Ranah Capaian
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="tableRanah">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    Kode
                                                </th>
                                                <th>Nama Ranah Capaian</th>
                                                <th>Inisial</th>
                                                <th>Deskripsi</th>
                                                <th>Level</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ranah as $r)
                                            <tr>
                                                <td class="text-center">{{ $r->kode }}</td>
                                                <td>{{ $r->nama }}</td>
                                                <td>{{ $r->inisial }}</td>
                                                <td>{{ $r->deskripsi }}</td>
                                                <td>
                                                    @foreach ($r->level as $l)
                                                    <div class="pb-1">
                                                        <button
                                                            class="btn btn-info text-left dtlLevel">{{ $l->kode_level.' - '.$l->nama }}
                                                        </button>
                                                        <div class="d-none" id="dataKko">
                                                            <table class="table table-bordered">
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Kata</th>
                                                                </tr>
                                                                @foreach ($l->kko as $k)
                                                                <tr>
                                                                    <td>
                                                                        {{ $k->no }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $k->kata }}
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </table>
                                                        </div>
                                                    </div>
                                                    @endforeach
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
            </div>
        </section>
    </div>
    @include('layouts.footer')
</div>
@include('ranah-capai.modal')
@endsection
@push('script')
<script>
    $(document).ready(function () {

        $('#tableRanah').DataTable({
            "language": {
                "emptyTable": "Tidak ada data"
            }
        });
        $('#tableRanah').on('click', '.dtlLevel', function () {
            var kko = $(this).next().html();
            $("#showKko").html(kko);
            $("#modalKko").modal('show');
        });
    });

</script>
@endpush
