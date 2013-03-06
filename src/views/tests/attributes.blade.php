@include ('menu::common.header')

<h2>Menu attributes</h2>

<h5>Menu with html attributes:</h5>

<small>
    UL element should have a <code>class = "navigation"</code>
</small>

{{ Menu::createItem('html-attrs', 'link', 0, array(), 'http://wingsline.com', 'Wingsline') }}
{{ Menu::get('html-attrs', array('class'=>'navigation')) }}
<h6>Code</h6>
<?php
$str = "Menu::createItem('html-attrs', 'link', 0, array(), 'http://wingsline.com', 'Wingsline');
Menu::get('html-attrs', array('class'=>'navigation'));";
echo '<?prettify lang=php?><pre>' . e($str) . '</pre>';
?>
<small>
    UL element should have a <code>class = "navigation"</code> and a <code>data-property = "value"</code>
</small>
{{ Menu::get('html-attrs', array('class'=>'navigation', 'data-property' => 'value')) }}
<h6>Code</h6>
<?php
$str = "Menu::get('html-attrs', array('class'=>'navigation', 'data-property' => 'value'))";
echo '<?prettify lang=php?><pre>' . e($str) . '</pre>';
?>
<h5>Submenu with html attributes</h5>
<small>
    Submenu UL element should have a <code>class = "navigation"</code>
</small>
{{ Menu::createItem('sub-html-attrs', 'link', 0, array(), 'http://wingsline.com', 'Wingsline') }}
{{ Menu::createItem('submenu-html-attrs', 'menu', 0, array(), 'sub-html-attrs', array('class'=>'navigation'))}}
{{ Menu::get('submenu-html-attrs') }}
<h6>Code</h6>
<?php
$str = "Menu::createItem('sub-html-attrs', 'link', 0, array(), 'http://wingsline.com', 'Wingsline');
Menu::createItem('submenu-html-attrs', 'menu', 0, array(), 'sub-html-attrs', array('class'=>'navigation'));
Menu::get('submenu-html-attrs');";
echo '<?prettify lang=php?><pre>' . e($str) . '</pre>';
?>
<h2>Menu labels</h2>

<p>Labels can be added only to submenus, on menus they are ignored</p>

<h5>Submenu with label:</h5>
<small>
    Submenu UL LI element should have a <code><a href="http://wingsline.com">Link</a></code> before the submenu's <code>UL</code>
</small>

{{ Menu::createItem('sub-html-label', 'link', 0, array(), 'http://wingsline.com', 'Wingsline') }}
{{ Menu::createItem('submenu-html-label', 'menu', 0, array(), 'sub-html-attrs', array(), null, '<a href="http://wingsline.com">Link</a>')}}
{{ Menu::get('submenu-html-label') }}

<h6>Code</h6>
<?php
$str = "Menu::createItem('sub-html-label', 'link', 0, array(), 'http://wingsline.com', 'Wingsline');
Menu::createItem('submenu-html-label', 'menu', 0, array(), 'sub-html-attrs', array(), null, '<a href=\"http://wingsline.com\">Link</a>');
Menu::get('submenu-html-label');";
echo '<?prettify lang=php?><pre>' . e($str) . '</pre>';
?>

<h2>Menu defaults</h2>
<p>When a menu doesn't contain menu items, we can display a html instead of the menu</p>

<h5>Empty menu with default value set</h5>
<small>
    Instead of the menu there should be an <code>Empty menu</code> text.
</small>

{{ Menu::get('menu-empty', array(), '<p>Empty menu</p>') }}
<h6>Code</h6>
<?php
$str = "Menu::get('menu-empty', array(), '<p>Empty menu</p>');";
echo '<?prettify lang=php?><pre>' . e($str) . '</pre>';
?>
<h5>Empty submenu with default value set</h5>
<small>
    Instead of the submenu there should be an <code>Empty submenu</code> text.
</small>

{{ Menu::createItem('submenumenu-empty', 'menu', 0, array(), 'sub-empty', array(), 'Empty submenu')}}
{{ Menu::get('submenumenu-empty') }}

<h6>Code</h6>
<?php
$str = "Menu::createItem('submenumenu-empty', 'menu', 0, array(), 'sub-empty', array(), 'Empty submenu');
Menu::get('submenumenu-empty');";
echo '<?prettify lang=php?><pre>' . e($str) . '</pre>';
?>

<h2>Menu item attributes</h2>

<h5>Menu item with html attributes:</h5>
<small>
    LI element should have a <code>class = "navigation__item"</code>
</small>

{{ Menu::createItem('item-attrs', 'link', 0, array('class'=>'navigation__item'), 'http://wingsline.com', 'Wingsline') }}
{{ Menu::get('item-attrs') }}

<h6>Code</h6>
<?php
$str = "Menu::createItem('item-attrs', 'link', 0, array('class'=>'navigation__item'), 'http://wingsline.com', 'Wingsline');
Menu::get('item-attrs');";
echo '<?prettify lang=php?><pre>' . e($str) . '</pre>';
?>

<small>
    UL element should have a <code>class = "navigation__item"</code> and a <code>data-property = "value"</code>
</small>
{{ Menu::createItem('item-attrs-multiple', 'link', 0, array('class'=>'navigation__item', 'data-property'=>'value'), 'http://wingsline.com', 'Wingsline') }}
{{ Menu::get('item-attrs-multiple') }}

<h6>Code</h6>
<?php
$str = "Menu::createItem('item-attrs-multiple', 'link', 0, array('class'=>'navigation__item', 'data-property'=>'value'), 'http://wingsline.com', 'Wingsline')
Menu::get('item-attrs-multiple');";
echo '<?prettify lang=php?><pre>' . e($str) . '</pre>';
?>


@include ('menu::common.footer')
