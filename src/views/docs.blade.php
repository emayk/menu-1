@include ('menu::common.header')
<a name="top"></a>
<nav class="sidenav">
    <ul>
        <li>Table of Contents
            <ul>
                @foreach ($toc as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </li>
    </ul>
</nav>
<div class="doc-content">
    {{ $content }}
</div>
<div class="cf"></div>
@include ('menu::common.footer')
