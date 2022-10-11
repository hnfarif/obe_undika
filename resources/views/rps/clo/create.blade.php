@extends('layouts.main')
@section('rps', 'active')
@section('clo', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">
            @include('rps.section-header')
            <div class="section-body">

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12 p-0 mb-3">
                        <a href="{{ route('clo.index', $rps->id) }}" type="button"
                            class="btn btn-primary ml-3 align-self-center expanded"><i class="fas fa-arrow-left"></i>
                            Kembali</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Entri CLO</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('clo.store', $rps->id) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Kode CLO</label>
                                                <input type="text" name="kode_clo"
                                                    class="form-control @error('kode_clo') is-invalid @enderror"
                                                    value="{{ "CLO-".$ite_padded }}" required readonly>
                                                @error('kode_clo')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Deskripsi CLO</label>
                                                <textarea name="deskripsi" style="height: 100px"
                                                    class="form-control @error('deskripsi') is-invalid @enderror"
                                                    required autofocus>{{ old('deskripsi') }}</textarea>
                                                @error('deskripsi')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Ranah Capaian Pembelajaran</label>
                                                <select
                                                    class="form-control select2 @error('ranah_capai') is-invalid @enderror"
                                                    name="ranah_capai[]" multiple="" required>
                                                    <option>Kognitif</option>
                                                    <option>Psikomotorik</option>
                                                    <option>Afektif</option>
                                                </select>
                                                @error('ranah_capai')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">

                                            <div class="form-group">
                                                <label>Level Bloom</label>

                                                <input type="text" name="lvl_bloom[]"
                                                    class="form-control @error('lvl_bloom') is-invalid @enderror inputtags "
                                                    value="{{ old('lvl_bloom') }}" required>
                                                @error('lvl_bloom')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Plo yang didukung</label>
                                                <select
                                                    class="form-control  @error('ploid') is-invalid @enderror select2"
                                                    name="ploid[]" multiple="" required>
                                                    @foreach ($plo as $i)
                                                    <option value="{{ $i->id }}">{{ $i->kode_plo }} -
                                                        {{ $i->deskripsi }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('ploid')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Target Kelulusan (%)</label>

                                                <input type="number" name="target_lulus"
                                                    class="form-control @error('target_lulus') is-invalid @enderror"
                                                    min="0" max="100" maxlength="3" value="{{ old('target_lulus') }}"
                                                    required>
                                                @error('target_lulus')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Nilai Minimal</label>

                                                <input type="number" name="nilai_min"
                                                    class="form-control @error('nilai_min') is-invalid @enderror "
                                                    min="0" max="100" maxlength="3" value="{{ old('nilai_min') }}"
                                                    required>
                                                @error('nilai_min')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Tambah CLO</button>
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
