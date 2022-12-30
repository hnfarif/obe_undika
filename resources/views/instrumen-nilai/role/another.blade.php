<div class="row">
    <div class="loadGrafik">

    </div>
    <div class="col-12 col-lg-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Grafik Ketercapaian CLO Mata Kuliah</h4>
                <div class="d-flex ml-auto">
                    @if (auth()->user()->role != 'kaprodi')
                    <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#filInsClo">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    @endif

                    <a href="{{ route('penilaian.rangkumCapaiCloList') }}" class="btn btn-info showData"> Lihat Data
                    </a>
                </div>

            </div>
            <div class="card-body">
                <canvas id="grangclo" width="700" height="200"></canvas>
            </div>
        </div>
    </div>
</div>
