<div class="row">
    <div class="loadGrafik">

    </div>
    <div class="col-12 col-lg-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Grafik Ketercapaian CLO Mata Kuliah</h4>
                @if (auth()->user()->role != 'kaprodi')
                <button class="btn btn-primary ml-auto mr-2" data-toggle="modal" data-target="#filInsClo">
                    <i class="fas fa-filter"></i> Filter
                </button>
                @endif

                <button class="btn btn-info" id="btnShowListCapai"> Lihat Data </button>
            </div>
            <div class="card-body">
                <canvas id="grangclo" width="700" height="200"></canvas>
            </div>
        </div>
    </div>
</div>
