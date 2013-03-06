<!-- {{ $menuItemType }} -->
<div class="menuitem">
    <hr>
    <h6>
        <a href="#" class="sign toggle">
            <span><?php echo $_closed ? '&#9658;' : '&#9660;';?></span> {{ ucwords($menuItemType) }} 
        </a> 
        <q class="update">{{ $text }}</q>
        [<a href="#" class="remove alert">remove</a>]
    </h6>
    @if ($_closed)
        <div class="hidden">
    @else
        <div>
    @endif
