<?php

namespace Wingsline\Menu;

use Illuminate\Database\Eloquent\Collection;

class Menu extends \Eloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'menus';

    /**
     * Insert the new items into the db
     *
     * @param  array $inputAll
     *
     * @return mixed
     */
    protected function insertItems ($inputAll)
    {
        $items = array();
        $itemTypes = MenuFacade::getItemTypes()->get();
        $grammar = MenuFacade::getGrammar();
        foreach ($itemTypes as $itemType) {
            if (!isset($inputAll[$itemType]) || empty($inputAll[$itemType])) {
                continue;
            }
            foreach ($inputAll[$itemType] as $key => $input) {
                if (filter_var($key, FILTER_VALIDATE_INT) === false) {
                    continue;
                }
                $item = array(
                    'menu_name' => $inputAll['menu-name'],
                    'item_order' => $input['order'] !== '' ? (int) $input['order'] : null,
                    'item_type' => $itemType,
                    'type_attrs' => json_encode($grammar->$itemType($input)),
                    'html_attrs' => json_encode($grammar->htmlAttrs($input))
                );
                $items[$key] = $item;
            }
        }
        foreach ($items as $item) {
            static::create($item);
        }
    }
    /**
     * Update the existing menu items
     *
     * @param  array $items
     *
     * @return void
     */
    protected function updateItems ($items)
    {
        if (empty($items) || !$items) {
            return;
        }
        foreach ($items as $item) {
            static::where('id', '=', $item['id'])->update($item);
        }
    }
    /**
     * Delete the items that are not present in the collection anymore
     *
     * @param  array      $newMenuItems
     * @param  Collection $oldMenuItems
     *
     * @return mixed
     */
    protected function removeMissingItems ($newMenuItems, Collection $oldMenuItems)
    {
        $oldMenuItems = $oldMenuItems->toArray();
        $remove = arraySubtract($oldMenuItems, $newMenuItems, 'id');
        if (!empty($remove)) {
            $items = array();
            foreach ($remove as $rem) {
                $items[] = $rem['id'];
            }
            return \DB::table($this->table)->whereIn('id', $items)->delete();
        }
    }

    /**
     * Converts the input elements into db compatible arrays
     *
     * @param  array $input User input array
     *
     * @return array
     */
    protected function inputToArray($input)
    {
        $itemTypes = MenuFacade::getItemTypes()->get();
        $grammar = MenuFacade::getGrammar();
        $menuName = $input['menu-name'];
        settype($input, 'array');
        $newItems = array();
        foreach ($input as $key => $items) {
            // not a valid menu item, we skip it
            if (!in_array($key, $itemTypes)) {
                continue;
            }
            foreach ($items as $id => $item) {
                $id = explode('.', $id);
                if (!isset($id[1]) || $id[1] != $key) {
                    continue;
                } else {
                    $newItem['item_type'] = $id[1];
                }
                $id = (int) array_shift($id);
                $newItem['id'] = $id;
                $newItem['item_order'] = $item['order'] !== '' ? (int) $item['order'] : null;
                $newItem['type_attrs'] = json_encode($grammar->$key($item));
                $newItem['html_attrs'] = json_encode($grammar->htmlAttrs($item));
                $newItem['menu_name'] = $menuName;
                $newItems[] = $newItem;
            }
        }
        return $newItems;
    }
}
