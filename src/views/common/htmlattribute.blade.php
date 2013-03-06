<div class="cell cell--small">
    {{ Form::label($menuItemType . '_' . $placeholder . '_htmlattrname', 'Html Attribute Name') }}
    @if (isset($htmlAttrs))
        @foreach (array_keys($htmlAttrs) as $key)
            {{ Form::text($menuItemType . '[' . $placeholder . '][htmlattrname][]', $key, array('class'=>'text-input', 'placeholder'=>'class')) }}
        @endforeach
    @endif
    {{ Form::text($menuItemType . '[' . $placeholder . '][htmlattrname][]', null, array('id'=>$menuItemType . '_' . $placeholder . '_htmlattrname', 'class'=>'text-input', 'placeholder'=>'class')) }}
    <br>
    <a href="#" class="sign addhtmlattr">+</a>
</div>
<div class="cell cell--small">
    {{ Form::label($menuItemType . '_' . $placeholder . '_htmlattrvalue', 'Html Attribute Value') }}
    @if (isset($htmlAttrs))
        @foreach (array_values($htmlAttrs) as $value)
            {{ Form::text($menuItemType . '[' . $placeholder . '][htmlattrvalue][]', $value, array('class'=>'text-input', 'placeholder'=>'menu__item')) }}
            <a href="#" class="removehtmlattr sign alert">&times;</a>
        @endforeach
    @endif
    {{ Form::text($menuItemType . '[' . $placeholder . '][htmlattrvalue][]', null, array('id'=>$menuItemType . '_' . $placeholder . '_htmlattrvalue', 'class'=>'text-input', 'placeholder'=>'menu__item')) }}
    <a href="#" class="removehtmlattr sign alert hidden">&times;</a>
</div>
