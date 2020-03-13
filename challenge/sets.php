<?php

$arr = [1, 2, 3, 4, 5];
$num = 5;
$results = [];
sumSubsets($arr, $num);
function sumSubsets(&$arr, $num) {
    global $results;
    $results = [];

    foreach ($arr as $p => $v) {
        findsets($p, $v, $num, $arr);
    }

    return $results;
}

function findsets($p, $v, $num, $arr) {
    global $results;
    static $set = [];

    $set[] = $v;
    $sum = array_sum($set);

    if ($sum == $num) {
        $key = implode(':', $set);
        $results[$key] = $set;
        array_pop($set);
        return;
    }

    if ($sum > $num) {
        array_pop($set);
        return;
    }

    foreach ($arr as $p2 => $v2) {
        if ($p2 <= $p) {
            continue;
        }
        findsets($p2, $v2, $num, $arr);

        if (empty($set)) {
            break;
        }
    }
    array_pop($set);
}




