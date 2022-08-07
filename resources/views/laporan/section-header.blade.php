<div class="section-header">
    <h1>Laporan</h1>
    <div class="btn-group ml-auto">



        <a href="{{ route('laporan.monev.index') }}" type="button" class="btn btn-primary @yield('monev')">Monev</a>

        <a href="{{ route('laporan.brilian.index') }}" type="button"
            class="btn btn-primary @yield('brilian')">Brilian</a>


        <a href="{{ route('laporan.angket.index') }}" type="button" class="btn btn-primary @yield('agenda')">Angket</a>


    </div>

</div>
