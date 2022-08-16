<div class="navbar-bg"></div>
<nav class="navbar fixed-top navbar-expand-lg main-navbar">
    <a href="index.html" class="navbar-brand sidebar-gone-hide">OBE Undika</a>
    <div class="navbar-nav">
        <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
    </div>

    <ul class="navbar-nav navbar-right ml-auto">

        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->karyawan["nama"] ?? '' }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Logged in 5 min ago</div>
                <a href="#" type="button" class="dropdown-item has-icon" id="swalRole">
                    <i class="fas fa-user-tag"></i> Change Role
                </a>

                <div class="dropdown-divider"></div>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit()"
                    class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form action="{{ route('logout') }}" id="logout-form" method="GET" style="display: none">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
        </li>
    </ul>
</nav>

<nav class="navbar navbar-secondary navbar-expand-lg">
    <div class="container">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="#" data-toggle="dropdown" class="nav-link"><i class="fas fa-fire"></i><span>Beranda</span></a>
            </li>



            <li class="nav-item @yield('peoplo')">
                <a href="{{ route('peoplo.peo') }}" class="nav-link"><i
                        class="fas fa-table"></i><span>PEO-PLO</span></a>
            </li>


            <li class="nav-item @yield('rps')">
                <a href="{{ route('rps.index') }}" class="nav-link"><i class="fas fa-school"></i><span>Kelola
                        RPS</span></a>
            </li>

            <li class="nav-item @yield('instrumen-nilai')">
                <a href="{{ route('penilaian.clo.index') }}" class="nav-link"><i
                        class="fas fa-table"></i><span>Penilaian CLO</span></a>
            </li>
            <li class="nav-item @yield('instrumen-monev')">
                <a href="{{ route('monev.listMonev') }}" class="nav-link"><i
                        class="fas fa-vector-square"></i><span>Instrumen Monev</span></a>
            </li>
            <li class="nav-item @yield('plottingmonev')">
                <a href="{{ route('monev.plotting.index') }}" class="nav-link"><i
                        class="fas fa-vector-square"></i><span>Plotting
                        Monev</span></a>
            </li>
            <li class="nav-item @yield('laporan')">
                <a href="{{ route('laporan.monev.index') }}" class="nav-link"><i
                        class="fas fa-file-invoice"></i><span>Laporan</span></a>
            </li>

        </ul>
    </div>
</nav>

@push('script')
<script>
    $(document).ready(function () {
        $('#swalRole').click(function () {
            Swal.fire({
                title: 'Pilih Role Anda',
                input: 'select',
                inputOptions: {
                    P3AI: 'P3AI',
                    Dosen: 'Dosen',
                    Kaprodi: 'Kaprodi',
                },
                inputPlaceholder: 'Pilih Role',
                showCancelButton: true,

            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        'Akun berganti Role ' + result.value,
                        '',
                        'success'
                    )
                }
            })

        })
    })

</script>
@endpush
