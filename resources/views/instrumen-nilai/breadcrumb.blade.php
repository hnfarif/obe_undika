<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <?php $link = "" ?>
        @for($i = 1; $i <= count(Request::segments()); $i++) @if($i < count(Request::segments()) & $i> 0)
            <?php $link .= "/" . Request::segment($i); ?>
            <li class="breadcrumb-item active" aria-current="page">
                <a href="<?= $link ?>">{{ucwords(str_replace('-',' ',Request::segment($i)))}}</a>
            </li>

            @else
            <li class="breadcrumb-item">
                <a href="<?= $link ?>">{{ucwords(str_replace('-',' ',Request::segment($i)))}}</a>
            </li>
            @endif
            @endfor
    </ol>
</nav>
