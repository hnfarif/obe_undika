<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Instrumen CLO</a></li>
        <?php $link = "" ?>
        @for($i = 1; $i <= count(Request::segments()); $i++) @if($i < count(Request::segments()) & $i> 0)
            <?php $link .= "/" . Request::segment($i); ?>
            <li class="breadcrumb-item @yield('active-halaman')" @yield('aria')><a
                    href="<?= $link ?>">@yield('nama-halaman')</a>
            </li>

            @else
            {{ucwords(str_replace('-',' ',Request::segment($i)))}}
            @endif
            @endfor
    </ol>
</nav>
