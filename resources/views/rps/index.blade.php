@extends('layouts.main')
@section('rps', 'active')
@section('step1', 'active')
@section('content')

<section class="section">


    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12 p-0 mb-2 d-flex">
                <a href="{{ route('rps.plottingmk') }}" type="button"
                    class="btn btn-primary ml-3  align-self-center expanded"><i class="fas fa-plus"></i> Entri Plotting
                    Mata Kuliah</a>
            </div>
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
                                    @foreach ($rps as $i)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{ $i->kurlkl_id }}</td>
                                        <td>{{ $i->nama_mk }}</td>
                                        <td>{{ $i->rumpun_mk }}</td>
                                        <td>{{ $i->ketua_rumpun }}</td>
                                        <td>
                                            @if ($i->penyusun)
                                            {{ $i->penyusun }}
                                            @else
                                            <button class="btn btn-primary" data-toggle="modal"
                                                data-target="#modalPenyusun"><i class="fas fa-plus"></i></button>
                                            @endif

                                        </td>
                                        <td>
                                            {{ $i->semester }}
                                        </td>
                                        <td>
                                            {{ $i->sks }}
                                        </td>
                                        <td>
                                            <div class="badge badge-info">To do</div>
                                        </td>
                                        <td><a href="{{ route('clo.index', $i->id) }}" class="btn btn-light">Lihat</a>
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
