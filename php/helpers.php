<?php
/**
 * Useful PHP functions I've built over the years
 */

/**
 * Modified version of array_walk_recursive that passes in the array to the callback
 * The callback can modify the array or value by specifying a reference for the parameter.
 *
 * @param array The input array.
 * @param callable $callback($value, $key, $array)
 */
function array_walk_recursive_array(array &$array, callable $callback) {
    foreach ($array as $k => &$v) {
        if (is_array($v)) {
            array_walk_recursive_array($v, $callback);
        } else {
            $callback($v, $k, $array);
        }
    }
}

/**
 * Find an array of needles in a haystack.
 * @param $haystack
 * @param array $needles
 * @param null $position required position for needle, if specified
 * @return bool
 */
function stri_contains($haystack, array $needles, $position = NULL) {
    foreach($needles as $needle) {
        if (($pos = stripos($haystack, $needle)) !== FALSE) {
            if (is_null($position)) {
                return TRUE;
            }
            return $position == $pos;
        }
    }
    return FALSE;
}

/**
 * Does the given needle exist in the array as a key?
 *
 * @param $needle
 * @param $haystack
 * @return bool
 */
function array_key_exists_recursive($needle, $haystack) {
    foreach ($haystack as $key => $value) {
        if ($needle === $key
                || is_array($value) && array_key_exists_recursive($needle, $value)) {
            return TRUE;
        }
    }
    return FALSE;
}

/**
 * See http://php.net/manual/de/function.array-unique.php#78801
 * @param $array
 */
function array_iunique($array) {
    return array_intersect_key($array,array_unique(
        array_map('strtolower',$array)));
}

/**
 * Returns true if $haystack starts with $needle, false otherwise.
 *
 * @param string $haystack
 * @param string $needle
 * @return boolean
 */
function starts_with($haystack, $needle) {
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

/**
 * Returns true if $haystack ends with $needle, false otherwise.
 *
 * @param string $haystack
 * @param string $needle
 * @return boolean
 */
function ends_with($haystack, $needle) {
    $length = strlen($needle);
    $start  = $length * -1; //negative
    return (substr($haystack, $start) === $needle);
}

function radix_encode($val, $base = 52, $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
    $str = '';
    do {
        $i = $val % $base;
        $str = $chars[$i] . $str;
        $val = ($val - $i) / $base;
    } while($val > 0);
    return $str;
}

