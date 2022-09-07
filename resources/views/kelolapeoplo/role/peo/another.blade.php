<div class="section-body">
    <div class="d-flex align-items-center my-0">
        <h2 class="section-title">Daftar Prodi</h2>

    </div>
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Prodi</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="tblProdi">
                        <thead>
                            <tr class="text-center">
                                <th>Kode Prodi</th>
                                <th>Nama Prodi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prodi as $i)
                            <tr class="text-center">
                                <td>{{ $i->id }}</td>
                                <td>{{ $i->nama }}</td>
                                <td>
                                    <a href="{{ route('peo.detail', ['id' => $i->id]) }}"
                                        class="btn btn-primary mr-2">Detail</a>

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
