<?php

namespace Wingsline\Menu;

class ItemTypes
{
    /**
     * Registered macros
     * 
     * @var array
     */
    protected $macros = array();

    /**
     * Creates a link
     * 
     * @param  string $url
     * @param  string $title
     * @param  array  $attributes
     * @param  array  $parameters
     * @param  bool   $https
     * @return string
     */
    public function link($url, $title = null, $attributes = array(), $parameters = array(), $https = null)
    {
        // generates a link
        $url = \URL::to($url, $parameters, $https);
        if (is_null($title)) {
            $title = $url;
        }
        return '<a href="' . $url . '"' .
            $this->attributes($attributes) . '>' .
            $this->entities($title).'</a>';
    }

     /**
     * Returns a menu placeholder until the finalize() is called
     * @param  string $menuName  Name of the menu
     * @param  array  $htmlAttrs Array of html attributes
     * @param  mixed  $default   If no menu items are present we display this content
     * @return mixed
     */
    public function menu ($menuName, array $htmlAttrs = array(), $default = null, $label = null)
    {
        return MenuFacade::get($menuName, $htmlAttrs, $default, $label);
    }

    /**
     * Returns a menu item with the passed content
     * 
     * @param  string $html Html content
     * @return string
     */
    public function html ($html = null)
    {
        return $html;
    }

    /**
     * Creates a link to a route
     * 
     * @param  string $route
     * @param  string $title
     * @param  array  $attributes
     * @param  array  $parameters
     * @param  bool   $https
     * @return string
     */
    public function route ($route, $title = null, $attributes = array(), $parameters = array(), $https = null)
    {
        // generates a link
        $url = \URL::route($route, $parameters, $https);
        return $this->link($url, $title, $attributes, $parameters, $https);
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
      * Build a list of HTML attributes from an array.
      *s
      * @param  array   $attributes
      * @return string
      */
    public function attributes($attributes)
    {
        $html = array();

        foreach ((array) $attributes as $key => $value) {
            // For numeric keys, we will assume that the key and the value are the
            // same, as this will conver HTML attributes such as "required" that
            // may be specified as required="required", etc.
            if (is_numeric($key)) {
                $key = $value;
            }

            if (!is_null($value)) {
                $html[] = $key.'="' . $this->entities($value).'"';
            }
        }

        return (count($html) > 0) ? ' '.implode(' ', $html) : '';
    }

    /**
     * Convert HTML characters to entities.
     *
     * The encoding specified in the application configuration file will be used.
     *
     * @param  string  $value
     * @return string
     */
    public function entities($value)
    {
        return htmlentities($value, ENT_QUOTES, 'UTF-8', false);
    }

    /**
     * Dynamically handle calls to custom macros.
     *
     * @param  string  $method
     * @param  array   $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (isset($this->macros[$method])) {
            return call_user_func_array($this->macros[$method], $parameters);
        }
        throw new \Exception("Invalid menu type [$method].");
    }
}
