@extends('layouts.main')
@section('peoplo', 'active')
@section('step3', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">
            @include('kelolapeoplo.section-header-detail')
            <div class="section-body">
                <div class="d-flex align-items-center my-0">
                    <h2 class="section-title">Hasil Mapping</h2>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Matriks Mapping PEO-PLO</h4>
                            </div>
                            <div class="card-body">

                                <table class="table table-striped" width="100%" id="tableMatriks">
                                    <thead>
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            @foreach ($peo as $peos)
                                            <th>
                                                {{ $peos->kode_peo }}
                                            </th>
                                            @endforeach

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($plo as $plos)

                                        <tr>

                                            <td>{{ $plos->kode_plo }}</td>
                                            @foreach ($peo as $peos)
                                            <td>
                                                @foreach ($mapping as $mappings)
                                                @if ($mappings->plo_id == $plos->id && $mappings->peo_id == $peos->id)
                                                <i class="fas fa-check"></i>
                                                @endif
                                                @endforeach
                                            </td>
                                            @endforeach


                                        </tr>

                                        @endforeach

                                    </tbody>
                                </table>


                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Detail Mapping PEO-PLO</h4>
                            </div>
                            <div class="card-body">

                                <table class="table table-striped table-responsive" width="100%" id="tableMap">
                                    <thead>
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>
                                                <div style="min-width: 200px">Kode PEO</div>
                                            </th>
                                            <th>
                                                <div style="min-width: 380px">Deskripsi PEO</div>
                                            </th>

                                            <th>
                                                <div style="min-width: 300px">Daftar PLO</div>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($peo as $peos)

                                        @if ($peos->plos->count() !== 0)
                                        <tr>

                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $peos->kode_peo }}</td>
                                            <td>{{  $peos->deskripsi }}</td>


                                            <td>
                                                @foreach ($peos->plos->sortBy('id') as $i)
                                                <div>
                                                    {!! '<b>'.$i->kode_plo."</b> - ".$i->deskripsi !!}

                                                </div>
                                                <hr>

                                                @endforeach

                                            </td>

                                        </tr>
                                        @endif
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

@endsection
@push('script')
<script>
    $(document).ready(function () {

        $('#tableMap').DataTable();
        $('#tableMatriks').DataTable({
            "scrollX": true,
            "responsive": true,
            "autoWidth": false,
            "info": false,
            "paging": false,
            "searching": false,
            "ordering": false,

        });


    });

</script>
@endpush
