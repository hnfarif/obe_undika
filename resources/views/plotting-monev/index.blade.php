@extends('layouts.main')
@section('plottingmonev', 'active')
@section('', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">

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

                        <div class="my-3">
                            <a href="{{ route('monev.plotting.create') }}" type="button" class="btn btn-primary"><i
                                    class="fas fa-plus"></i> Entri
                                Plotting Monev</a>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar monev</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="tableMonev">
                                        <thead>
                                            <tr class="text-center">
                                                <th>
                                                    Prodi
                                                </th>
                                                <th>Kode MK</th>
                                                <th>Mata Kuliah</th>
                                                <th>Kelas</th>
                                                <th>NIK</th>
                                                <th>Nama Dosen</th>
                                                <th>Ruang</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($pltMnv as $m)
                                            <tr>
                                                <td>
                                                    {{ $m->prodi }}
                                                </td>
                                                <td>{{ $m->klkl_id }}</td>
                                                <td>{{ $m->getNameMataKuliah($m->klkl_id, $m->prodi) }}</td>
                                                <td>
                                                    {{ $m->getKelasRuang($m->klkl_id, $m->nik_pengajar)['kelas'] }}
                                                </td>
                                                <td>
                                                    {{ $m->nik_pengajar }}
                                                </td>
                                                <td>
                                                    {{ $m->getNameKary($m->nik_pengajar) }}
                                                </td>
                                                <td>
                                                    {{ $m->getKelasRuang($m->klkl_id, $m->nik_pengajar)['ruang'] }}
                                                </td>
                                                <td><a href="" class="btn btn-light">Lihat</a>
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
@endsection

@push('script')
@include('plotting-monev.script')
@endpush
