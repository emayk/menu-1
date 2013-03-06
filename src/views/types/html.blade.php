@include ('menu::common.itemheader')

        <div class="cell cell--small">
            {{ Form::label($menuItemType . '_' . $placeholder .'_order', 'Order #') }}
            {{ Form::text($menuItemType . '[' . $placeholder .'][order]', $order, array('id'=>$menuItemType . '_' . $placeholder .'_order', 'class'=>'text-input', 'placeholder'=>'0')) }}
        </div>
        <div class="cf"></div>
        @include ('menu::common.htmlattribute')
        <div class="cf"></div>
        <br>
        {{ Form::label($menuItemType . '' . $placeholder .'_code', 'Html code *') }}
        {{ Form::textarea($menuItemType . '[' . $placeholder .'][code]', $code, array('id'=>$menuItemType . '' . $placeholder .'_code', 'class'=>'text-input text-input--wide', 'placeholder' => '<p>lorem...</p>')) }}
        <div class="cf"></div>
    </div>
</div>


