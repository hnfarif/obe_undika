@extends('layouts.main')
@section('peoplo', 'active')
@section('step3', 'active')
@section('content')
<section class="section">
    @include('kelolapeoplo.section-header')

    <div class="section-body">
        <div class="d-flex align-items-center my-0">
            <h2 class="section-title">Entri Mapping PEO-PLO</h2>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar PLO</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" id="table">
                            <thead>
                                <tr>
                                    <th>Kode PLO</th>
                                    <th>Deskripsi PLO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td id="modules">
                                        <div class="drag" data-id="1">
                                            <span>PLO-01</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div data-id="1">
                                            <span>Mampu mengolah dan menganalisis data berskala besar, baik data
                                                terstruktur, semi terstruktur maupun tidak terstuktur yang berasal dari
                                                dalam dan luar organisasi dengan berbagai macam tools sehingga menjadi
                                                informasi dan pengetahuan yang berguna dalam mendukung pengambilan
                                                keputusan bagi pihak manajemen suatu organisasi.</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td id="modules">
                                        <div class="drag" data-id="2">
                                            <span>PLO-02</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div data-id="1">
                                            <span>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sit,
                                                ut.</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td id="modules">
                                        <div class="drag" data-id="3">
                                            <span>PLO-03</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div data-id="1">
                                            <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam nobis
                                                nam at eos. Quasi voluptatem recusandae sit culpa dolorem!
                                                Impedit.</span>
                                        </div>
                                    </td>
                                </tr>

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
                        <div class="form-group">
                            <label>Pilih PEO</label>
                            <select class="form-control select2">
                                <option value="" selected disabled>Pilih PEO</option>
                                <option>PEO-01</option>
                                <option>PEO-02</option>
                                <option>PEO-03</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Daftar PLO</label>
                            <ul class="list-group" id="dropzone">
                                <div class="dz-message"><span>Drag kode PLO-nya kesini</span></div>
                            </ul>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center my-0">
            <h2 class="section-title">Hasil Mapping</h2>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Mapping PEO-PLO</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <tr>
                                    <th>#</th>
                                    <th>Kode PEO</th>
                                    <th>Deskripsi PEO</th>
                                    <th>Kode PLO</th>
                                    <th>Deskripsi PLO</th>

                                </tr>
                                <tr>
                                    <td rowspan="2">1</td>
                                    <td rowspan="2">PEO-01</td>
                                    <td rowspan="2">Menghasilkan lulusan profesional sebagai Pengembang Sistem Informasi
                                        yang didukung oleh Kemampuan Analisis Data untuk Menghasilkan Realtime SPK dan
                                        mampu memberikan solusi sebagai Konsultan IT di suatu Organisasi</td>
                                    <td>PLO-01</td>
                                    <td>Mampu mengidentifikasi, memformulasikan dan memecahkan permasalahan kebutuhan
                                        informasi dari sebuah organisasi</td>

                                </tr>
                                <tr>
                                    <td>PLO-02</td>
                                    <td>Dapat mengintegrasikan solusi berbasis teknologi informasi secara efektif pada
                                        suatu organisasi</td>

                                </tr>
                            </table>
                        </div>

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


                $el.append($(
                    '<button type="button" class="btn btn-danger btn-sm remove">hapus</button>'
                ).click(function () {
                    $(this).parent().detach();
                    if (datamk.length > 0) {

                        for (var i = 0; i < datamk.length; i++) {
                            if (datamk[i].trim() == ui.draggable.text().trim()) {
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
                        if (datamk[i].trim() == ui.draggable.text().trim()) {
                            // console.log(datamk);
                            isAvail = true;

                        }
                    }

                    if (!isAvail) {

                        $(this).append($el);
                        datamk.push(ui.draggable.text().trim());

                    }
                } else {
                    datamk.push(ui.draggable.text().trim());
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
