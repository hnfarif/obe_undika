<div class="section-header">
    <h1>Kelola RPS {{ $rps->nama_mk ?? '' }}</h1>
    <div class="btn-group ml-auto">



        <a href="{{ route('clo.index', $rps->id) }}" type="button" class="btn btn-primary @yield('clo')">Kelola
            CLO</a>

        <a href="{{ route('penilaian.index', $rps->id) }}" type="button"
            class="btn btn-primary @yield('penilaian')">Penilaian</a>


        <a href="{{ route('agenda.index', $rps->id) }}" type="button" class="btn btn-primary @yield('agenda')">Agenda
            Pembelajaran</a>

        <a href="{{ route('rangkuman.index', $rps->id) }}" type="button"
            class="btn btn-primary @yield('rangkuman')">Rangkuman</a>


    </div>

</div>