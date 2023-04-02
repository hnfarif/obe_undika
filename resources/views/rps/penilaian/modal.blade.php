<div class="modal fade" role="dialog" id="editPenilaian">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Penilaian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('penilaian.update') }}" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="rps_id" value="{{ $rps->id }}">
                    <div class="form-group">
                        <label>Bentuk Penilaian</label>
                        <input type="text" name="btk_penilaian" class="form-control" id="btk_penilaian">
                    </div>
                    <div class="form-group">
                        <label>Jenis Penilaian</label>
                        <select name="jenis" id="jenis" class="form-control select2">
                            <option value="TGS">TGS</option>
                            <option value="QUI">QUI</option>
                            <option value="PRK">PRK</option>
                            <option value="PRS">PRS</option>
                            <option value="RES">RES</option>
                            <option value="PAP">PAP</option>
                            <option value="LAI">LAI</option>
                            <option value="UTS">UTS</option>
                            <option value="UAS">UAS</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>

        </div>
    </div>
</div>
