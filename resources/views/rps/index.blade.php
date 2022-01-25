@extends('layouts.main')
@section('rps', 'active')
@section('step1', 'active')
@section('content')
<section class="section">


    <div class="section-body">
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
                                        <td>Teknologi Big Data</td>
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
@endsection
{{-- @section('script')
<script>
    $(document).ready(function () {
        $('.owl-carousel').owlCarousel({
            // autoplay: false,
            // loop: false,
        })

    })

</script>
@endsection --}}
