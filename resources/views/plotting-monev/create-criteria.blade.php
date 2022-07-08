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
                    <div class="col-lg-12">
                        <div class="card carddrop">
                            <div class="card-header">
                                <h4>Form Entri Kriteria Penilaian Monev</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('monev.storeCriteria') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="nikAdm" value="{{ auth()->user()->nik }}">
                                    <div class="form-group">
                                        <label>Kriteria Penilaian</label>
                                        <input type="text" class="form-control" name="kriteria_penilaian"
                                            value="{{ old('kriteria_penilaian') }}">
                                        @error('kriteria_penilaian')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="row">

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Kategori</label>
                                                <input type="text" class="form-control" name="kategori"
                                                    value="{{ old('kategori') }}">
                                                @error('kategori')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Bobot (%)</label>
                                                <input type="number" class="form-control" name="bobot"
                                                    value="{{ old('bobot') }}">
                                                @error('bobot')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea style="width:100%; height: 100px;" class="form-control"
                                            name="deskripsi" value="{{ old('deskripsi') }}"></textarea>
                                        @error('deskripsi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
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
