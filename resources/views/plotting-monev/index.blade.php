@extends('layouts.main')
@section('plottingmonev', 'active')
@section('', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">

            <div class="section-body">
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    1
                                                </td>
                                                <td>35533</td>
                                                <td>Teknologi Big Data</td>
                                                <td>
                                                    7
                                                </td>
                                                <td>
                                                    3
                                                </td>
                                                <td>
                                                    3
                                                </td>
                                                <td><a href="" class="btn btn-light">Lihat</a>
                                                </td>
                                            </tr>

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
