<div class="section-header">
    <h1>Kelola RPS {{ $rps->nama_mk ?? '' }}</h1>
    <div class="btn-group ml-auto">

        <a href="{{ route('clo.index', $rps->id) }}" type="button" class="btn btn-primary intro-1 @yield('clo')">Kelola
            CLO</a>

        <a href="{{ route('penilaian.index', $rps->id) }}" type="button"
            class="btn btn-primary intro-2 @yield('penilaian')">Penilaian</a>


        <a href="{{ route('agenda.index', $rps->id) }}" type="button"
            class="btn btn-primary intro-3 @yield('agenda')">Agenda
            Pembelajaran</a>

        <a href="{{ route('rangkuman.index', $rps->id) }}" type="button"
            class="btn btn-primary intro-4 @yield('rangkuman')">Rangkuman</a>


    </div>

</div>
