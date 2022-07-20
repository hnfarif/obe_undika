<div class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" id="editTgl">
    <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ttlAgd">Ubah Tanggal</h5>
                <div class="spinner-border text-primary" id="loadeditTgl" role="status" style="display: none;">
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <section class="section">
                    <form action="{{ route('agenda.uptDate') }}" method="POST">
                        @method('put')
                        @csrf
                        <input type="hidden" name="agd_id" id="tgl_agd_id">
                        <label for="">Ubah Tanggal</label>
                        <input type="text" id="tgl_week" name="tanggal" class="form-control" autocomplete="off">
                        @error('tanggal')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="ubahAgd">
                    <i class="fas fa-edit"></i> Ubah Tanggal</button>
                </form>
            </div>
        </div>
    </div>
</div>
