<div class="my-3 d-flex">
    <button class="btn btn-light ml-auto" data-toggle="modal" data-target="#filInsClo">
        <i class="fas fa-filter"></i> Filter
    </button>
</div>

<div class="row">
    <div class="loadGrafik">

    </div>
    <div class="col-12 col-lg-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Grafik Ketercapaian CLO Mata Kuliah</h4>
                <a href="{{ route('penilaian.rangkumCapaiCloList') }}" class="btn btn-info ml-auto"> Lihat Data </a>
            </div>
            <div class="card-body">
                <canvas id="grangclo" width="700" height="200"></canvas>
            </div>
        </div>
    </div>
</div>
