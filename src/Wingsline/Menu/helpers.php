<?php

if (!function_exists('strposa')) {
    /**
     * Finds the first position of an array of strings
     * @param  string  $haystack String to check
     * @param  array   $needles  Array of strings to check
     * @param  integer $offset   If specified, search will start this number of characters counted from the beginning of the string
     * @return mixed             False of not found, otherwise position of where the first needle exists 
     */
    function strposa($haystack, $needles = array(), $offset = 0)
    {
        $chr = array();
        foreach ($needles as $needle) {
            $res = strpos($haystack, $needle, $offset);
            if ($res !== false) {
                $chr[$needle] = $res;
            }
        }
        return empty($chr) ? false : min($chr);
    }
}

if (!function_exists('objectSearchAll')) {

    /**
     * Searches an array of objects and returns the ones that match the needle
     * @param  array  $haystack Array of objects
     * @param  string $key      Key name
     * @param  string $needle   Item to be searched
     * @return mixed            Null on no match, otherwise an array of objects
     */
    function objectSearchAll ($haystack, $key, $needle)
    {
        $matches = null;
        foreach ((array) $haystack as $object) {
            if (isset($object->$key) && $object->$key === $needle) {
                $matches[] = $object;
            }
        }
        return $matches;
    }
}

if (!function_exists('objectsGetProperty')) {
    /**
     * Gets the property values of an array of objects
     * @param  array  $haystack       Array of objects
     * @param  string $propertyName   Property name
     * @return mixed                  Null if no values are found or array of property values
     */
    function objectsGetProperty ($haystack, $propertyName)
    {
        $properties = null;
        foreach ((array) $haystack as $object) {
            if (isset($object->$propertyName)) {
                $properties[] = $object->$propertyName;
            }
        }
        return $properties;
    }
}

if (!function_exists('strposa')) {
    /**
     * Finds the first position of an array of strings
     * @param  string  $haystack String to check
     * @param  array   $needles  Array of strings to check
     * @param  integer $offset   If specified, search will start this number of characters counted from the beginning of the string
     * @return mixed             False of not found, otherwise position of where the first needle exists 
     */
    function strposa($haystack, $needles = array(), $offset = 0)
    {
        $chr = array();
        foreach ($needles as $needle) {
            $res = strpos($haystack, $needle, $offset);
            if ($res !== false) {
                $chr[$needle] = $res;
            }
        }
        return empty($chr) ? false : min($chr);
    }
}

if (!function_exists('arraySubtract')) {
    /**
     * Returns the difference between the two arrays using a subkey as comparison
     *
     * @param  array $array1
     * @param  array $array2
     * @param  string $compareString Key
     *
     * @return array
     */
    function arraySubtract($array1, $array2, $compareString)
    {
        if (!is_array($array1) || !is_array($array2) || !$compareString) {
            return false;
        }
        if (empty($array2)) {
            return $array1;
        }
        $arrResult = array();
        foreach ($array1 as $arrInsideArray1) {
            foreach ($array2 as $arrInsideArray2) {
                $found=false;
                if ($arrInsideArray1[$compareString]==$arrInsideArray2[$compareString]) {
                    $found=true;
                    break;
                }
            }
            if (!$found) {
                array_push($arrResult, $arrInsideArray1);
            }
        }
        return $arrResult;
    }
}
