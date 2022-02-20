<div class="section-header">
    <h1>Kelola PEO-PLO</h1>
    <div class="btn-group ml-auto">

        <a href="{{ route('peoplo.peo') }}" type="button" class="btn btn-primary @yield('step1')">Kelola PEO</a>


        <a href="{{ route('peoplo.plo') }}" type="button" class="btn btn-primary @yield('step2')">Kelola PLO</a>


        <a href="{{ route('peoplo.mapping') }}" type="button" class="btn btn-primary @yield('step3')">Kelola Mapping
            PEO-PLO</a>


    </div>
    {{-- <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">Layout</a></div>
        <div class="breadcrumb-item">Top Navigation</div>
    </div> --}}
</div>
