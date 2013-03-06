## Usage

- [Installation](#installation)
- [Adding Menu Items](#menuitems)
- [Displaying the Menus](#display)
- [Database Storage](#dbstorage)


<a name="installation"></a>
### Installation

Wingsline/Menu is available on Packagist ([wingsline/laravel-menu](http://packagist.org/packages/wingsline/laravel-menu))
and as such installable via [Composer](http://getcomposer.org/).

If you do not use Composer, you can grab the code from GitHub, and use any
PSR-0 compatible autoloader (e.g. the [Symfony2 ClassLoader component](https://github.com/symfony/ClassLoader))
to load Wingsline/Menu classes.

[Back to Top](#top)

<a name="menuitems"></a>
### Adding Menu Items

You can add runtime menu items, that are not permanent menus. 
These menus can be added anywhere in your code but before the laravel 
`App::after` ([Application Events](http://four.laravel.com/docs/lifecycle#application-events)) is run.

The order of the menu items doesn't matter, but if you want to set them in a 
specific order make sure you set the $itemOrder value.

###### Usage

<?prettify lang=php?>

    Menu::createItem ( string $menuName, string $itemType  [, int $itemOrder = 0, array $attributes, mixed $arguments…])


---

`$menuName` - Name of the menu (case-sensitive) where the item belongs. 
If the menu doesn't exists it will be automatically created. 
Example: `'admin'`

`$itemType` - Menu item type, must be one of the supported menu types. 
Default supported menu types are:

- [link](/wingsline/menu/docs/menutypes#link) - creates an HTML link
- [route](/wingsline/menu/docs/menutypes#route) - creates an HTML link based on an existing application route
- [html](/wingsline/menu/docs/menutypes#html) - adds the specified html code inside the LI element
- [menu](/wingsline/menu/docs/menutypes#menu) - creates a submenu

**Note:** You can extend the menu types, check out [extending](extending) the menu types.

`$itemOrder` - The menu item's order. The default value is `0`, so the menu 
items are displayed in the order they were added. If you want a menu item in 
a specific place just increment or decrement this value.

`$attributes` - HTML attributes in array format, example: 

`array('class' => 'nav__item')`

`$arguments…` - One or more arguments of the menu item. These values depend of 
the menu type. For more information about the menu types please check out 
the [menu item types](menutypes) documentation.


[Back to Top](#top)

<a name="display"></a>
### Displaying the Menus

Displaying a menu is simple. Just include the following in your view:


###### Usage

<?prettify lang=php?>

    Menu::get ( string $menuName [, array $attributes])


---

`$menuName` - Name of the menu (case-sensitive), example: 'admin'

`$attributes` - HTML attributes in array format, example:

`array('class' => 'nav')`

`$default` - If the menu doesn't have menu items (dynamically generated menus) 
you can use this content to populate the menus

**Note:** If you are wondering why there isn't a way to add menus? It's simple: 
**the menus are created automatically when a menu item added to a non-existent menu**.


###### Reusing the same menus with different html attributes

Want to display the same menu, except with a different style in the same page? 
No problem, just include the menu using `Menu::get()` with different html attributes.

###### Adding menu items AFTER the menu was called?

You can do that as well, since the menu's HTML code is not generated right away,
but when the `App::after` [event](http://four.laravel.com/docs/lifecycle#application-events) is run. 
So you can add menus where you like and add the menu items afterwards, the menu will be displayed properly.


[Back to Top](#top)
<a name="dbstorage"></a>
### Database storage

You can store the menus and their items in the database as well. 
This will enable you to manage them from an administration interface. There is even
an [menu editor](/wingsline/menu/admin) included in this package.

Menus stored in the database cannot have dynamic properties.

The menu editor included only works on local environment and it is not intended
for use in production environments.

[Back to Top](#top)
