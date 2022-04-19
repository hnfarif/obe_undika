@extends('layouts.main')
@section('peoplo', 'active')
@section('step3', 'active')
@section('content')
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
        {{ session()->forget('message') }}
        {{ session()->forget('alert-class') }}
        @endif
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar PLO</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-responsive" id="table">
                            <thead>
                                <tr>
                                    <th>
                                        Kode PLO

                                    </th>
                                    <th>Deskripsi PLO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($plo as $i)
                                <tr>
                                    <td id="modules" style="width: 150px">
                                        <div class="text-center drag" data-id="{{ $i->id }}">
                                            <span class="p-4">{{ $i->kode_plo }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div data-id="{{ $i->id }}">
                                            <span>{{ $i->deskripsi }}</span>
                                        </div>
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

                                    <option value="{{ $i->id }}">{{ "($i->kode_peo) - ". $i->deskripsi }}</option>

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
                                    <div class="dz-message"><span>Drag kode PLO-nya kesini</span></div>

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
@endsection
@push('script')
<script>
    $(document).ready(function () {

        var datamk = [];

        $('.drag').draggable({
            appendTo: 'body',
            helper: 'clone',
            stack: 'div',
        });

        $('#dropzone').droppable({
            activeClass: 'active',
            hoverClass: 'hover',
            accept: ":not(.ui-sortable-helper)", // Reject clones generated by sortable
            drop: function (e, ui) {
                var $el = $('<li class="list-group-item drop-item" >' + ui.draggable
                    .text() +
                    '</li>'

                );

                $el.append('<input type="hidden" name="plolist[]" value="' + ui.draggable.attr(
                        'data-id') +
                    '">');
                $el.append($(
                    '<button type="button" class="btn btn-danger btn-sm remove">hapus</button>'
                ).click(function () {
                    $(this).parent().detach();
                    if (datamk.length > 0) {

                        for (var i = 0; i < datamk.length; i++) {
                            if (datamk[i].trim() == ui.draggable.attr('data-id')
                                .trim()) {
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
                        if (datamk[i].trim() == ui.draggable.attr('data-id').trim()) {
                            // console.log(datamk);
                            isAvail = true;

                        }
                    }

                    if (!isAvail) {

                        $(this).append($el);
                        datamk.push(ui.draggable.attr('data-id').trim());

                    }
                } else {
                    datamk.push(ui.draggable.attr('data-id').trim());
                    $(this).append($el);
                    $('.dz-message').hide();
                }
            },


        }).sortable({
            items: '.drop-item',
            sort: function () {
                // gets added unintentionally by droppable interacting with sortable
                // using connectWithSortable fixes this, but doesn't allow you to customize active/hoverClass options
                $(this).removeClass("active");
            }
        });
    })

</script>
@endpush
