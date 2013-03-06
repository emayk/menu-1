@include ('menu::common.header')

<h2>Adding a custom menu item type</h2>

<?php
Menu::createType(
    'custom',
    function ($string = '') {
        return '<blockquote>' . $string . '</blockquote>';
    }
);
?>

<h6>Code</h6>
<?php
$str = "Menu::createType(
    'custom',
    function (\$string = '') {
        return '<blockquote>' . \$string . '</blockquote>';
    }
);";
echo '<?prettify lang=php?><pre>' . e($str) . '</pre>';
?>

<h2><code>custom</code></h2>
<small>
    LI element should have a blocquoted string
</small>

{{ Menu::createItem('custom-type', 'custom', 0, array(), 'Sample string') }}
{{ Menu::get('custom-type', array('class'=>'navigation')) }}
<h6>Code</h6>
<?php
$str = "Menu::createItem('custom-type', 'custom', 0, array(), 'Sample string');
Menu::get('custom-type', array('class'=>'navigation'));";
echo '<?prettify lang=php?><pre>' . e($str) . '</pre>';
?>


@include ('menu::common.footer')
