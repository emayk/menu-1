@include ('menu::common.header')
<h2>Simple menu</h2>
{{ Menu::createItem ('misc-links', 'link', 0, array(), 'http://wingsline.com', 'Wingsline') }}
{{ Menu::createItem ('misc-links', 'link', 0, array(), 'http://apple.com', 'Apple') }}
{{ Menu::createItem ('misc-links', 'link', 0, array(), 'http://google.com', 'Google') }}
{{ Menu::createItem ('misc-links', 'link', 0, array(), 'http://twitter.com', 'Twitter') }}
{{ Menu::get('misc-links') }}

<h6>Code</h6>
<?php
$str = "Menu::createItem ('misc-links', 'link', 0, array(), 'http://wingsline.com', 'Wingsline');
Menu::createItem ('misc-links', 'link', 0, array(), 'http://apple.com', 'Apple');
Menu::createItem ('misc-links', 'link', 0, array(), 'http://google.com', 'Google');
Menu::createItem ('misc-links', 'link', 0, array(), 'http://twitter.com', 'Twitter');
Menu::get('misc-links');";
echo '<?prettify lang=php?><pre>' . e($str) . '</pre>';
?>

<h2>Nested submenus</h2>

{{ Menu::createItem ('nested-submenu', 'link', 0, array(), 'http://store.apple.com/', 'Store') }}
{{ Menu::createItem ('nested-submenu', 'link', 0, array(), 'http://www.apple.com/mac/', 'Mac') }}
{{ Menu::createItem ('nested-submenu', 'link', 0, array(), 'http://www.apple.com/ipod/', 'iPod') }}
{{ Menu::createItem ('nested-submenu', 'link', 0, array(), 'http://www.apple.com/iphone/', 'iPhone') }}
{{ Menu::createItem ('nested-submenu', 'link', 0, array(), 'http://www.apple.com/ipad/', 'iPad') }}
{{ Menu::createItem ('nested-submenu', 'link', 0, array(), 'http://www.apple.com/itunes/', 'iTunes') }}
{{ Menu::createItem ('nested-submenu', 'link', 0, array(), 'http://www.apple.com/support/', 'Support') }}

{{ Menu::createItem ('nested', 'menu', 0, array(), 'nested-submenu', array(), null, '<strong>Apple links</strong>')}}
{{ Menu::get('nested') }}

<h6>Code</h6>
<?php
$str = "Menu::createItem ('nested-submenu', 'link', 0, array(), 'http://store.apple.com/', 'Store');
Menu::createItem ('nested-submenu', 'link', 0, array(), 'http://www.apple.com/mac/', 'Mac');
Menu::createItem ('nested-submenu', 'link', 0, array(), 'http://www.apple.com/ipod/', 'iPod');
Menu::createItem ('nested-submenu', 'link', 0, array(), 'http://www.apple.com/iphone/', 'iPhone');
Menu::createItem ('nested-submenu', 'link', 0, array(), 'http://www.apple.com/ipad/', 'iPad');
Menu::createItem ('nested-submenu', 'link', 0, array(), 'http://www.apple.com/itunes/', 'iTunes');
Menu::createItem ('nested-submenu', 'link', 0, array(), 'http://www.apple.com/support/', 'Support');

Menu::createItem ('nested', 'menu', 0, array(), 'nested-submenu', array(), null, '<strong>Apple links</strong>');
Menu::get('nested');";
echo '<?prettify lang=php?><pre>' . e($str) . '</pre>';
?>

<h2>Simple database menu</h2>

{{ Menu::get('db-links') }}

<h6>Code</h6>
<?php
$str = "Menu::get('db-links');";
echo '<?prettify lang=php?><pre>' . e($str) . '</pre>';
?>

<h2>Nested database submenus</h2>

{{ Menu::get('db-nested') }}

<h6>Code</h6>
<?php
$str = "Menu::get('db-nested');";
echo '<?prettify lang=php?><pre>' . e($str) . '</pre>';
?>

<h2>Mixed runtime and database menus</h2>

{{ Menu::createItem ('mixed-links', 'link', 0, array(), 'http://wingsline.com', 'Runtime') }}
{{ Menu::get('mixed-links') }}

<h6>Code</h6>
<?php
$str = "Menu::createItem ('mixed-links', 'link', 0, array(), 'http://wingsline.com', 'Runtime');
Menu::get('mixed-links');";
echo '<?prettify lang=php?><pre>' . e($str) . '</pre>';
?>

<h2>Mixed nested</h2>

{{ Menu::createItem('mixed-nested', 'link', 0, array(), 'http://wingsline.com', 'This is a runtime menu item') }}
{{ Menu::createItem('mixed-nested', 'menu', 0, array(), 'db-nested-submenu', array(), null, '<strong>Menu from db:</strong>') }}
{{ Menu::createItem('mixed-nested', 'menu', 0, array(), 'misc-links', array(), null, '<strong>Runtime menu:</strong>') }}
{{ Menu::get('mixed-nested') }}

<h6>Code</h6>
<?php
$str = "Menu::createItem('mixed-nested', 'link', 0, array(), 'http://wingsline.com', 'This is a runtime menu item');
Menu::createItem('mixed-nested', 'menu', 0, array(), 'db-nested-submenu', array(), null, '<strong>Menu from db:</strong>');
Menu::createItem('mixed-nested', 'menu', 0, array(), 'misc-links', array(), null, '<strong>Runtime menu:</strong>');
Menu::get('mixed-nested');";
echo '<?prettify lang=php?><pre>' . e($str) . '</pre>';
?>

<h2>Deep nested</h2>

<?php
$max = 24;
for ($i=0; $i <= $max; $i++) {
    Menu::createItem('deep-nested' . $i, 'link', 0, array(), 'http://wingsline.com#nested-' . $i, 'Level ' . $i);
    if ($max != $i) {
        Menu::createItem('deep-nested' . $i, 'menu', 0, array(), 'deep-nested' . ($i + 1));
    }
}
?>
{{ Menu::createItem('deep-nested', 'menu', 0, array(), 'deep-nested0') }}
{{ Menu::get('deep-nested') }}

<h6>Code</h6>
<?php
$str = "
// loop the following $max times
Menu::createItem('deep-nested' . \$i, 'link', 0, array(), 'http://wingsline.com#nested-' . \$i, 'Level ' . \$i);
Menu::createItem('deep-nested' . \$i, 'menu', 0, array(), 'deep-nested' . (\$i + 1))
// end loop
Menu::createItem('deep-nested', 'menu', 0, array(), 'deep-nested0');
Menu::get('deep-nested');";
echo '<?prettify lang=php?><pre>' . e($str) . '</pre>';
?>

<h2>Internal Cache testing: </h2>
<p>These menus are the same, so they need to be called from cache since they were rendered already</p>

<?php
for ($i=0; $i <= $max; $i++) {
    echo Menu::get('deep-nested');
    echo '<h6>Code</h6>';
    echo '<?prettify lang=php?><pre>' . e("Menu::get('deep-nested')") . '</pre>';
}
?>

@include ('menu::common.footer')
