@include('kelolapeoplo.section-header')
<div class="section-body">
    <div class="d-flex align-items-center my-0">
        <h2 class="section-title">Kelola PEO</h2>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar PEO</h4>
                </div>
                <div class="card-body ">

                    <table class="table table-striped table-responsive" id="tablePeo">
                        <thead>
                            <tr>
                                <th>
                                    <div style="min-width:300px;">
                                        Kode PEO
                                    </div>
                                </th>
                                <th>
                                    <div style="min-width:675px;">
                                        Deskripsi PEO
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peo as $i)

                            <tr>

                                <td>{{ $i->kode_peo }}</td>
                                <td>{{ $i->deskripsi }}</td>

                            </tr>
                            @endforeach
                        </tbody>

                    </table>


                </div>
            </div>

        </div>
    </div>

</div>
