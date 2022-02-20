@extends('layouts.main')
@section('rps', 'active')
@section('clo', 'active')
@section('content')
<section class="section">
    @include('rps.section-header')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Entri CLO</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Kode PLO</label>
                                    <select class="form-control select2">
                                        <option>PLO-01</option>
                                        <option>PLO-02</option>
                                        <option>PLO-03</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Kode CLO</label>
                                    <input type="text" class="form-control" value="CLO-02" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Ranah Capaian Pembelajaran</label>
                                    <select class="form-control select2" multiple="">
                                        <option>Koginitif</option>
                                        <option>Psikomotorik</option>
                                        <option>Afektif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">

                                <div class="form-group">
                                    <label>Level Bloom</label>

                                    <input type="text" class="form-control inputtags">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi CLO</label>
                            <textarea name="" id="" style="height: 100px" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-primary">Tambah CLO</button>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</section>
@endsection
