@include ('menu::common.itemheader')

        <div class="cell">
            {{ Form::label($menuItemType . '_' . $placeholder . '_name', 'Menu name *') }}
            {{ Form::text($menuItemType . '[' . $placeholder . '][name]', $name, array('id'=>$menuItemType . '_' . $placeholder . '_name', 'class'=>'text-input update-title', 'placeholder' => 'mymenu')) }}
        </div>
        <div class="cell">
            {{ Form::label($menuItemType . '_default_' . $placeholder . '', 'Default (if no items exist in the menu)') }}
            {{ Form::text($menuItemType . '[' . $placeholder . '][default]', $default, array('id'=>$menuItemType . '_' . $placeholder . '_default', 'class'=>'text-input', 'placeholder' =>'<p>No menu items</p>')) }}
        </div>
        <div class="cell cell--small">
            {{ Form::label($menuItemType . '_order_' . $placeholder . '', 'Order #') }}
            {{ Form::text($menuItemType . '[' . $placeholder . '][order]', $order, array('id'=>$menuItemType . '_' . $placeholder . '_order', 'class'=>'text-input', 'placeholder'=>'0')) }}
        </div>
        <div class="cell cell--small">&nbsp;</div>
        <div class="cell">
            {{ Form::label($menuItemType . '_label_' . $placeholder . '', 'Label (Html before UL)') }}
            {{ Form::text($menuItemType . '[' . $placeholder . '][label]', $label, array('id'=>$menuItemType . '_' . $placeholder . '_label', 'class'=>'text-input', 'placeholder' =>'<a href="#">Menu</a>')) }}
        </div>
        <div class="cf"></div>
        @include ('menu::common.htmlattribute')
        <div class="cf"></div>
    </div>
</div>


