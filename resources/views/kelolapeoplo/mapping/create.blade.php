@extends('layouts.main')
@section('peoplo', 'active')
@section('step3', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">
            @include('kelolapeoplo.section-header')

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12 p-0 mb-2 d-flex">
                        <a href="{{ route('peoplo.map') }}" type="button"
                            class="btn btn-primary ml-3  align-self-center expanded"><i class="fas fa-arrow-left"></i>
                            Kembali</a>
                    </div>
                </div>
                <div class="d-flex align-items-center my-0">
                    <h2 class="section-title">Entri Mapping PEO-PLO</h2>
                </div>
                @if (session()->has('message'))
                <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" role="alert">
                    {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar PLO</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-responsive" id="tableMapCreate" width="100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                Kode PLO
                                            </th>
                                            <th>
                                                Deskripsi PLO

                                            </th>
                                            <th>
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($plo as $i)
                                        <tr>
                                            <td>
                                                {{ $i->kode_plo }}
                                            </td>
                                            <td>
                                                {{ $i->deskripsi }}
                                            </td>
                                            <td>
                                                <button class="btn btn-primary" id="btnAddPlo-{{ $loop->iteration }}"
                                                    data-id="{{ $i->id }}" data-kode="{{ $i->kode_plo }}">
                                                    <i class="fas fa-plus"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Mapping PEO-PLO</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('peoplo.map.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Pilih PEO</label>
                                        <select class="form-control select2" name="kode_peo" required>
                                            <option value="" selected disabled>Pilih PEO</option>
                                            @foreach ($peo as $i)

                                            <option value="{{ $i->id }}">{{ "($i->kode_peo) - ". $i->deskripsi }}
                                            </option>

                                            @endforeach
                                            @error('kode_peo')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Daftar PLO</label>
                                        <ul class="list-group" id="dropzone">
                                            <div class="dz-message"><span>Plo yang ditambahkan muncul disini</span>
                                            </div>

                                        </ul>
                                        @error('plolist')
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
<script>
    $(document).ready(function () {

        var tablemapping = $('#tableMapCreate').DataTable({
            'autoWidth': false,


        });
        var datamk = [];

        tablemapping.rows().every(function (rowIdx, tableLoop, rowLoop) {

            var node = this.node();

            var drag = $(node).find('.drag');

            drag.draggable({
                appendTo: 'body',
                helper: 'clone',
                stack: 'div',
            });


        });


        $('[id^=btnAddPlo]').click(function () {
            // add plo to listPlo elemen
            var kode = $(this).data('kode');
            var dataId = $(this).attr('data-id');

            var $el = $('<li class="list-group-item drop-item" >' + kode +
                '</li>');

            $el.append('<input type="hidden" name="plolist[]" value="' + dataId +
                '">');
            $el.append($(
                '<button type="button" class="btn btn-danger btn-sm remove">hapus</button>'
            ).click(function () {
                $(this).parent().detach();
                if (datamk.length > 0) {

                    for (var i = 0; i < datamk.length; i++) {
                        if (datamk[i].trim() == dataId.toString().trim()) {
                            datamk.splice(i, 1);
                        }
                    }

                }
                if (datamk.length == 0) {

                    $('.dz-message').show();
                }
            }));
            var isAvail = false;

            if (datamk.length > 0) {


                for (var i = 0; i < datamk.length; i++) {
                    if (datamk[i].trim() == dataId.toString().trim()) {
                        isAvail = true;

                    }
                }

                if (!isAvail) {

                    $('#dropzone').append($el);
                    datamk.push(dataId.toString().trim());

                }
            } else {
                datamk.push(dataId.toString().trim());
                $('#dropzone').append($el);
                $('.dz-message').hide();
            }


        })
        // $('#listPlo').
    })

</script>
@endpush
