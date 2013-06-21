<?php
/**
 * @author Nick Kaye <nick.c.kaye@gmail.com>
 * ©2013 Outright Mental Inc.
 * All Rights Reserved
 */
class Util {

    /**
     * Return 404 error and exit
     */
    static public function err404() {
        header("HTTP/1.0 404 Not Found");
        exit;
    }

    /**
     *
     * get key within arr if set, else return def
     * @param $pre_arr
     * @param $key
     * @param null $def
     * @return null
     */
    static public function getIfSet($pre_arr, $key, $def = null)
    {
        $arr = (array)$pre_arr;

        return isset($arr[$key]) ? $arr[$key] : $def;
    }

    /**
     *   getIfSetDeep
     *
     * Used in stacks to test for the deep existence of a variable in an array without throwing errors
     *
     * @param array $arr
     * @param string|array $key
     * @param null $def
     * @return mixed
     */
    static public function getIfSetDeep($arr, $key, $def = null)
    {
        // null values = return default
        if ($arr == null || $key == null || $arr == $def || $key == $def)
            return $def;

        // single-element array key ought to be converted to straight key
        if (is_array($key) && count($key) < 2)
            $key = $key[0];

        // if the key is an array, use the first element as the key for a getIfSet, then re-iterate on the shortened key array with the found sub-array
        if (is_array($key))
            return self::getIfSetDeep(self::getIfSet($arr, array_shift($key), $def), $key, $def);

        // if the key is not an array, then just use getIfSet
        return self::getIfSet($arr, $key, $def);
    }
}