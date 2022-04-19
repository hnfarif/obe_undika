<div class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" id="formAgenda">
    <div class="modal-dialog modal-dialog-scrollable modal-xl " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form tambah data Minggu ke {{ $week }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <section class="section">
                    <div class="section-title mt-0">Sub CLO (LLO) dan Penilaian</div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group ui-menu ui-menu-item">
                                <label>Kode CLO</label>
                                <select class="form-control @error('clo_id') is-invalid @enderror select2" name="clo_id"
                                    id="clo_id" required>
                                    <option value="default" selected disabled> Pilih Kode CLO</option>
                                    @foreach ($clo as $i)

                                    <option value="{{ $i->kode_clo }}">{{ $i->kode_clo.' - '.$i->deskripsi  }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('clo_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Kode LLO</label>
                                <input type="text" maxlength="6" autocomplete="off" name="kode_llo" id="kode_llo"
                                    class="form-control @error('kode_llo') is-invalid @enderror" placeholder="cth: LLO1"
                                    required>
                                @error('kode_llo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Deskripsi LLO</label>
                                <textarea id="des_llo" name="des_llo" id="" style="height: 100px"
                                    class="form-control @error('des_llo') is-invalid @enderror" required></textarea>
                                @error('des_llo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Ketercapaian LLO</label>
                                <textarea id="capai_llo" name="capai_llo"
                                    class="form-control  @error('capai_llo') is-invalid @enderror sn-capai"
                                    required></textarea>
                                @error('capai_llo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>


                        </div>
                        <div class="col-lg-6">

                            <div class="form-group">
                                <label>Bentuk Penilaian</label>
                                <select id="btk_penilaian" name="btk_penilaian" class="form-control select2">
                                    <option value="default" selected disabled> Pilih Bentuk Penilaian</option>
                                    @foreach ($penilaian as $i)

                                    <option value="{{ $i->btk_penilaian }}">{{ $i->btk_penilaian }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Bobot bentuk penilaian (%)</label>
                                <input id="bbt_penilaian" name="bbt_penilaian" type="number" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Deskripsi Penilaian</label>
                                <textarea id="des_penilaian" name="des_penilaian"
                                    class="form-control  @error('des_penilaian') is-invalid @enderror sn-pen"
                                    required></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="section-title mt-0">Materi</div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Bahan Kajian</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="kajian" id="inKajian" class="form-control" placeholder=""
                                        required>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" id="btnKajian" type="button">Tambah</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Materi</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="materi" id="inMateri" class="form-control" placeholder=""
                                        required>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" id="btnMateri" type="button">Tambah</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Pustaka</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="judul" class="form-control" placeholder="Masukkan Judul"
                                        aria-label="">
                                </div>
                                <div class="input-group mb-3">
                                    <input type="text" id="bab" class="form-control" placeholder="Masukkan Bab"
                                        aria-label="">
                                </div>
                                <div class="input-group mb-3">
                                    <input type="text" id="halaman" class="form-control" placeholder="Masukkan Halaman"
                                        aria-label="">
                                </div>
                                <button class="btn btn-primary" id="btnPustaka" type="button">Tambah Pustaka</button>
                            </div>
                            <div class="form-group">
                                <label>Media Pembelajaran</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="mediaPembelajaran" class="form-control" placeholder=""
                                        aria-label="">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" id="btnMedia" type="button">Tambah</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Metode Pembelajaran</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="metodePem" placeholder="" aria-label="">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" id="btnMetode">Tambah</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Pengalaman Belajar Mahasiswa</label>
                                <div class="form-group mb-3">
                                    <textarea class="form-control" style="height: 100px" id="desPbm"></textarea>
                                </div>
                                <button class="btn btn-primary" type="button" id="btnPbm">Tambah PBM</button>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card ">
                                <div class="card-header">
                                    <h4>Daftar Materi, Pustaka, dan Media Pembelajaran</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-wrapper" style="height: 600px;">
                                        <div id="accordion">
                                            <div class="accordion">
                                                <div class="accordion-header" role="button" data-toggle="collapse"
                                                    data-target="#kajian" aria-controls="kajian" id="accKajian">
                                                    <h4>Bahan Kajian</h4>
                                                </div>
                                                <div class="accordion-body collapse" id="kajian"
                                                    data-parent="#accordion">
                                                    <table class="table table-striped table-responsive" id="tableKajian"
                                                        width="100%">
                                                        <thead>
                                                            <th>
                                                            </th>
                                                            <th></th>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                            <div class="accordion">
                                                <div class="accordion-header" role="button" data-toggle="collapse"
                                                    data-target="#materi" aria-controls="materi" id="accMateri">
                                                    <h4>Materi</h4>
                                                </div>
                                                <div class="accordion-body collapse" id="materi"
                                                    data-parent="#accordion">
                                                    <table class="table table-striped table-responsive" id="tableMateri"
                                                        width="100%">
                                                        <thead>
                                                            <th>
                                                            </th>
                                                            <th></th>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                            <div class="accordion">
                                                <div class="accordion-header" role="button" data-toggle="collapse"
                                                    data-target="#pustaka" aria-controls="pustaka" id="accPustaka">
                                                    <h4>Pustaka</h4>
                                                </div>
                                                <div class="accordion-body collapse" id="pustaka"
                                                    data-parent="#accordion">
                                                    <table class="table table-striped table-responsive"
                                                        id="tablePustaka" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Judul</th>
                                                                <th>Bab</th>
                                                                <th>Halaman</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="accordion">
                                                <div class="accordion-header" role="button" data-toggle="collapse"
                                                    data-target="#media" id="accMedia">
                                                    <h4>Media Pembelajaran</h4>
                                                </div>
                                                <div class="accordion-body collapse" id="media"
                                                    data-parent="#accordion">
                                                    <table class="table table-striped table-responsive" id="tableMedia"
                                                        width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="accordion">
                                                <div class="accordion-header" role="button" data-toggle="collapse"
                                                    data-target="#metode" id="accMetode">
                                                    <h4>Metode Pembelajaran</h4>
                                                </div>
                                                <div class="accordion-body collapse" id="metode"
                                                    data-parent="#accordion">
                                                    <table class="table table-striped table-responsive" id="tableMetode"
                                                        width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="accordion">
                                                <div class="accordion-header" role="button" data-toggle="collapse"
                                                    data-target="#pbm" id="accPbm">
                                                    <h4>Pengalaman Belajar Mahasiswa</h4>
                                                </div>
                                                <div class="accordion-body collapse" id="pbm" data-parent="#accordion">
                                                    <table class="table table-striped table-responsive" id="tablePbm"
                                                        width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Pengalaman Belajar Mahasiswa</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section-title mt-0">Perkuliahan</div>
                    <div class="row">
                        <div class="col-lg-12 d-flex">
                            <div class="control-label">Praktikum</div>
                            <label class="custom-switch">
                                <input type="radio" name="praktikum" value="1" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Ya</span>
                            </label>
                            <label class="custom-switch">
                                <input type="radio" name="praktikum" value="0" class="custom-switch-input" checked>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Tidak</span>
                            </label>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Tatap Muka (menit/mg)</label>
                                <input type="text" id="tm" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Synchronous Learning (menit/mg)</label>
                                <input type="text" id="sl" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Asynchronous Learning (menit/mg)</label>
                                <input type="text" id="asl" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Assessment (menit/mg)</label>
                                <input type="text" id="asm" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Responsi dan Tutorial (menit/mg)</label>
                                <input type="text" id="responsi" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Belajar Mandiri (menit/mg)</label>
                                <input type="text" id="belajarMandiri" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Praktikum (menit/mg)</label>
                                <input type="text" id="prak" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="addLlo">
                    <i class="fas fa-plus"></i> Tambah Data CLO minggu ke {{ $week }}</button>
            </div>
        </div>
    </div>
</div>