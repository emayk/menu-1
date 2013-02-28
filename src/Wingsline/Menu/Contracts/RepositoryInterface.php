<?php

namespace Wingsline\Menu\Contracts;

interface RepositoryInterface
{
    /**
     * Returns a menu, this will be a placeholder until the finalize() is called
     * @param  string $menuName  Name of the menu
     * @param  array  $htmlAttrs Array of html attributes
     * @param  mixed  $default   If no menu items are present we display this content
     * @return mixed
     */
    public function get($menuName, array $htmlAttrs = array(), $default = null);

    /**
     * Creates a new menu item for a menu, if menu doesn't exists it will be created
     * @param  string  $menuName  Name of the menu
     * @param  string  $itemType  Menu item type
     * @param  integer $itemOrder Menu item order
     * @param  array   $htmlAttrs Array of html attributes
     * @return void
     */
    public function createItem($menuName, $itemType, $itemOrder = 0, $htmlAttrs = array());

    /**
     * Finalizes the menu. This function is automatically called in the filters.php
     * @param  \Illuminate\Http\Response $response
     * @return void
     */
    public function finalize(\Illuminate\Http\Response $response);
}
