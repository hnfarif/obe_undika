<div class="row">
    <div class="col-12 col-md-6 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4>Mapping PEO-PLO</h4>
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
                                @foreach ($peos->plos as $i)
                                <div class="d-flex">
                                    {{ $i->kode_plo." - ".$i->deskripsi }}

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
