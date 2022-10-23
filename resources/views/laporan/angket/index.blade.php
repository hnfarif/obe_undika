@extends('layouts.main')
@section('laporan', 'active')
@section('angket', 'active')
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
                <div class="d-flex align-items-center my-0">
                    <div class="ml-auto">
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="optlaporan" value="angket" class="selectgroup-input"
                                    checked="">
                                <span class="selectgroup-button">Daftar Angket</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="optlaporan" value="rangkuman" class="selectgroup-input">
                                <span class="selectgroup-button">Rangkuman</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row angket">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Angket</h4>

                                <a target="_blank"
                                    href="{{ route('laporan.angket.exportPdf', ['fakultas' => request('fakultas'), 'prodi' => request('prodi'), 'dosen' => request('dosen') ]) }}"
                                    class="btn btn-danger ml-auto mr-3">
                                    <i class="fas fa-file-pdf"></i> Export PDF </a>
                                <button class="btn btn-primary " data-toggle="modal" data-target="#filterAngket">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="lapAngket" width="100%">
                                        <thead>
                                            <tr class="text-center">
                                                <th>NIK</th>
                                                <th>Nama Dosen</th>
                                                <th>Kode MK</th>
                                                <th>Nama MK</th>
                                                <th>Kelas</th>
                                                <th>Rata-rata</th>
                                                <th>Rata-rata Dosen</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            @foreach ($angket as $key => $fa)
                                            <tr>
                                                <td>{{ $key }}</td>
                                                <td>{{ $fa['nama'] }}</td>
                                                <td>
                                                    @foreach ($fa['matakuliah'] as $keymk => $mk)
                                                    {!! $keymk.'<br>' !!}
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($fa['matakuliah'] as $keymk => $mk)

                                                    @foreach ($mk as $keykelas => $kelas )

                                                    {!! $kelas['nama'].'<br>' !!}

                                                    @endforeach
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($fa['matakuliah'] as $keymk => $mk)

                                                    @foreach ($mk as $keykelas => $kelas )

                                                    {!! $keykelas.'<br>' !!}

                                                    @endforeach
                                                    @endforeach
                                                </td>
                                                <td>

                                                    @foreach ($fa['matakuliah'] as $keymk => $mk)

                                                    @foreach ($mk as $keykelas => $kelas )

                                                    {!! number_format($kelas['rata_mk'],2).'<br>' !!}

                                                    @endforeach
                                                    @endforeach

                                                </td>
                                                <td>{{ $fa['rata_dosen'] }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row rangkuman d-none">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Rata-Rata Angket Dosen</h4>

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" width="100%">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Fakultas</th>
                                                <th>Program Studi</th>
                                                <th>Rata-Rata Prodi</th>
                                                <th>Rata-Rata Fakultas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($fak as $f)
                                            <tr>

                                                <td>{{ $f->nama }}</td>
                                                <td>
                                                    @foreach ($f->prodis as $p )
                                                    <div class="my-3">

                                                        {{ $p->nama.' ('.$p->id.')' }}
                                                    </div>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($f->prodis as $p )
                                                    <div class="text-center my-3">

                                                        @if (isset($rataProdi[$p->id]))

                                                        {{ $rataProdi[$p->id]['rata_prodi'] }}

                                                        @endif
                                                    </div>
                                                    @endforeach
                                                </td>
                                                <td class="text-center">
                                                    @if (isset($rataFak[$f->id]))

                                                    {{ $rataFak[$f->id]['rata_fakultas'] }}

                                                    @endif
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
@include('laporan.angket.modal-angket')
@endsection
@push('script')
@include('laporan.angket.script')
@endpush
