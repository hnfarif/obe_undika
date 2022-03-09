<div class="navbar-bg"></div>
<nav class="navbar fixed-top navbar-expand-lg main-navbar ">
    <a href="index.html" class="navbar-brand sidebar-gone-hide">OBE Undika</a>
    <div class="navbar-nav">
        <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
    </div>
    {{-- <div class="nav-collapse">
        <a class="sidebar-gone-show nav-collapse-toggle nav-link" href="#">
            <i class="fas fa-ellipsis-v"></i>
        </a>
        <ul class="navbar-nav">
            <li class="nav-item active"><a href="#" class="nav-link">Application</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Report Something</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Server Status</a></li>
        </ul>
    </div> --}}
    <form class="form-inline mr-auto">
        <ul class="navbar-nav">
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>
        <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>
            <div class="search-result">
                <div class="search-header">
                    Histories
                </div>
                <div class="search-item">
                    <a href="#">How to hack NASA using CSS</a>
                    <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                </div>
                <div class="search-item">
                    <a href="#">Kodinger.com</a>
                    <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                </div>
                <div class="search-item">
                    <a href="#">#Stisla</a>
                    <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                </div>
                <div class="search-header">
                    Result
                </div>
                <div class="search-item">
                    <a href="#">
                        <img class="mr-3 rounded" width="30" src="../assets/img/products/product-3-50.png"
                            alt="product">
                        oPhone S9 Limited Edition
                    </a>
                </div>
                <div class="search-item">
                    <a href="#">
                        <img class="mr-3 rounded" width="30" src="../assets/img/products/product-2-50.png"
                            alt="product">
                        Drone X2 New Gen-7
                    </a>
                </div>
                <div class="search-item">
                    <a href="#">
                        <img class="mr-3 rounded" width="30" src="../assets/img/products/product-1-50.png"
                            alt="product">
                        Headphone Blitz
                    </a>
                </div>
                <div class="search-header">
                    Projects
                </div>
                <div class="search-item">
                    <a href="#">
                        <div class="search-icon bg-danger text-white mr-3">
                            <i class="fas fa-code"></i>
                        </div>
                        Stisla Admin Template
                    </a>
                </div>
                <div class="search-item">
                    <a href="#">
                        <div class="search-icon bg-primary text-white mr-3">
                            <i class="fas fa-laptop"></i>
                        </div>
                        Create a new Homepage Design
                    </a>
                </div>
            </div>
        </div>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Notifications
                    <div class="float-right">
                        <a href="#">Mark All As Read</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-icon bg-primary text-white">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            Template update is available now!
                            <div class="time text-primary">2 Min Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon bg-info text-white">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>You</b> and <b>Dedik Sugiharto</b> are now friends
                            <div class="time">10 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon bg-success text-white">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Kusnaedi</b> has moved task <b>Fix bug header</b> to <b>Done</b>
                            <div class="time">12 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon bg-danger text-white">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            Low disk space. Let's clean it!
                            <div class="time">17 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon bg-info text-white">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            Welcome to Stisla template!
                            <div class="time">Yesterday</div>
                        </div>
                    </a>
                </div>
                <div class="dropdown-footer text-center">
                    <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li>
        <li class="my-2 mx-3">
            <input type="checkbox" class="chk-dark-light" id="chk" />
            <label class="lbl-dark-light" for="chk">
                <i class="fas fa-moon"></i>
                <i class="fas fa-sun"></i>
                <div class="ball"></div>
            </label>
        </li>
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, Ujang Maman</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Logged in 5 min ago</div>
                <a href="#" type="button" class="dropdown-item has-icon" id="swalRole">
                    <i class="fas fa-user-tag"></i> Change Role
                </a>

                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>

<nav class="navbar navbar-secondary navbar-expand-lg">
    <div class="container">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="#" data-toggle="dropdown" class="nav-link"><i
                        class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="nav-item @yield('peoplo')">
                <a href="{{ route('peoplo.peo') }}" class="nav-link"><i class="fas fa-table"></i><span>Kelola
                        PEO-PLO</span></a>
            </li>
            <li class="nav-item @yield('rps')">
                <a href="{{ route('rps.index') }}" class="nav-link"><i class="fas fa-school"></i><span>Kelola
                        RPS</span></a>
            </li>
            <li class="nav-item @yield('instrumen-nilai')">
                <a href="{{ route('kelola.instrumen-nilai') }}" class="nav-link"><i
                        class="fas fa-table"></i><span>Instrumen
                        Nilai</span></a>
            </li>
            <li class="nav-item @yield('plottingmonev')">
                <a href="{{ route('kelola.plotting') }}" class="nav-link"><i
                        class="fas fa-vector-square"></i><span>Plotting
                        Monev</span></a>
            </li>
            {{-- <li class="nav-item dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link has-dropdown"><i
                        class="far fa-clone"></i><span>Multiple Dropdown</span></a>
                <ul class="dropdown-menu">
                    <li class="nav-item"><a href="#" class="nav-link">Not Dropdown Link</a></li>
                    <li class="nav-item dropdown"><a href="#" class="nav-link has-dropdown">Hover Me</a>
                        <ul class="dropdown-menu">
                            <li class="nav-item"><a href="#" class="nav-link">Link</a></li>
                            <li class="nav-item dropdown"><a href="#" class="nav-link has-dropdown">Link
                                    2</a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item"><a href="#" class="nav-link">Link</a></li>
                                    <li class="nav-item"><a href="#" class="nav-link">Link</a></li>
                                    <li class="nav-item"><a href="#" class="nav-link">Link</a></li>
                                </ul>
                            </li>
                            <li class="nav-item"><a href="#" class="nav-link">Link 3</a></li>
                        </ul>
                    </li>
                </ul>
            </li> --}}

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
