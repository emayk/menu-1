@include ('menu::common.itemheader')

        <div class="cell">
            {{ Form::label($menuItemType . '_' . $placeholder . '_url', 'URL *') }}
            {{ Form::text($menuItemType . '[' . $placeholder . '][url]', $url, array('id'=>$menuItemType . '_' . $placeholder . '_url', 'class'=>'text-input', 'placeholder' => 'http://wingsline.com')) }}
        </div>
        <div class="cell">
            {{ Form::label($menuItemType . '_' . $placeholder . '_text', 'Text') }}
            {{ Form::text($menuItemType . '[' . $placeholder . '][text]', $text, array('id'=>$menuItemType . '_' . $placeholder . '_text', 'class'=>'text-input update-title', 'placeholder' =>'Wingsline')) }}
        </div>
        <div class="cell cell--small">
            {{ Form::label($menuItemType . '_' . $placeholder . '_order', 'Order #') }}
            {{ Form::text($menuItemType . '[' . $placeholder . '][order]', $order, array('id'=>$menuItemType . '_' . $placeholder . '_order', 'class'=>'text-input', 'placeholder'=>'0')) }}
        </div>
        <div class="cell cell--small">
            {{ Form::label($menuItemType . '_' . $placeholder . '_https', 'Force HTTPS') }}
            {{ Form::select($menuItemType . '[' . $placeholder . '][https]', array('0'=>'No', '1'=>'Yes'), $https, array('id'=>$menuItemType . '_' . $placeholder . '_https'))}}
        </div>
        @include ('menu::common.attributes')
    </div>
</div>


