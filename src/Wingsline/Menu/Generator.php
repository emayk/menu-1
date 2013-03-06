<?php

namespace Wingsline\Menu;

class Generator
{
    /**
     * Menu element, default: ul
     */
    const ELEMENT = 'ul';

    /**
     * Menu item element
     */
    const ITEMELEMENT = 'li';

    public $ItemTypes;

    public function buildAll ($menus, $menuItems)
    {
        $this->ItemTypes = MenuFacade::getItemTypes();

        if (empty($menus) || empty($menuItems)) {
            return;
        }
        // we build all the menu items
        foreach ($menuItems as $menuItem) {
            $this->itemHtml($menuItem);
        }

        // we build the menu's html
        foreach ($menus as $menu) {
            $this->menuHtml($menu);
        }
    }

    // --------------------------------------------------------------
    // Protected functions
    // --------------------------------------------------------------
    public function menuHtml ($menu)
    {
        if (isset($menu->openingTag) && isset($menu->closingTag)) {
            return;
        }
        $menu->openingTag = "<" . static::ELEMENT;
        $menu->openingTag .= $this->ItemTypes->attributes($menu->html_attrs);
        $menu->openingTag .= ">";
        $menu->closingTag = "\n</" . static::ELEMENT . '>';
    }

    /**
     * Builds the menu item's html
     * 
     * @param  array $menuItems
     * @return void
     */
    public function itemHtml (&$menuItems)
    {
        foreach ($menuItems as $item) {
            if (isset($item->html)) {
                continue;
            }
            $item->html = "\n<" . static::ITEMELEMENT;
            $item->html .= $this->ItemTypes->attributes($item->html_attrs);
            $item->html .= '>';
            $item->html .= call_user_func_array(array($this->ItemTypes, $item->item_type), $item->type_attrs);
            $item->html .= '</' . static::ITEMELEMENT . '>';
        }
    }
}
