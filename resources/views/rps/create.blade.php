@extends('layouts.main')
@section('rps', 'active')
@section('step1', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">

            <div class="section-body">
                <h2 class="section-title">Plotting RPS</h2>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card carddrop">
                            <div class="card-header">
                                <h4>Form Plotting RPS</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('rps.store') }}" method="POST">
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
                                            @foreach ($dosens as $i)
                                            <option value="{{ $i->nik }}">{{ $i->nama }}
                                            </option>

                                            @endforeach
                                        </select>
                                        @error('ketua_rumpun')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Daftar Mata Kuliah</label>
                                        <table class="table table-striped text-center" id="tableMk" width="100%">
                                            <thead>
                                                <th>Prodi</th>
                                                <th>Kode Mata Kuliah</th>
                                                <th>Nama Mata Kuliah</th>
                                                <th>Pilih</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($mk as $i)
                                                <tr>
                                                    <td>{{ $i->prodi->nama }}</td>
                                                    <td>{{ $i->klkl_id }}</td>
                                                    <td>{{ $i->matakuliahs->nama }}</td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox checkbox-xl">
                                                            <input type="checkbox" name="mklist[]"
                                                                value="{{ $i->klkl_id }}" class="custom-control-input"
                                                                id="listMk-{{ $loop->iteration }}">
                                                            <label class="custom-control-label"
                                                                for="listMk-{{ $loop->iteration }}"></label>
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
<script>
    $(document).ready(function () {

        var tableMk = $('#tableMk').DataTable({
            responsive: true,

        })
    })

</script>
@endpush
