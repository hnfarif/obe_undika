@extends('layouts.main')
@section('laporan', 'active')
@section('monev', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">

            @include('laporan.section-header')
            <div class="section-body">
                @if (session()->has('message'))
                <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" role="alert">
                    {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Monev</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="lapMonev">
                                        <thead>
                                            <tr>
                                                <th class="text-center" rowspan="2">
                                                    No
                                                </th>
                                                <th rowspan="2">Nama MK</th>
                                                <th rowspan="2">Kelas</th>
                                                <th rowspan="2">Nama Dosen</th>
                                                @foreach ($kri as $k)
                                                <th>{{ 'Kriteria '.$loop->iteration }}</th>
                                                @endforeach
                                                <th rowspan="2">Nilai Akhir</th>
                                            </tr>
                                            <tr>
                                                @foreach ($kri as $k)
                                                <th>{{ $k->bobot.'%' }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($jdw as $j)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>{{ $j->getNameMataKuliah($j->klkl_id,$j->prodi) }}</td>
                                                <td>{{ $j->kelas }}</td>
                                                <td>{{ $j->karyawans->nama }}</td>
                                                @foreach ($kri as $k)
                                                @if ($loop->iteration == '1')
                                                <td>
                                                    {{ $k->getNilaiKri1($j->kary_nik,$j->klkl_id, $j->prodi, $k->id) }}
                                                </td>
                                                @else
                                                <td>
                                                    -
                                                </td>
                                                @endif

                                                @endforeach
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
@endsection
@push('script')
<script>
    $(document).ready(function () {
        $('#lapMonev').DataTable();
    });

</script>

@endpush
