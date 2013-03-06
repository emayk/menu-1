@include ('menu::common.header')

<p>Edit the menu items for a menu.</p>
<span class="frame"><a href="{{ \URL::route('admin.index')}}"><strong>Back to the menu list</strong></a></span>
<h2>Edit menu: <a href="{{ URL::route('admin.show', array($menuName)) }}">{{ $menuName }}</a></h2>

@include ('menu::common.messages')

{{ Form::open(array('method'=>'put', 'route'=>array('admin.update', $menuName))) }}
{{ Form::token() }}

{{-- menu name --}}
{{ Form::label('menu-name', 'Menu name') }}
{{ Form::text('menu-name', Input::old('menu-name', $menuName), array('class'=>'text-input')) }}

<h4>Menu items</h4>
<div class="menuitems">
    @if (isset($items))
        @foreach ($items as $item)
            {{ $item }}
        @endforeach
    @endif
</div>
<hr>
{{ Form::label('menuitem__type', 'Menu item type ', array('class'=>'inline'))}}
{{ Form::select('menuitem__type', $itemTypes )}} 
<a href="#" class="sign menuitems__new" data-url="{{ \URL::route('admin.itemtype') }}">+</a>

<hr>
{{ Form::hidden ('menuitem__counter', count($items)) }}
<p>{{ Form::submit('Save') }}</p>
{{ Form::close() }}
<p><strong>Note:</strong> Removing all the menu items will <strong>delete</strong> the menu on save.</p>
<hr>
{{ Form::open(array('method'=>'delete', 'route'=>array('admin.destroy', $menuName))) }}
{{ Form::token() }}
{{ Form::submit('Delete this menu', array('class'=>'alert')) }} (It will only remove the menu from the database.)
{{ Form::close() }}
@include ('menu::common.footer')
