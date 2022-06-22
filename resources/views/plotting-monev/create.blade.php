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
                    <div class="col-lg-12">
                        <div class="card carddrop">
                            <div class="card-header">
                                <h4>Form Plotting Monev</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Dosen Pemonev</label>
                                    <select class="form-control select2 @error('dosen_pemonev') is-invalid @enderror"
                                        name="dosen_pemonev" required>
                                        <option selected disabled>Pilih Dosen</option>
                                        @foreach ($kary as $i)
                                        <option value="{{ $i->nik }}">{{ $i->nama }}
                                        </option>

                                        @endforeach
                                    </select>
                                    @error('dosen_pemonev')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Dosen Pengajar</label>
                                    <div class="row">
                                        <div class="col-10">
                                            <select
                                                class="form-control select2 @error('dosen_pengajar') is-invalid @enderror"
                                                name="dosen_pengajar" id="dosen_pengajar" required>
                                                <option selected disabled>Pilih Dosen</option>
                                                @foreach ($jdwkul as $i)
                                                <option value="{{ $i->kary_nik }}" data-klkl="{{ $i->klkl_id }}"
                                                    data-namamk="{{ $i->getNameMataKuliah($i->klkl_id, $i->prodi) }}"
                                                    data-karyname="{{ $i->getNameKary($i->kary_nik) }}">
                                                    {{ $i->getNameMataKuliah($i->klkl_id, $i->prodi).' - '.$i->getNameKary($i->kary_nik) }}
                                                </option>

                                                @endforeach
                                            </select>
                                            @error('dosen_pengajar')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror

                                        </div>
                                        <div class="col-2 mt-auto mb-1">

                                            <button class="btn btn-primary w-100" id="btnAddDosen"> <i
                                                    class="fas fa-plus"></i> Tambah
                                                Dosen</button>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <table class="table table-striped" id="tableMonev" width="100%">
                                        <thead>
                                            <th>Nama MataKuliah</th>
                                            <th>Nama dosen</th>
                                            <th>Aksi</th>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
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
@include('plotting-monev.script-create')
@endpush
