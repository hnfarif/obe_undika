<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <div class="d-flex my-auto">

            <li class="breadcrumb-item">
                <a href="{{ route('rps.index') }}">RPS</a>
            </li>

            <li class="breadcrumb-item active" aria-current="page">
                Kelola RPS
            </li>
        </div>

        @if (auth()->user()->nik == $rps->penyusun && $rps->is_done == '1')
        <button type="button" class="btn btn-info ml-auto transAgd" data-sts="{{ $rps->is_done }}"><i
                class="fas fa-edit"></i>
            Ubah RPS</button>
        <button type="button" class="btn btn-primary btn-sm py-0 ml-3" id="introClo"><i
                class="fas fa-info-circle"></i></button>
        @elseif(auth()->user()->nik == $rps->penyusun && $rps->is_done == '0')
        <button type="button" class="btn btn-success ml-auto transAgd intro-5" data-sts="{{ $rps->is_done }}"><i
                class="fas fa-paper-plane"></i>
            Selesaikan RPS</button>
        <button type="button" class="btn btn-primary btn-sm py-0 ml-3" id="introClo"><i
                class="fas fa-info-circle"></i></button>
        @endif
    </ol>
</nav>
