@extends('layouts.main')
@section('rps', 'active')
@section('step1', 'active')
@section('content')

<section class="section">

    <div class="section-body">
        <h2 class="section-title">Plotting Rumpun Mata Kuliah</h2>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Mata Kuliah</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" id="table">
                            <thead>
                                <tr>
                                    <th>Nama Mata Kuliah</th>
                                </tr>
                            </thead>
                            <tbody id="modules">

                                @foreach ($mk as $i)

                                <tr>
                                    <td>
                                        <div class="drag" data-id="{{ $i->id }}">
                                            <span>{{ $i->nama }}</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach


                            </tbody>
                        </table>

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
                                    value="{{ old('rumpun_mk') }}" placeholder="cth : PENGELOLAAN DATA DAN INFORMASI"
                                    required>
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
                var $el = $('<li class="list-group-item drop-item">' + ui.draggable.text() +
                    '</li>'
                );


                $el.append(
                    '<input type="hidden" name="mklist[]" value="' + ui.draggable.attr(
                        'data-id') + '">');

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
