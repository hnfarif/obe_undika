@extends('layouts.main')
@section('rps', 'active')
@section('step1', 'active')
@section('content')

<section class="section">


    <div class="section-body">
        <div class="row">
            <a href="{{ route('kelola.rps.plottingmk') }}" type="button"
                class="btn btn-primary ml-3 mb-3 align-self-center expanded"><i class="fas fa-plus"></i> Plotting Rumpun
                Mata Kuliah</a>

            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar RPS</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            #
                                        </th>
                                        <th>Kode MK</th>
                                        <th>Mata Kuliah</th>
                                        <th>Rumpun MK</th>
                                        <th>Ketua Rumpun</th>
                                        <th>Penyusun</th>
                                        <th>Semester</th>
                                        <th>SKS</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            1
                                        </td>
                                        <td>35533</td>
                                        <td>Teknologi Big Data</td>
                                        <td>PENGELOLAAN DATA DAN INFORMASI</td>
                                        <td>Julianto Lemantara</td>
                                        <td>Vivine Nurcahyawati</td>
                                        <td>
                                            7
                                        </td>
                                        <td>
                                            3
                                        </td>
                                        <td>
                                            <div class="badge badge-success">Completed</div>
                                        </td>
                                        <td><a href="{{ route('kelola.clo') }}" class="btn btn-light">Lihat</a></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            1
                                        </td>
                                        <td>35533</td>
                                        <td>Sistem Pendukung Keputusan</td>
                                        <td>PENGELOLAAN DATA DAN INFORMASI</td>
                                        <td>Julianto Lemantara</td>
                                        <td><button class="btn btn-primary" data-toggle="modal"
                                                data-target="#modalPenyusun"><i class="fas fa-plus"></i></button></td>
                                        <td>
                                            7
                                        </td>
                                        <td>
                                            3
                                        </td>
                                        <td>
                                            <div class="badge badge-info">Todo</div>
                                        </td>
                                        <td><a href="#" class="btn btn-info">Ubah</a></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            1
                                        </td>
                                        <td>35533</td>
                                        <td>Desain Basis Data</td>
                                        <td>PENGELOLAAN DATA DAN INFORMASI</td>
                                        <td>Julianto Lemantara</td>
                                        <td><button class="btn btn-primary" data-toggle="modal"
                                                data-target="#modalPenyusun"><i class="fas fa-plus"></i></button></td>
                                        <td>
                                            7
                                        </td>
                                        <td>
                                            3
                                        </td>
                                        <td>
                                            <div class="badge badge-warning">In Progress</div>
                                        </td>
                                        <td><a href="#" class="btn btn-info">Ubah</a></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


</section>
<div class="modal fade" role="dialog" id="modalPenyusun">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Dosen Penyusun</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Dosen</label>
                    <select class="form-control select2">
                        <option>Dosen 1</option>
                        <option>Dosen 2</option>
                        <option>Dosen 3</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection
