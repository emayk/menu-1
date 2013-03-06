## Menu item types

- [link](#link)
- [route](#route)
- [menu](#menu)
- [html](#html)
- [custom](#custom)

<a name="link"></a>
### <code>link</code>

This menu type will generate a simple link to the specified URL. You can use relative URL or absolute URL as well.

<?prettify lang=php?>

    Menu::createItem('samplemenu', 'link', 0, array(), 'http://wingsline.com', 'Wingsline');

The result will be:

<?prettify lang=html?>

    <li>
        <a href="http://wingsline.com">Wingsline</a>
    </li>

[Back to Top](#top)

<a name="route"></a>
### <code>route</code>

Similar to the link, this menu item will generate also a link but instead of the url you can
specify a laravel application route name:

<?prettify lang=php?>

    Menu::createItem('samplemenu', 'route', 0, array(), 'home', 'Home page');

The result will be:

<?prettify lang=html?>

    <li>
        <a href="http://somesite.com">Home page</a>
    </li>



[Back to Top](#top)

<a name="menu"></a>
### <code>menu</code>

When you specify the menu item type as menu, you can include a menu as a submenu into
your menu.

<?prettify lang=php?>

    Menu::createItem('samplemenu', 'menu', 0, array(), 'submenuname');

The result will be:

<?prettify lang=html?>

    <li>
        <ul>
            <li>Submenu item 1</li>
            <li>...
        </ul>
    </li>

You can also specify a default content just in case the submenu doesn't have
any menu items:

<?prettify lang=php?>

    Menu::createItem('samplemenu', 'menu', 0, array(), 'submenuname', 'No menu items');

The generated menu item html will become:

<?prettify lang=html?>

    <li>
        No menu items
    </li>

Inserting content before the submenu's UL element has never been easier:

<?prettify lang=php?>

    Menu::createItem('samplemenu', 'menu', 0, array(), 'submenuname', null, '<a href="#">Submenu items</a>');

And the generated html will be:

<?prettify lang=html?>

    <li>
        <a href="#">Submenu items</a>
        <ul>
            <li>Submenu item 1</li>
            <li>...
        </ul>
    </li>

[Back to Top](#top)

<a name="html"></a>
### <code>html</code>

Sometimes a little html needs to be inserted into the menu between the menu links.
You can do that with the html menu item type:

<?prettify lang=php?>

    Menu::createItem('samplemenu', 'html', 0, array(), '<strong>This is a sample html</strong>');

Generated html:

<?prettify lang=html?>

    <li>
        <strong>This is a sample html</strong>
    </li>

[Back to Top](#top)

<a name="custom"></a>
### <code>custom</code>

If you ever need a custom menu type you can extend the menu by adding a new menu
item type. For more information see [extending the menu](extending).

[Back to Top](#top)
