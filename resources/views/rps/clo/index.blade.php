@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/introjs/introjs.css') }}">
@endpush
@section('rps', 'active')
@section('clo', 'active')
@section('content')

<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">
            @include('rps.section-header')

            <div class="section-body">
                @include('rps.breadcrumb')
                @if (session()->has('message'))
                <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" role="alert">
                    {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <div class="row intro-desc">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="d-flex align-items-center my-0">
                            <h2 class="section-title">Mata Kuliah</h2>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form action="{{ route('rps.update', $rps->id) }}" method="POST">
                                            @method('PUT')
                                            @csrf
                                            <div class="form-group">
                                                <label for="">Deskripsi Mata Kuliah</label>
                                                <textarea name="deskripsi_mk" id="" style="height: 100px"
                                                    class="form-control descMk"
                                                    readonly>{{  $rps->deskripsi_mk, old('deskripsi_mk') }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Mata Kuliah Prasyarat</label>
                                                <select class="form-control select2" name="prasyarat[]" multiple=""
                                                    disabled>
                                                    @foreach ($mk as $i)
                                                    <option value="{{ $i->id }}" @if (in_array($i->id, $exPra)) selected
                                                        @endif>{{ $i->nama }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="d-flex">
                                                @if (auth()->user()->nik == $rps->penyusun && $rps->is_done == '0')
                                                <button type="button" class="btn btn-light mr-2 btnUbah"><i
                                                        class="fas fa-edit"></i>
                                                    Ubah</button>
                                                <button type="submit" class="btn btn-primary mr-2 d-none btnSimpan"><i
                                                        class="fas fa-check"></i> Simpan</button>

                                                <button type="button" class="btn btn-danger d-none btnBatal"><i
                                                        class="fas fa-times"></i>
                                                    Batal</button>
                                                @endif
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row intro-clo">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="d-flex align-items-center my-0">
                            <h2 class="section-title">Tabel CLO</h2>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar CLO</h4>
                                @if (auth()->user()->nik == $rps->penyusun && $rps->is_done == '0')
                                <a href="{{ route('clo.create', $rps->id) }}" type="button"
                                    class="btn btn-primary ml-3 align-self-center expanded ml-auto"><i
                                        class="fas fa-plus"></i> Entri
                                    CLO</a>
                                @endif
                            </div>
                            <div class="card-body">

                                <table class="table table-striped table-responsive" width="100%" id="tableClo">
                                    <thead>

                                        <tr>
                                            <th>#</th>
                                            <th>Kode CLO</th>
                                            <th>
                                                <div style="min-width: 300px;">

                                                    Deskripsi CLO
                                                </div>
                                            </th>
                                            <th>Ranah Capaian Pembelajaran</th>
                                            <th>Level Bloom</th>
                                            <th>Target Kelulusan (% Mhs)</th>
                                            <th>
                                                <div style="width: 150px;">PLO yang didukung</div>
                                            </th>

                                            <th>Aksi</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clo as $clos)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $clos->kode_clo }}</td>
                                            <td>{{ $clos->deskripsi }}</td>
                                            <td>{{ str_replace(" ", ", ",$clos->ranah_capai) }}</td>
                                            <td>{{ $clos->lvl_bloom }}</td>
                                            <td>
                                                @if ($clos->tgt_lulus)

                                                {{ $clos->tgt_lulus. '% (nilai minimal '.$clos->nilai_min.')' }}
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>
                                                @foreach ($clos->plos->sortBy('kode_plo') as $item)
                                                <div style="width: 150px;" class="d-flex">
                                                    {{ $item->kode_plo }}
                                                    <div class="ml-auto">
                                                        <form action="{{ route('clo.delete',[$item->id,$clos->id] ) }}"
                                                            method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                            <input name="_method" type="hidden" value="DELETE">
                                                            <input type="hidden" name="valDel" value="plo">
                                                            <input type="hidden" name="rps_id" value="{{ $rps->id }}">
                                                            @if (auth()->user()->nik == $rps->penyusun && $rps->is_done
                                                            == '0')
                                                            <button type="button" class="btn btn-danger deletePlo">
                                                                <i class="fas fa-trash my-auto"></i>
                                                            </button>
                                                            @endif
                                                        </form>
                                                    </div>
                                                </div>
                                                <hr>
                                                @endforeach
                                            </td>

                                            <td class="d-flex">
                                                @if (auth()->user()->nik == $rps->penyusun && $rps->is_done == '0')
                                                <a href="#" type="button" class="btn btn-light my-auto mr-2 editClo"
                                                    data-id="{{ $clos->id }}" data-toggle="modal"
                                                    data-target="#editClo"><i class="fas fa-edit"></i>

                                                </a>

                                                @if ($clos->plos->count() == 0)

                                                <form action="{{ route('clo.delete',[$i->id,$clos->id]) }}"
                                                    method="POST"
                                                    class="@if($clos->kode_clo !== $iteration) d-none @endif">
                                                    @method('DELETE')
                                                    @csrf
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <input type="hidden" name="valDel" value="clo">
                                                    <input type="hidden" name="rps_id" value="{{ $rps->id }}">
                                                    <button type="button" class="btn btn-danger deletePlo">
                                                        <i class="fas fa-trash my-auto"></i>
                                                    </button>
                                                </form>
                                                @endif
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
        </section>
    </div>
    @include('layouts.footer')
</div>

@include('rps.clo.modal')
@endsection
@push('script')
@include('rps.clo.script')
@endpush
