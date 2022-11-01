@extends('layouts.main')
@section('laporan', 'active')
@section('brilian', 'active')
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
                                <input type="radio" name="optlaporan" value="brilian" class="selectgroup-input"
                                    checked="">
                                <span class="selectgroup-button">Daftar Penggunaan Brilian</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="optlaporan" value="rangkuman" class="selectgroup-input">
                                <span class="selectgroup-button">Rangkuman</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row brilian">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Penggunaan Brilian</h4>
                                <a target="_blank"
                                    href="{{ route('laporan.brilian.exportPdf', ['prodi' => request('prodi')]) }}"
                                    class="btn btn-danger ml-auto  mr-3">
                                    <i class="fas fa-file-pdf"></i> Export PDF </a>
                                <form action="{{ route('laporan.brilian.store') }}" method="POST" class="mr-3">
                                    @csrf

                                    <input type="hidden" value="{{ $pekan->count() + 1 }}" name="minggu">
                                    <input type="hidden" value="{{ $smt }}" name="semester">
                                    <input type="hidden" name="data" value="{{ json_encode($data) }}">

                                    @if ($pekan->count() + 1 <= 16) <button class="btn btn-success" type="submit">
                                        <i class="fas fa-plus"></i> Tambah nilai minggu {{ $pekan->count() + 1 }}
                                        </button>

                                        @endif
                                </form>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#filterBrilian">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-responsive" id="lapBrilian" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center" rowspan="2">
                                                    Dosen
                                                </th>
                                                <th rowspan="2">Nama MK</th>
                                                <th rowspan="2">Kode MK</th>
                                                <th rowspan="2">Kelas</th>
                                                <th rowspan="2">Prodi</th>
                                                @foreach ($indikator as $i)
                                                <th colspan="2">{{ 'Kriteria '.$loop->iteration }}</th>
                                                @endforeach
                                                <th rowspan="2">Skor Total</th>

                                                @foreach ($pekan as $w)

                                                <th rowspan="2">{{ 'Nilai Minggu ke '.$w->minggu_ke }}</th>
                                                @endforeach

                                                <th rowspan="2">Badges</th>
                                            </tr>
                                            <tr>
                                                @foreach ($indikator as $i)
                                                <th>{{ $i['nama'] }}</th>
                                                <th>Skor</th>
                                                @endforeach
                                            </tr>

                                        </thead>
                                        <tbody>
                                            @foreach ($data as $d)
                                            <tr>
                                                <td>

                                                    {{ $d['nama_dosen'] }}
                                                </td>
                                                <td>{{ $d['nama_course'] }}</td>
                                                <td>{{ $d['kode_mk'] }}</td>
                                                <td>{{ $d['kelas'] }}</td>
                                                <td>{{ $d['prodi'] }}</td>
                                                @foreach ($d['jml_modul'] as $j)
                                                <td>
                                                    {{ $j }}
                                                </td>
                                                <td>
                                                    {{ $d['skor'][$loop->index] }}
                                                </td>
                                                @endforeach
                                                <td>
                                                    {{ $d['skor_total'] }}
                                                </td>
                                                @foreach ($pekan as $w)

                                                <td>
                                                    {{ number_format($dtlBri->where('brilian_week_id', $w->id)->where('nik', $d['nik'])->where('kode_mk', $d['kode_mk'])->where('kelas', $d['kelas'])->where('prodi', $d['prodi'])->first()->nilai ?? 0, 2) ?? '' }}
                                                </td>
                                                @endforeach
                                                <td>
                                                    {{ $d['badge'] }}
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

                <div class="row rangkuman d-none mt-3">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Badges</th>
                                                <th>Jumlah</th>
                                                <th>%</th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rangBadge as $b)

                                            <tr>
                                                <td>{{ $b['nama'] }}</td>
                                                <td>{{ $b['jumlah'] }}</td>
                                                <td>{{ $b['persen'] }}</td>
                                                <td>{{ $b['avg'] }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section-title mt-0">Rata-Rata Penggunaan Brilian</div>
                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Fakultas</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Fakultas</th>
                                                <th>Kategori</th>
                                                <th>Jumlah Kelas</th>
                                                <th>%</th>
                                                <th>Nilai</th>
                                                <th>Nilai Akhir Fakultas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rataFak as $f)
                                            <tr>

                                                <td>{{ $f['nama'] }}</td>
                                                <td>
                                                    @foreach ($f['kategori'] as $k)
                                                    <div class="my-3">

                                                        {{ $k['nama'] }}
                                                    </div>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($f['kategori'] as $k)
                                                    <div class="my-3">

                                                        {{ $k['jumlah'] }}
                                                    </div>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($f['kategori'] as $k)
                                                    <div class="my-3">

                                                        {{ $k['persen'] }}
                                                    </div>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($f['kategori'] as $k)
                                                    <div class="my-3">

                                                        {{ $k['nilai'] }}
                                                    </div>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    {{ $f['nilai_akhir'] }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Program Studi</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Program Studi</th>
                                                <th>Kategori</th>
                                                <th>Jumlah Kelas</th>
                                                <th>%</th>
                                                <th>Nilai</th>
                                                <th>Nilai Akhir Prodi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rataProdi as $key => $f)
                                            <tr>

                                                <td>{{ $f['nama'].' ('.$key.')' }}</td>
                                                <td>
                                                    @foreach ($f['kategori'] as $k)
                                                    <div class="my-3">

                                                        {{ $k['nama'] }}
                                                    </div>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($f['kategori'] as $k)
                                                    <div class="my-3">

                                                        {{ $k['jumlah'] }}
                                                    </div>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($f['kategori'] as $k)
                                                    <div class="my-3">

                                                        {{ $k['persen'] }}
                                                    </div>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($f['kategori'] as $k)
                                                    <div class="my-3">

                                                        {{ $k['nilai'] }}
                                                    </div>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    {{ $f['nilai_akhir'] }}
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
@include('laporan.brilian.modal-brilian')
@endsection
@push('script')
@include('laporan.brilian.script')
@endpush
