@include('kelolapeoplo.section-header')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-6 col-lg-12 p-0 mb-2 d-flex">
            <a href="{{ route('peoplo.map.create') }}" type="button"
                class="btn btn-primary ml-3  align-self-center expanded"><i class="fas fa-plus"></i> Entri Mapping</a>
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
                            @if ($peos->plos)

                            <tr>

                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $peos->kode_peo }}</td>
                                <td>{{  $peos->deskripsi }}</td>


                                <td>
                                    @foreach ($peos->plos->sortBy('id') as $i)
                                    <div class="d-flex">
                                        <div class="mr-1">

                                            {!! '<b>'.$i->kode_plo."</b> - ".$i->deskripsi !!}
                                        </div>
                                        <div class="my-auto">
                                            <form action="{{ route('peoplo.map.delete',[$peos->id,$i->id]) }}"
                                                method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button class="btn btn-danger mr-auto deletePeoplo"><i
                                                        class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
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
