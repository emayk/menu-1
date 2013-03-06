@include ('menu::common.header')

<p>This is a preview of the menu. Depending on the html attributes the menu might look different.</p>
<span class="frame"><a href="{{ \URL::route('admin.index')}}"><strong>Back to the menu list</strong></a></span>
<h2>Showing the menu: {{ $menuName }} [<a href="{{ URL::route('admin.edit', array($menuName)) }}">edit</a>]</h2>

@include ('menu::common.messages')

<hr>
{{ $menu }}

@include ('menu::common.footer')
