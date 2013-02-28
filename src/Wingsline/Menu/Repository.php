<?php

namespace Wingsline\Menu;

use Wingsline\Menu\Contracts\RepositoryInterface;
use Rhumsaa\Uuid\Uuid;
use Rhumsaa\Uuid\Exception\UnsatisfiedDependencyException;
use Illuminate\Support\Contracts\JsonableInterface;
use Illuminate\Support\Contracts\RenderableInterface;

class Repository implements RepositoryInterface
{
    /**
     * Placeholder prefix
     */
    const PLACEHOLDERPREFIX = '{{menu::';

    /**
     * Placeholder suffix
     */
    const PLACEHOLDERSUFFIX = '}}';

    /**
     * Menu item types class
     * 
     * @var ItemTypes
     */
    public $ItemTypes;
    
    /**
     * Menu generator
     * @var Generator
     */
    public $Generator;

    /**
     * Menu eloquent model
     * 
     * @var Menu
     */
    public $Menu;

    /**
     * All the menus, {key} Menu uuid, {value} object, Menu data
     * 
     * @var array
     */
    protected $menus = array();

    /**
     * All the menu items, {key} Menu name, {value} array Menu items as objects
     * 
     * @var array
     */
    protected $menuItems = array();

    /**
     * These menu ids have been retrieved from the db already
     * 
     * @var array
     */
    protected $dbRetrieved = array();

    /**
     * All the built menus
     * 
     * @var array
     */
    protected $built = array();

    /**
     * Constructor
     * 
     * @param Menu      $Menu
     * @param ItemTypes $ItemTypes
     * @param Generator $Generator
     */
    public function __construct (Menu $Menu, ItemTypes $ItemTypes, Generator $Generator)
    {
        $this->Menu      = $Menu;
        $this->ItemTypes = $ItemTypes;
        $this->Generator = $Generator;
    }

    /**
     * Returns a menu, this will be a placeholder until the finalize() is called
     * @param  string $menuName  Name of the menu
     * @param  array  $htmlAttrs Array of html attributes
     * @param  mixed  $default   If no menu items are present we display this content
     * @return mixed
     */
    public function get($menuName, array $htmlAttrs = array(), $default = null, $label = null)
    {
        return $this->placeholder($this->create($menuName, $htmlAttrs, $default, $label));
    }


    /**
     * Creates a new menu object
     * @param  string $menuName  Name of the menu
     * @param  array  $htmlAttrs Array of html attributes
     * @param  mixed  $default   If no menu items present we display this content
     * @return string            Menu's uuid
     */
    public function create($menuName, array $htmlAttrs = array(), $default = null, $label = null)
    {
        $uuid = $this->uuid(array($menuName, $htmlAttrs, $default, $label));
        // check if the menu exists, if not create it and return it's uuid
        if (isset($this->menus[$uuid])) {
            return $this->menus[$uuid]->uuid;
        }
        $menu = new \stdClass;
        $menu->uuid = $uuid;
        $menu->menuName = $menuName;
        $menu->htmlAttrs = $htmlAttrs;
        $menu->default = $default;
        $menu->label = $label;
        $this->menus[$menu->uuid] = $menu;
        return $menu->uuid;
    }

    /**
     * Creates a new menu item for a menu, if menu doesn't exists it will be created
     * @param  string  $menuName  Name of the menu
     * @param  string  $itemType  Menu item type
     * @param  integer $itemOrder Menu item order
     * @param  array   $htmlAttrs Array of html attributes
     * @return void
     */
    public function createItem($menuName, $itemType, $itemOrder = 0, $htmlAttrs = array())
    {
        $menuItem = new \stdClass;
        $menuItem->menuName = $menuName;
        $menuItem->itemType = $itemType;
        $menuItem->itemOrder = $itemOrder;
        $menuItem->htmlAttrs = $htmlAttrs;
        $menuItem->typeAttrs = array_slice(func_get_args(), 4);
        // if the item type is a menu, we create that menu if doesn't exists
        if ($itemType == 'menu') {
            call_user_func_array(array($this, 'create'), $menuItem->typeAttrs);
        }
        $this->menuItems[$menuName][] = $menuItem;

    }

    /**
     * Finalizes the menu. This function is automatically called in the filters.php
     * @param  \Illuminate\Http\Response $response
     * @return void
     */
    public function finalize(\Illuminate\Http\Response $response)
    {

        // before we finalize the menus, we make sure we get the menu items
        // from the db for all the requested menus
        $menuNames = objectsGetProperty($this->menus, 'menuName');
        // if we don't have menus called we don't need to continue
        if (empty($menuNames)) {
            return;
        }
        $this->dbGetMenuItems($menuNames);
        $this->Generator->buildAll($this->menus, $this->menuItems);
        
        $replacements = $this->generateReplacements();

        $content = $response->getContent();
        while (strposa($content, $replacements['search']) !== false) {
            $content = str_replace($replacements['search'], $replacements['replace'], $content);
        }

        $response->setContent($content);
        
    }

    /**
     * Creates a menu uuid
     * 
     * @param  array  $data Menu properties
     * @return string
     */
    public function uuid ($data)
    {
        return Uuid::uuid5(Uuid::NAMESPACE_DNS, md5(json_encode((array) $data)))->toString();
    }

    public function getItemTypes()
    {
        return $this->ItemTypes;
    }

    /**
     * Creates a new menu type
     * 
     * @param  string   $typeName Menu type name
     * @param  \Closure $closure  Closure
     * @return void
     */
    public function createType ($typeName, \Closure $closure)
    {
        $this->ItemTypes->macro($typeName, $closure);
    }
    // --------------------------------------------------------------
    // Protected functions
    // --------------------------------------------------------------
    
    /**
     * Generate the search and replacemenents for the content
     * 
     * @return array {search} Items to be replaced, {replace} replacemenents
     */
    protected function generateReplacements ()
    {
        $replace = array();
        $search = array();
        foreach ($this->menus as $index => $menu) {

            // do we already built this menu? we just return the search and replace values
            if (isset($this->built[$menu->uuid])) {
                $search[$index] = $this->built[$menu->uuid]['search'];
                $replace[$index] = $this->built[$menu->uuid]['replace'];
                continue;
            }
            $search[$index] = $this->placeholder($menu->uuid);
            $replacement = $menu->label . $menu->openingTag;
            // check if we have menu items for this menu
            if (isset($this->menuItems[$menu->menuName])) {
                // sort the $menuItems by itemOrder property
                $this->menuItems[$menu->menuName] = array_reverse($this->menuItems[$menu->menuName]);
                usort(
                    $this->menuItems[$menu->menuName],
                    function ($itemA, $itemB) {
                        return strnatcmp($itemA->itemOrder, $itemB->itemOrder); // return (0 if ==), (-1 if <), (1 if >)
                    }
                );
                $replacement .= implode(objectsGetProperty($this->menuItems[$menu->menuName], 'html'));
                $replacement .= $menu->closingTag;
            } else {
                $replacement = $menu->default;
            }
            $replace[$index] = $replacement;
            $this->built[$menu->uuid]['search'] = $search[$index];
            $this->built[$menu->uuid]['replace'] = $replace[$index];
        }
        return array('search' => $search, 'replace' => $replace);
    }

    /**
     * Get the menu items from the db
     * @param  array $menuNames Menu names
     * @return void
     */
    protected function dbGetMenuItems($menuNames)
    {
        $menuItems = Menu::whereIn('menu_name', (array) $menuNames);
        // get only what we didn't get already
        if (count($this->dbRetrieved)) {
            $menuItems->whereNotIn('id', $this->dbRetrieved);
        }
        $menuItems = $menuItems->get();
        foreach ($menuItems as $menuItem) {
            $this->dbRetrieved[] = $menuItem->id;
            // we json_decode the attributes for the menu and create the menus
            $menuItem->typeAttrs = $menuItem->typeAttrs ? json_decode($menuItem->typeAttrs, true) : array();
            $menuItem->htmlAttrs = $menuItem->htmlAttrs ? json_decode($menuItem->htmlAttrs, true) : array();
            $params = array($menuItem->menuName, $menuItem->itemType, (int) $menuItem->itemOrder, $menuItem->htmlAttrs);
            $params = array_merge($params, array_values($menuItem->typeAttrs));
            call_user_func_array(array($this, 'createItem'), $params);
            // if the item is a menu type we need to get that menu items as well
            if ($menuItem->itemType == 'menu') {
                $this->dbGetMenuItems($params[4]);
            }
        }
    }

    /**
     * Creates a menu placeholder
     * 
     * @param string $string
     */
    public function placeholder ($string)
    {
        return static::PLACEHOLDERPREFIX . $string . static::PLACEHOLDERSUFFIX;
    }
}
