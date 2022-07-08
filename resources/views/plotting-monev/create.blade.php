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
                <h2 class="section-title">Plotting Tim Gugus Penjamin Mutu</h2>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card carddrop">
                            <div class="card-header">
                                <h4>Form Plotting Monev</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('monev.plotting.store') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="nikAdm" value="{{ auth()->user()->nik }}">
                                    <div class="form-group">
                                        <label>Dosen Pemonev</label>
                                        <select
                                            class="form-control select2 @error('dosen_pemonev') is-invalid @enderror"
                                            name="dosen_pemonev" required>
                                            <option selected disabled>Pilih Dosen</option>
                                            @foreach ($kary as $i)
                                            @if (old('dosen_pemonev') == $i->nik)
                                            <option value="{{ $i->nik }}" selected>{{ $i->nama }}
                                            </option>
                                            @else
                                            <option value="{{ $i->nik }}">{{ $i->nama }}
                                            </option>
                                            @endif


                                            @endforeach
                                        </select>
                                        @error('dosen_pemonev')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">

                                        <label>Pilih Matakuliah yang dimonev</label>
                                        @error('mk_monev')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                        <table class="table table-striped table-responsive" id="tableMonev"
                                            width="100%">
                                            <thead>
                                                <th>Prodi</th>
                                                <th>Kode Mata Kuliah</th>
                                                <th>Nama Mata Kuliah</th>
                                                <th>Kelas</th>
                                                <th>Hari</th>
                                                <th>NIK</th>
                                                <th>Nama Dosen</th>
                                                <th>Mahasiswa</th>
                                                <th>Ruang</th>
                                                <th>Pilih</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($jdwkul as $i)
                                                <tr>
                                                    <td>{{ $i->getNameProdi($i->prodi) }}</td>
                                                    <td>{{ $i->klkl_id }}</td>
                                                    <td>{{ $i->getNameMataKuliah($i->klkl_id,$i->prodi) }}</td>
                                                    <td>{{ $i->kelas }}</td>
                                                    <td>{{ $i->hari }}</td>
                                                    <td>{{ $i->kary_nik }}</td>
                                                    <td>{{ $i->getNameKary($i->kary_nik) }}</td>
                                                    <td>{{ $i->terisi }}</td>
                                                    <td>{{ $i->ruang_id }}</td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox checkbox-xl">
                                                            <input type="checkbox" name="mk_monev[]"
                                                                value="{{ $i->kary_nik.'-'.$i->klkl_id.'-'.$i->prodi }}"
                                                                class="custom-control-input"
                                                                id="listMonev-{{ $loop->iteration }}">
                                                            <label class="custom-control-label"
                                                                for="listMonev-{{ $loop->iteration }}"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

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
