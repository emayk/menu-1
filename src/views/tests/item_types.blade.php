@include ('menu::common.header')

<h2><code>html</code></h2>
<small>
    LI element should have the content <code>{{{ '<strong>HTML content</strong>'}}}</code>
</small>
{{ Menu::createItem('type-html', 'html', 0, array(), '<strong>HTML content</strong>') }}
{{ Menu::get('type-html') }}
<h6>Code</h6>
<?php
$str = "Menu::createItem('type-html', 'html', 0, array(), '<strong>HTML content</strong>');
Menu::get('type-html');";
echo '<?prettify lang=php?><pre>' . e($str) . '</pre>';
?>


<h2><code>link</code></h2>
<small>
    LI element should have the content <code>{{{ '<a href="http://wingsline.com">Wingsline</a>'}}}</code>
</small>
{{ Menu::createItem('type-link', 'link', 0, array(), 'http://wingsline.com', 'Wingsline') }}
{{ Menu::get('type-link') }}
<h6>Code</h6>
<?php
$str = "Menu::createItem('type-link', 'link', 0, array(), 'http://wingsline.com', 'Wingsline');
Menu::get('type-link');";
echo '<?prettify lang=php?><pre>' . e($str) . '</pre>';
?>


<h2><code>route</code></h2>
<small>
    LI element should have the a link to the test list
</small>
{{ Menu::createItem('type-route', 'route', 0, array(), 'tests.index', 'Test list') }}
{{ Menu::get('type-route') }}
<h6>Code</h6>
<?php
$str = "Menu::createItem('type-route', 'route', 0, array(), 'tests.index', 'Test list');
Menu::get('type-route');";
echo '<?prettify lang=php?><pre>' . e($str) . '</pre>';
?>


<h2><code>menu</code></h2>
<small>
    First LI element should have another UL menu
</small>
{{ Menu::createItem ('nested-type-menu', 'link', 0, array(), 'http://store.apple.com/', 'Store') }}
{{ Menu::createItem ('nested-type-menu', 'link', 0, array(), 'http://www.apple.com/mac/', 'Mac') }}
{{ Menu::createItem ('nested-type-menu', 'link', 0, array(), 'http://www.apple.com/ipod/', 'iPod') }}
{{ Menu::createItem ('nested-type-menu', 'link', 0, array(), 'http://www.apple.com/iphone/', 'iPhone') }}
{{ Menu::createItem ('nested-type-menu', 'link', 0, array(), 'http://www.apple.com/ipad/', 'iPad') }}
{{ Menu::createItem ('nested-type-menu', 'link', 0, array(), 'http://www.apple.com/itunes/', 'iTunes') }}
{{ Menu::createItem ('nested-type-menu', 'link', 0, array(), 'http://www.apple.com/support/', 'Support') }}

{{ Menu::createItem ('type-menu', 'menu', 0, array(), 'nested-type-menu', array(), null, '<strong>Apple links</strong>')}}
{{ Menu::get('type-menu') }}

<h6>Code</h6>
<?php
$str = "Menu::createItem ('nested-type-menu', 'link', 0, array(), 'http://store.apple.com/', 'Store');
Menu::createItem ('nested-type-menu', 'link', 0, array(), 'http://www.apple.com/mac/', 'Mac');
Menu::createItem ('nested-type-menu', 'link', 0, array(), 'http://www.apple.com/ipod/', 'iPod');
Menu::createItem ('nested-type-menu', 'link', 0, array(), 'http://www.apple.com/iphone/', 'iPhone');
Menu::createItem ('nested-type-menu', 'link', 0, array(), 'http://www.apple.com/ipad/', 'iPad');
Menu::createItem ('nested-type-menu', 'link', 0, array(), 'http://www.apple.com/itunes/', 'iTunes');
Menu::createItem ('nested-type-menu', 'link', 0, array(), 'http://www.apple.com/support/', 'Support');

Menu::createItem ('type-menu', 'menu', 0, array(), 'nested-type-menu', array(), null, '<strong>Apple links</strong>');
Menu::get('type-menu');";
echo '<?prettify lang=php?><pre>' . e($str) . '</pre>';
?>

@include ('menu::common.footer')
