@include ('menu::common.header')

<p>This page will let you create a new menu.</p>
<span class="frame"><a href="{{ \URL::route('admin.index')}}"><strong>Back to the menu list</strong></a></span>
<h2>Create new menu</h2>

@include ('menu::common.messages')


{{ Form::open(array('method'=>'post', 'route'=>'admin.store')) }}
{{ Form::token() }}

{{-- menu name --}}
{{ Form::label('menu-name', 'Menu name') }}
{{ Form::text('menu-name', Input::old('menu-name'), array('class'=>'text-input')) }}

<h4>Menu items</h4>
<div class="menuitems">
    @if (count(Session::get('items')))
        @foreach (Session::get('items') as $item)
            {{ $item }}
        @endforeach
    @endif
</div>
<hr>
{{ Form::hidden ('menuitem__counter', count(Session::get('items'))) }}
{{ Form::label('menuitem__type', 'Menu item type ', array('class'=>'inline'))}}
{{ Form::select('menuitem__type', $itemTypes )}} 
<a href="#" class="sign menuitems__new" data-url="{{ \URL::route('admin.itemtype') }}">+</a>

<hr>
<p>{{ Form::submit('Create') }}</p>
{{ Form::close() }}

@include ('menu::common.footer')
