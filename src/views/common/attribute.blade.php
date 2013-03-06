<div class="cell">
    {{ Form::label($menuItemType . '_' . $placeholder . '_attr', 'Property') }}
    @if (isset($attrs) && count($attrs))
        @foreach ($attrs as $attr)
            {{ Form::text($menuItemType . '[' . $placeholder . '][attr][]', $attr, array('class'=>'text-input', 'placeholder'=>'item')) }}
            <a href="#" class="removeattr sign alert">&times;</a>
        @endforeach
    @endif
    {{ Form::text($menuItemType . '[' . $placeholder . '][attr][]', null, array('id'=>$menuItemType . '_' . $placeholder . '_attr', 'class'=>'text-input', 'placeholder'=>'item')) }}
    <a href="#" class="removeattr sign alert hidden">&times;</a>
    <br>
    <a href="#" class="sign addattr">+</a>
</div>
