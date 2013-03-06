<?php

namespace Wingsline\Menu\Controllers;

use Wingsline\Menu\Menu;
use Wingsline\Menu\MenuFacade;
use Wingsline\Menu\ItemTypesGrammar;

class MenuController extends \BaseController
{
    /**
     * Menu item types reflection instance
     * 
     * @var ItemTypesReflection
     */
    protected $menuItemTypes;

    /**
     * Required fields in for different menu item types
     *
     * @var array
     */
    protected $menuItemRequired = array(
        'link' => array('url'),
        'route' => array('route'),
        'menu'=> array('name')
    );

    /**
     * Constructor
     */
    public function __construct ()
    {
        // set the menu item types
        $this->menuItemTypes = MenuFacade::getItemTypes()->get();
        $this->ItemTypesGrammar = MenuFacade::getGrammar();
        $this->ItemBuilder = MenuFacade::getBuilder();
        \Validator::extend(
            'menunameunique',
            function ($attribute, $value, $parameters) {
                $count = \DB::table($parameters[0])
                    ->where($parameters[1], '!=', $parameters[2])
                    ->where($parameters[1], '=', $value)
                    ->count();
                return $count == 0;
            }
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // get the menus from the db
        $perPage = \Config::get('paginator.perPage', 15);
        $data = array();
        $data['timezone'] = new \DateTimeZone(\Config::get('app.timezone'));
        $data['menus'] = Menu::groupBy('menu_name')->orderBy('menu_name', 'asc')->paginate($perPage);
        return \View::make('menu::index', $data);
    }

    /**
     * Returns the item type html
     *
     * @param  boolean $menuItemType Name of the menu item type
     *
     * @return string                Json
     */
    public function itemType($menuItemType = false)
    {
        // simple menu item type validation
        if (!$menuItemType || !in_array($menuItemType, $this->menuItemTypes)) {
            \App::abort(404);
        }
        // create the view that will return the menu item type html form
        // get the item type arguments and build the item type form
        return \Response::json(
            array(
                'itemType' => $menuItemType,
                'html' => $this->ItemBuilder->$menuItemType(array(), $menuItemType)
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = array('menuItemTypes' => $this->menuItemTypes);
        foreach ($this->menuItemTypes as $itemType) {
            $data['itemTypes'][$itemType] = ucwords(str_replace('_', ' ', $itemType));
        }
        return \View::make('menu::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        // create the validation rules for each menu item type
        $inputAll = $this->removeInvalidItems(\Input::all());
        $rules = array ('menu-name' => 'required|alpha_dash|unique:menus,menu_name');
        $validator = \Validator::make($inputAll, $rules);
        if ($validator->fails()) {
            return \Redirect::route('admin.create')
                ->with('items', $this->ItemBuilder->fromInput($inputAll, $this->menuItemTypes, $this->ItemTypesGrammar))
                ->withErrors($validator)
                ->withInput(\Input::all());
        }
        // prepare the menu items array that will be inserted into the db
        $items = array();
        $menuName = \Input::get('menu-name');
        foreach ($this->menuItemTypes as $itemType) {
            if (!isset($inputAll[$itemType]) || empty($inputAll[$itemType])) {
                continue;
            }
            foreach ($inputAll[$itemType] as $key => $input) {
                $item = array(
                    'menu_name' => $menuName,
                    'item_order' => $input['order'] ? (int) $input['order'] : null,
                    'item_type' => $itemType,
                    'type_attrs' => json_encode($this->ItemTypesGrammar->$itemType($input)),
                    'html_attrs' => json_encode($this->ItemTypesGrammar->htmlAttrs($input))
                );
                $items[$key] = $item;
            }
        }
        
        if (!empty($items)) {
            uksort($items, 'strnatcasecmp');
            foreach ($items as $item) {
                Menu::create($item);
            }
            return \Redirect::route('admin.index')
                ->with('message', 'Menu <q>'. $menuName .'</q> successfully added.');
        } else {
            return \Redirect::route('admin.create')
                ->with('errormsg', 'Menu <q>'. $menuName .'</q> not created since you need at least one menu item.');
        }
        
        // build the validation rules for the menu items
        // validate the menu items
        // save the menu in the db if valid
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show($menuName)
    {
        $data['menu'] = MenuFacade::get($menuName);
        $data['menuName'] = $menuName;
        return \View::make('menu::show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit($menuName)
    {
        if (!count(\Session::get('items'))) {
            $menuItems = Menu::where('menu_name', '=', $menuName)
                ->orderBy('item_order', 'asc')->get();
            if (!count($menuItems)) {
                return \Redirect::route('admin.index')
                    ->with('errormsg', 'The menu <q>'. $menuName .'</q> cannot be found in the database.');
            }
        }
        
        $data = array('menuItemTypes' => $this->menuItemTypes);
        foreach ($this->menuItemTypes as $itemType) {
            $data['itemTypes'][$itemType] = ucwords(str_replace('_', ' ', $itemType));
        }

        $data['menuName'] = $menuName;
        if (\Session::get('items') !== null) {
            foreach (\Session::get('items', array()) as $key => $menuItem) {
                $data['items'][$key] = $menuItem;
            }
        } else {
            // build the menu item's html
            foreach ($menuItems as $menuItem) {
                $type = $menuItem->item_type;
                $data['items'][] = $this->ItemBuilder->$type($menuItem->toArray());
            }
        }
        return \View::make('menu::edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update($menuName)
    {
        // create the validation rules for each menu item type
        $inputAll = $this->removeInvalidItems(\Input::all());
        
        $items = $this->ItemBuilder->fromInput($inputAll, $this->menuItemTypes, $this->ItemTypesGrammar);
        // validate the new menu name
        $rules = array ('menu-name' => 'required|alpha_dash|menunameunique:menus,menu_name,' . $menuName);

        $validator = \Validator::make(
            $inputAll,
            $rules,
            array('menunameunique' => 'The :attribute has already been taken.')
        );
        // validator fails
        if ($validator->fails()) {
            return \Redirect::route('admin.edit', array($menuName))
                ->with('items', $items)
                ->withErrors($validator)
                ->withInput(\Input::all());
        }
        
        // if no menu items remove the menu from the db
        if (empty($items)) {
            // delete the menu since there are no items
            return $this->destroy($menuName);
        }
        // get the menu items from the db,
        $menuItems = Menu::where('menu_name', '=', $menuName)
                ->orderBy('item_order', 'asc')->get();
        // remove items that were removed
        $inputMenuItems = Menu::inputToArray(\Input::all());
        Menu::removeMissingItems($inputMenuItems, $menuItems);
        // update the existing ones
        Menu::updateItems($inputMenuItems);
        // insert the new ones
        Menu::insertItems($inputAll, $this->menuItemTypes);
        
        // return with save msg
        $menuName = \Input::get('menu-name');
        return \Redirect::route('admin.edit', array($menuName))
            ->with('message', 'Menu <q><strong>'. $menuName .'</strong></q> successfully saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy($menuName)
    {
        if (Menu::where('menu_name', '=', $menuName)->delete()) {
            return \Redirect::route('admin.index')
                ->with('message', 'Menu <q><strong>'. $menuName .'</strong></q> successfully deleted.');
        }
        return \Redirect::route('admin.index')
                ->with('errormsg', 'There was a problem deleting the menu <q><strong>'. $menuName .'</strong></q>.');
    }

    // --------------------------------------------------------------
    // Protected methods
    // --------------------------------------------------------------
    

    /**
     * Removes the menu items from the input that have missing required items
     *
     * @param  array $inputAll
     *
     * @return array
     */
    protected function removeInvalidItems ($inputAll)
    {
        foreach ($this->menuItemTypes as $itemType) {
            $input = isset($inputAll[$itemType]) ? $inputAll[$itemType] : array();
            if (!array_key_exists($itemType, $this->menuItemRequired) || empty($this->menuItemRequired[$itemType])) {
                continue;
            }
            // check for each required item in the menu item
            foreach ($input as $key => $item) {
                foreach ($this->menuItemRequired[$itemType] as $propertyName) {
                    if (!isset($item[$propertyName]) || !$item[$propertyName]) {
                        unset($inputAll[$itemType][$key]);
                    }
                }
            }
        }
        return $inputAll;
    }
}
