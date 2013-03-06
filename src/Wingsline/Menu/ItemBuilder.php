<?php

namespace Wingsline\Menu;

class ItemBuilder
{
    /**
     * Default placeholder
     */
    const PLACEHOLDER = ':id';
    /**
     * Registered macros
     * 
     * @var array
     */
    protected $macros = array();

    /**
     * These functions will not be called by __call
     *
     * @var array
     */
    protected $reserved = array('toArray', 'macro', 'fromInput');

    /**
     * Returns the link item view
     *
     * @param  array  $data Data that will be used to populate the fields
     *
     * @return string
     */
    public function link($data = array())
    {
        $viewData = array('menuItemType' => __FUNCTION__);
        if (!$data || empty($data) || !count($data)) {
            $viewData['placeholder'] = static::PLACEHOLDER;
            $viewData['url'] = '';
            $viewData['text'] = '';
            $viewData['order'] = '';
            $viewData['https'] = '0';
            $viewData['_closed'] = false;
        } else {
            $viewData['id'] = $data['id'];
            $viewData['placeholder'] = $data['id'] . (isset($data['_new']) ? '' : '.link');
            $attrs = array_values($this->toArray($data['type_attrs']));
            
            $viewData['url'] = $attrs[0];
            $viewData['text'] = isset($attrs[1]) ? $attrs[1] : '';
            $viewData['order'] = $data['item_order'];
            $viewData['https'] = $attrs[4];
            $viewData['attrs'] = isset($attrs[3]) ? $attrs[3] : array();
            $viewData['htmlAttrs'] = $this->toArray($data['html_attrs']);
            $viewData['_closed'] = true;
        }
        return \View::make('menu::types.link', $viewData)->__toString();
    }

    /**
     * Returns the route item view
     *
     * @param  array  $data Data that will be used to populate the fields
     *
     * @return string
     */
    public function route ($data = array())
    {
        $viewData = array('menuItemType' => __FUNCTION__);
        if (!$data || empty($data) || !count($data)) {
            $viewData['placeholder'] = static::PLACEHOLDER;
            $viewData['route'] = '';
            $viewData['text'] = '';
            $viewData['order'] = '';
            $viewData['https'] = '0';
            $viewData['_closed'] = false;
        } else {
            $viewData['id'] = $data['id'];
            $viewData['placeholder'] = $data['id'] . (isset($data['_new']) ? '' : '.route');
            $attrs = array_values($this->toArray($data['type_attrs']));
            $viewData['route'] = $attrs[0];
            $viewData['text'] = isset($attrs[1]) ? $attrs[1] : '';
            $viewData['order'] = $data['item_order'];
            $viewData['https'] = $attrs[4];
            $viewData['attrs'] = isset($attrs[3]) ? $attrs[3] : array();
            $viewData['htmlAttrs'] = $this->toArray($data['html_attrs']);
            $viewData['_closed'] = true;
            
        }
        return \View::make('menu::types.route', $viewData)->__toString();
    }

    /**
     * Returns the menu item view
     *
     * @param  array  $data Data that will be used to populate the fields
     *
     * @return string
     */
    public function menu ($data = array())
    {
        $viewData = array('menuItemType' => __FUNCTION__);
        if (!$data || empty($data) || !count($data)) {
            $viewData['placeholder'] = static::PLACEHOLDER;
            $viewData['_closed'] = false;
            $viewData['text'] = '';
            $viewData['name'] = '';
            $viewData['order'] = '';
            $viewData['default'] = '';
            $viewData['label'] = '';
        } else {
            $viewData['_closed'] = true;
            $viewData['placeholder'] = $data['id'] . (isset($data['_new']) ? '' : '.menu');
            $attrs = array_values($this->toArray($data['type_attrs']));
            $viewData['text'] = $attrs[0];
            $viewData['name'] = $attrs[0];
            $viewData['order'] = $data['item_order'];
            $viewData['default'] = isset($attrs[2]) ? $attrs[2] : '';
            $viewData['label'] = isset($attrs[3]) ? $attrs[3] : '';
        }
        return \View::make('menu::types.menu', $viewData)->__toString();
    }

    /**
     * Returns the html item view
     *
     * @param  array  $data Data that will be used to populate the fields
     *
     * @return string
     */
    public function html ($data = array())
    {
        $viewData = array('menuItemType' => __FUNCTION__);
        if (!$data || empty($data) || !count($data)) {
            $viewData['placeholder'] = static::PLACEHOLDER;
            $viewData['_closed'] = false;
            $viewData['text'] = '...';
            $viewData['order'] = '';
            $viewData['code'] = '';
        } else {
            $viewData['_closed'] = true;
            $viewData['placeholder'] = $data['id'] . (isset($data['_new']) ? '' : '.html');
            $viewData['text'] = '...';
            $attrs = $this->toArray($data['type_attrs']);
            if (is_array($attrs)) {
                $attrs = array_values($attrs);
            }
            $viewData['code'] = $attrs[0];
            $viewData['order'] = $data['item_order'];
            $viewData['htmlAttrs'] = $this->toArray($data['html_attrs']);
        }
        return \View::make('menu::types.html', $viewData)->__toString();
    }

    /**
     * Returns the custom item view
     *
     * @param  array  $data Data that will be used to populate the fields
     *
     * @return string
     */
    public function custom ($data = array(), $type = false)
    {
        $viewData = array();
        if (!$data || empty($data) || !count($data)) {
            $viewData['menuItemType'] = $type;
            $viewData['_closed'] = false;
            $viewData['placeholder'] = static::PLACEHOLDER;
            $viewData['text'] = '';
            $viewData['order'] = '';
        } else {
            $viewData['menuItemType'] = isset($data['item_type']) ? $data['item_type'] : $type;
            $viewData['_closed'] = true;
            $viewData['placeholder'] = $data['id'] . (isset($data['_new']) ? '' : '.' . $data['item_type']);
            $attrs = array_filter(array_values($this->toArray($data['type_attrs'])));
            $viewData['text'] = trim(substr((isset($attrs[0]) ? $attrs[0] : ''), 0, 200));
            $viewData['order'] = $data['item_order'];
            $viewData['htmlAttrs'] = $this->toArray($data['html_attrs']);
            $viewData['attrs'] = $attrs;
        }
        return \View::make('menu::types.custom', $viewData)->__toString();
    }

    /**
     * Creates a new menu type
     * 
     * @param  string   $typeName Menu type name
     * @param  \Closure $closure  Closure
     * @return void
     */
    public function macro($typeName, \Closure $closure)
    {
        // adds a new type
         $this->macros[$typeName] = $closure;
    }

    /**
     * Dynamically handle calls to custom macros.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @throws \Exception
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (isset($this->macros[$method]) && !in_array($method, $this->reserved)) {
            return call_user_func_array($this->macros[$method], $parameters);
        } else {
            return call_user_func_array(array($this, 'custom'), $parameters);
        }
        throw new \Exception("Invalid menu item grammar type [$method].");
    }

    /**
     * Converts the passed json data into an array
     *
     * @param  mixed $data Can be a json, array or null
     *
     * @return [type]       [description]
     */
    protected function toArray ($data)
    {
        if (is_array($data)) {
            return $data;
        } else {
            return json_decode($data, true);
        }
    }

    /**
     * Build the item list from the user submitted input
     *
     * @param  array            $input
     * @param  array            $menuItemTypes Valid menu types
     * @param  ItemTypesGrammar $grammar
     *
     * @return array
     */
    public function fromInput ($input, $menuItemTypes, ItemTypesGrammar $grammar)
    {
        $items = array();

        foreach ($input as $type => $data) {
            if (!in_array($type, $menuItemTypes)) {
                continue;
            }
            foreach ($data as $key => $item) {
                $item['_new'] = true;
                $item['id'] = $key;
                $item['html_attrs'] = $grammar->htmlAttrs($item);
                $item['menuItemType'] = $type;
                $item['type_attrs'] = $grammar->$type($item);
                $item['item_order'] = $item['order'];
                $items[$key] = $this->$type($item, $type);
            }
        }
        return $items;
    }
}
