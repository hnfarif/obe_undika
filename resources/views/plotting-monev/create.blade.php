@extends('layouts.main')
@section('plottingmonev', 'active')
@section('', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">

            <div class="section-body">
                <h2 class="section-title">Plotting Tim Gugus Penjamin Mutu</h2>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Mata Kuliah</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" id="tableJdw">
                                    <thead>
                                        <tr>
                                            <th>Nama Mata Kuliah</th>

                                        </tr>
                                    </thead>
                                    <tbody id="modules">

                                        @foreach ($jdwkul as $i)

                                        <tr>
                                            <td>
                                                <div class="drag" data-id="{{ $i->klkl_id }}">
                                                    <span>{{ $i->getNameMataKuliah($i->klkl_id, $i->prodi).' - '.  $i->getNameKary($i->kary_nik) }}</span>
                                                </div>
                                            </td>

                                        </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                                {{ $jdwkul->links() }}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card carddrop">
                            <div class="card-header">
                                <h4>Rumpun Mata Kuliah</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('rps.plottingmk.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Nama Rumpun Mata Kuliah</label>
                                        <input type="text" name="rumpun_mk"
                                            class="form-control @error('rumpun_mk') is-invalid @enderror"
                                            value="{{ old('rumpun_mk') }}"
                                            placeholder="cth : PENGELOLAAN DATA DAN INFORMASI" required>
                                        @error('rumpun_mk')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Ketua Rumpun</label>
                                        <select class="form-control select2 @error('ketua_rumpun') is-invalid @enderror"
                                            name="ketua_rumpun" required>
                                            <option selected disabled>Pilih Dosen</option>
                                            {{-- @foreach ($dosens as $i)
                                            <option value="{{ $i->nik }}">{{ $i->nama }}
                                            </option>

                                            @endforeach --}}
                                        </select>
                                        @error('ketua_rumpun')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Semester Pembuatan</label>
                                        <input type="text" name="semester"
                                            class="form-control @error('semester') is-invalid @enderror"
                                            value="{{ old('semester') }}" placeholder="cth : 201, 202, 211" required>
                                        @error('semester')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Daftar Mata Kuliah</label>
                                        <ul class="list-group" id="dropzone">
                                            <div class="dz-message"><span>Drag Nama Mata Kuliahnya kesini</span></div>
                                        </ul>
                                        @error('mklist')
                                        <div class="alert alert-danger alert-dismissible show fade ">{{ $message }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>

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
@include('plotting-monev.script-create')
@endpush
