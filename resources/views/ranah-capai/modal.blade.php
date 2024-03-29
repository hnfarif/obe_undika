<div class="modal fade" role="dialog" data-backdrop="static" id="imporData">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Impor Ranah Capaian Pembelajaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('rcp.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="">Masukkan File (format .xlsx max 2mb)</label>
                        <input class="form-control" type="file" name="file_excel">
                    </div>
                    <div class="form-group">
                        <div class="alert alert-warning fade show" role="alert">
                            <strong>Perhatian!</strong> Harap pastikan file excel sudah sesuai dengan format heading row
                            yang telah ditentukan.
                        </div>
                    </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Impor data</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" data-backdrop="static" id="modalKko">
    <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kata Kerja Operasional (KKO)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="showKko">

            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
