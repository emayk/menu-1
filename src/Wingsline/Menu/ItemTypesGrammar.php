<?php

namespace Wingsline\Menu;

class ItemTypesGrammar
{
    /**
     * Registered macros
     * 
     * @var array
     */
    protected $macros = array();

    /**
     * Link grammar
     *
     * @param  array $input
     *
     * @return array
     */
    public function link ($input)
    {
        if (count($input['attr']) == 1 && $input['attr'][0] == '') {
            $input['attr'] = array();
        }
        return array(
            $input['url'],
            $input['text'],
            array(),
            $input['attr'],
            (int) $input['https']
        );
    }

    /**
     * Route grammar
     *
     * @param  array $input
     *
     * @return array
     */
    public function route ($input)
    {
        if (count($input['attr']) == 1 && $input['attr'][0] == '') {
            $input['attr'] = array();
        }
        return array(
            $input['route'],
            $input['text'],
            array(),
            $input['attr'],
            (int) $input['https']
        );
    }

    /**
     * Menu grammar
     *
     * @param  array $input
     *
     * @return array
     */
    public function menu ($input)
    {
        return array(
            $input['name'],
            array(),
            $input['default'],
            $input['label']
        );
    }

    /**
     * Html grammar
     *
     * @param  array $input
     *
     * @return array
     */
    public function html ($input)
    {
        return array(
            $input['code']
        );
    }

    /**
     * Default grammar for custom menu types
     *
     * @param  array $input
     *
     * @return array
     */
    public function custom ($input)
    {
        return $input['attr'];
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
        if (isset($this->macros[$method])) {
            return call_user_func_array($this->macros[$method], $parameters);
        } else {
            return call_user_func_array(array($this, 'custom'), $parameters);
        }
        throw new \Exception("Invalid menu item grammar type [$method].");
    }

    /**
     * Generates a valid html attribute array from the input
     *
     * @param  array $input
     *
     * @return array
     */
    public function htmlAttrs ($input)
    {
        if (!isset($input['htmlattrname']) || !isset($input['htmlattrvalue']) ||
            empty($input['htmlattrname']) || empty($input['htmlattrvalue']) ||
            count($input['htmlattrname']) != count($input['htmlattrvalue'])) {
            return;
        }
        $array = array();
        foreach ($input['htmlattrname'] as $key => $name) {
            if ($name) {
                $array[$name] = $input['htmlattrvalue'][$key];
            }
        }
        return array_filter($array);
    }
}
