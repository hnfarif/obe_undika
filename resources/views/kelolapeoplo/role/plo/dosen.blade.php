@include('kelolapeoplo.section-header')

<div class="section-body">
    <div class="d-flex align-items-center my-0">
        <h2 class="section-title">Program Learning Outcomes (PLO)</h2>

    </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar PLO</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-responsive" id="tablePlo">
                        <thead>
                            <tr>

                                <th>
                                    <div style="min-width:300px;">
                                        Kode PLO
                                    </div>
                                </th>
                                <th>
                                    <div style="min-width:675px;">
                                        Deskripsi PLO
                                    </div>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plo as $i)

                            <tr>

                                <td>{{ $i->kode_plo }}</td>
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
