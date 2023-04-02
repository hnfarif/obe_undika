@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/introjs/introjs.css') }}">
@endpush
@section('rps', 'active')
@section('penilaian', 'active')
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
                <div class="d-flex align-items-center my-0">
                    <h2 class="section-title">Penilaian</h2>

                </div>
                <div class="row">
                    @if (auth()->user()->nik == $rps->penyusun && $rps->is_done == '0')
                    <div class="col-12 col-md-6 col-lg-4 intro-form">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Bentuk Penilaian</h4>

                            </div>
                            <div class="card-body">
                                <form action="{{ route('penilaian.store', $rps->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Bentuk Penilaian</label>
                                        <input type="text" name="btk_penilaian" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis Penilaian</label>
                                        <select name="jenis" class="form-control select2">
                                            <option value="TGS">TGS</option>
                                            <option value="QUI">QUI</option>
                                            <option value="PRK">PRK</option>
                                            <option value="PRS">PRS</option>
                                            <option value="RES">RES</option>
                                            <option value="PAP">PAP</option>
                                            <option value="LAI">LAI</option>
                                            <option value="UTS">UTS</option>
                                            <option value="UAS">UAS</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Tambah Bentuk Penilaian</button>
                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-md-6 col-lg-8 intro-data">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Bentuk Penilaian</h4>
                            </div>
                            <div class="card-body">

                                <table class="table table-striped" id="table" width="100%">
                                    <thead class="text-center">
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>
                                                Bentuk Penilaian
                                            </th>
                                            <th>
                                                Jenis Penilaian
                                            </th>

                                            <th>
                                                Aksi
                                            </th>

                                        </tr>

                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($penilaian as $i)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $i->btk_penilaian }}
                                            </td>
                                            <td>
                                                {{ $i->jenis }}
                                            </td>
                                            <td>

                                                <div class="d-flex my-auto">
                                                    @if (auth()->user()->nik == $rps->penyusun && $rps->is_done == '0')
                                                    <a href="#" class="btn btn-light mr-2 editPenilaian"
                                                        data-id="{{ $i->id }}" data-toggle="modal"
                                                        data-target="#editPenilaian"><i class="fas fa-edit"></i>

                                                    </a>
                                                    <form action="{{ route('penilaian.delete', $i->id) }}"
                                                        method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <input type="hidden" name="rps_id" value="{{ $rps->id }}">
                                                        <button class="btn btn-danger delPenilaian"><i
                                                                class="fas fa-trash"></i>

                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>

                                            </td>

                                        </tr>

                                        @endforeach
                                    </tbody>

                                </table>


                            </div>
                        </div>

                    </div>

                    @else

                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Bentuk Penilaian</h4>
                            </div>
                            <div class="card-body">

                                <table class="table table-striped" id="table" width="100%">
                                    <thead class="text-center">
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>
                                                Bentuk Penilaian
                                            </th>
                                            <th>
                                                Jenis Penilaian
                                            </th>

                                            <th>
                                                Aksi
                                            </th>

                                        </tr>

                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($penilaian as $i)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $i->btk_penilaian }}
                                            </td>
                                            <td>
                                                {{ $i->jenis }}
                                            </td>
                                            <td>

                                                <div class="d-flex my-auto">
                                                    @if (auth()->user()->nik == $rps->penyusun && $rps->is_done == '0')
                                                    <a href="#" class="btn btn-light mr-2 editPenilaian"
                                                        data-id="{{ $i->id }}" data-toggle="modal"
                                                        data-target="#editPenilaian"><i class="fas fa-edit"></i>

                                                    </a>
                                                    <form action="{{ route('penilaian.delete', $i->id) }}"
                                                        method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <input type="hidden" name="rps_id" value="{{ $rps->id }}">
                                                        <button class="btn btn-danger delPenilaian"><i
                                                                class="fas fa-trash"></i>

                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>

                                            </td>

                                        </tr>

                                        @endforeach
                                    </tbody>

                                </table>


                            </div>
                        </div>

                    </div>
                    @endif
                </div>

            </div>


        </section>
    </div>
    @include('layouts.footer')
</div>


@include('rps.penilaian.modal')
@endsection
@push('script')
@include('rps.penilaian.script')
@endpush
