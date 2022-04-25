<div class="col-12 col-md-6 col-lg-6">
    <div class="card">
        <div class="card-header">
            <h4>Input PLO</h4>
        </div>
        <div class="card-body">

            <form action="{{ route('peoplo.plo.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Kode PLO</label>
                    <input type="text" class="form-control @error('kode_plo') is-invalid @enderror" name="kode_plo"
                        value="PLO-{{ $ite_padded }}" readonly>
                    @error('kode_plo')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Deskripsi PLO</label>
                    <textarea id="" class="form-control  @error('desc_plo') is-invalid @enderror" name="desc_plo"
                        style="height: 100px" required>{{ old('desc_plo') }}</textarea>
                    @error('desc_plo')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Tambah PLO</button>
                </div>
            </form>

        </div>
    </div>

</div>
<div class="col-12 col-md-6 col-lg-6">
    <div class="card">
        <div class="card-header">
            <h4>Daftar PLO</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped table-responsive" id="tablePlo">
                <thead>
                    <tr>

                        <th>
                            Kode PLO
                        </th>
                        <th>
                            <div style="width: 300px">Deskripsi PLO</div>
                        </th>
                        <th>Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($plo as $i)

                    <tr>

                        <td>{{ $i->kode_plo }}</td>
                        <td>{{ $i->deskripsi }}</td>
                        <td>
                            <div class="d-flex my-auto">

                                <a href="#" class="btn btn-light mr-2 editPlo" data-id="{{ $i->id }}"
                                    data-toggle="modal" data-target="#editPlo"><i class="fas fa-edit"></i>

                                </a>
                                <form class="@if($i->kode_plo !== $iteration)
                            d-none
                            @elseif($i->peos->count() > 0)
                            d-none
                            @endif" action="{{ route('peoplo.plo.delete', $i->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <input name="_method" type="hidden" value="DELETE">
                                    <a href="#" class="btn btn-danger deletePlo"><i class="fas fa-trash"></i>

                                    </a>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>


        </div>
    </div>

</div>
