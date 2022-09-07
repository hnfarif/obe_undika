<div class="section-header">
    <h1>Kelola PEO-PLO</h1>
    <div class="btn-group ml-auto">

        <a href="{{ route('peo.detail', ['id' => request('id')]) }}" type="button"
            class="btn btn-primary @yield('step1')">Kelola PEO</a>


        <a href="{{ route('plo.detail', ['id' => request('id')]) }}" type="button"
            class="btn btn-primary @yield('step2')">Kelola PLO</a>


        <a href="{{ route('map.detail', ['id' => request('id')]) }}" type="button"
            class="btn btn-primary @yield('step3')">Kelola Mapping
            PEO-PLO</a>


    </div>

</div>
