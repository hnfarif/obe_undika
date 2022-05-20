@extends('layouts.main')
@section('instrumen-nilai', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">

            {{-- @include('rps.section-header') --}}
            <div class="section-body">
                <div class="d-flex align-items-center my-0">
                    <h2 class="section-title">Instrumen Nilai Mahasiswa</h2>

                </div>
                {{-- <p class="section-lead">Masukkan, ubah data PEO </p> --}}

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Nilai Mahasiswa</h4>
                            </div>
                            <div class="card-body">

                                <table class="table table-striped table-responsive" width="100%">
                                    <thead>
                                        <tr>

                                            <th rowspan="3">NIM</th>
                                            <th rowspan="3">Nama Mahasiswa</th>
                                            @foreach ($clo as $c)

                                            <th colspan="{{ $penilaian->count() }}">{{ $c->kode_clo }}</th>
                                            <th rowspan="3" class="align-text-top">Total {{ $c->kode_clo }}</th>
                                            @endforeach

                                        </tr>
                                        <tr>
                                            @foreach ($clo as $c)
                                            @foreach ($penilaian as $p)
                                            <th>{{ $p->btk_penilaian }}</th>
                                            @endforeach
                                            @endforeach
                                        </tr>
                                        <tr>
                                            @foreach ($clo as $c)
                                            @foreach ($penilaian as $p)
                                            <th>{{ $p->jenis }}</th>
                                            @endforeach
                                            @endforeach

                                        </tr>

                                    </thead>
                                    <tbody>
                                        @foreach ($krs as $k)
                                        <tr>
                                            <td>{{ $k->mhs_nim }}</td>
                                            <td>{{ $k->mahasiswa->nama }}</td>
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
@endsection
@section('script')
<script src="{{ asset('assets/js/page/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/page/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
<script>
    $(document).ready(function () {
        // $('.table').DataTable();


    })

</script>
@endsection
