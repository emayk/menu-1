@include ('menu::common.itemheader')
        <div class="cell cell--small">
            {{ Form::label($menuItemType . '_' . $placeholder .'_order', 'Order #') }}
            {{ Form::text($menuItemType . '[' . $placeholder .'][order]', $order, array('id'=>$menuItemType . '_' . $placeholder .'_order', 'class'=>'text-input', 'placeholder'=>'0')) }}
        </div>
        @include ('menu::common.attributes')
    </div>
</div>


