<div class="section-header">
    <h1>Kelola RPS Teknologi Big Data</h1>
    <div class="btn-group ml-auto">



        <a href="{{ route('kelola.clo') }}" type="button" class="btn btn-primary @yield('clo')">Kelola CLO</a>

        <a href="{{ route('kelola.penilaian') }}" type="button"
            class="btn btn-primary @yield('penilaian')">Penilaian</a>


        <a href="{{ route('kelola.agenda') }}" type="button" class="btn btn-primary @yield('agenda')">Agenda
            Pembelajaran</a>

        <a href="{{ route('kelola.wbm') }}" type="button" class="btn btn-primary @yield('pbm')">WAktu Belajar
            Mahasiswa</a>


    </div>
    {{-- <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">Layout</a></div>
        <div class="breadcrumb-item">Top Navigation</div>
    </div> --}}
</div>
