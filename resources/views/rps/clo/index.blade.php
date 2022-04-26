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

                @if (session()->has('message'))
                <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" role="alert">
                    {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="d-flex align-items-center my-0">
                    <h2 class="section-title">Mata Kuliah</h2>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
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
                                                <button type="button" class="btn btn-light mr-2 btnUbah"><i
                                                        class="fas fa-edit"></i>
                                                    Ubah</button>
                                                <button type="submit" class="btn btn-primary mr-2 d-none btnSimpan"><i
                                                        class="fas fa-check"></i> Simpan</button>

                                                <button type="button" class="btn btn-danger d-none btnBatal"><i
                                                        class="fas fa-times"></i>
                                                    Batal</button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12 p-0 mb-2">
                        <a href="{{ route('clo.create', $rps->id) }}" type="button"
                            class="btn btn-primary ml-3 align-self-center expanded"><i class="fas fa-plus"></i> Entri
                            CLO</a>
                    </div>
                </div>

                <div class="d-flex align-items-center my-0">
                    <h2 class="section-title">Tabel CLO</h2>
                </div>
                <div class="row">
                    <div class="col-12  col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar CLO</h4>
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

                                                            <button type="button" class="btn btn-danger deletePlo">
                                                                <i class="fas fa-trash my-auto"></i>
                                                            </button>

                                                        </form>
                                                    </div>
                                                </div>
                                                <hr>
                                                @endforeach
                                            </td>

                                            <td class="d-flex">
                                                <a href="#" type="button" class="btn btn-light my-auto mr-2 editClo"
                                                    data-id="{{ $clos->id }}" data-toggle="modal"
                                                    data-target="#editClo"><i class="fas fa-edit"></i>

                                                </a>

                                                @if ($clos->plos->count() == 0)

                                                <form action="{{ route('clo.delete',[$i->id,$clos->id]) }}"
                                                    method="POST" class="@if($clos->kode_clo !== $iteration)
                                                d-none
                                            @endif">
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

<div class="modal fade" role="dialog" data-backdrop="static" id="editClo">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah CLO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('clo.update') }}" method="POST">
                    @method('put')
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="rps_id" id="rps">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Kode CLO</label>
                                <input type="text" name="kode_clo" id="kode_clo"
                                    class="form-control @error('kode_clo') is-invalid @enderror" required readonly>
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
                                <textarea name="deskripsi" id="deskripsi" style="height: 100px"
                                    class="form-control @error('deskripsi') is-invalid @enderror" required
                                    autofocus>{{ old('deskripsi') }}</textarea>
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
                                <select class="form-control select2 optranah @error('ranah_capai') is-invalid @enderror"
                                    name="ranah_capai[]" multiple="" required>

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
                                <input id="lvl_bloom" type="text" name="lvl_bloom[]"
                                    class="form-control @error('lvl_bloom') is-invalid @enderror inputtags" required>
                                @error('lvl_bloom')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Tambah Plo yang didukung</label>
                                <select id="ploid" class="form-control  @error('ploid') is-invalid @enderror select2"
                                    name="ploid[]" multiple="" required>

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

                                <input type="number" name="target_lulus" id="target_lulus"
                                    class="form-control @error('target_lulus') is-invalid @enderror" min="0" max="100"
                                    value="{{ old('target_lulus') }}" required>
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

                                <input type="number" name="nilai_min" id="nilai_min"
                                    class="form-control @error('nilai_min') is-invalid @enderror " min="0" max="100"
                                    value="{{ old('nilai_min') }}" required>
                                @error('nilai_min')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    $(document).ready(function () {
        var dataRanah = ["Kognitif", "Psikomotorik", "Afektif"];
        $('#tableClo').DataTable();

        $('.btnUbah').click(function () {
            $('.form-control').removeAttr('readonly');
            $('.form-control').removeAttr('disabled');
            $('.btnSimpan').removeClass('d-none')
            $('.btnBatal').removeClass('d-none')
            $('.btnUbah').addClass('d-none')
            $('.descMk').focus();
        })
        $('.btnBatal').click(function () {
            location.reload();

        })

        $('#tableClo').on('click', '.editClo', function () {
            var id = $(this).attr('data-id');
            $(".optranah").html('');
            $(".inputtags").tagsinput('removeAll');
            $("#ploid").html('');
            $.ajax({
                url: "{{ route('clo.edit') }}",
                type: "GET",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function (data) {

                    $("#id").val(data.clo.id);
                    $("#rps").val(data.clo.rps_id);
                    $("#kode_clo").val(data.clo.kode_clo);
                    $("#deskripsi").val(data.clo.deskripsi);
                    $("#target_lulus").val(data.clo.tgt_lulus);
                    $("#nilai_min").val(data.clo.nilai_min);
                    let ranahArray = data.clo.ranah_capai.split(' ');
                    dataRanah.forEach(element => {
                        if (ranahArray.includes(element)) {

                            $(".optranah").append(
                                `<option selected value="${element}">${element}</option>`
                            );
                        } else {
                            $(".optranah").append(
                                `<option value="${element}">${element}</option>`
                            );
                        }
                    });
                    let bloomArray = data.clo.lvl_bloom.split(',');
                    bloomArray.forEach(element => {
                        $(".inputtags").tagsinput('add', element);

                    });

                    var plos = Array();

                    data.plo.forEach(element => {
                        plos.push(element.id);
                    });
                    console.log(data.allplo);
                    data.allplo.forEach(element => {

                        if (plos.includes(element.id)) {
                            $("#ploid").append(
                                `<option selected value="${element.id}">${element.kode_plo} - ${element.deskripsi}</option>`
                            );
                        } else {
                            $("#ploid").append(
                                `<option value="${element.id}">${element.kode_plo} - ${element.deskripsi}</option>`
                            );
                        }
                    });


                }
            })
        })

        $('#tableClo').on('click', '.deletePlo', function (e) {

            var form = $(this).closest('form');
            var name = $(this).data('name');
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Kamu tidak dapat mengembalikan data yang sudah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6777ef',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.value) {
                    form.submit();
                }

            })


        })
    });

</script>
@endpush
