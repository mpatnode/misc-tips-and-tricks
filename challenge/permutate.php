<?php


$str = "1234";
permute($str, strlen($str));


function permute(&$str, $size) {
    static $count = 1;
    if ($size == 1) {
        print "{$count}: {$str}\n";
        $count++;
        return;
    }
    permute($str, $size - 1);

    for ($j = 0; $j < $size - 1; $j++) {
        if ($size % 2 == 1) {
            swap($str, 0, $size - 1);
        }
        else {
            swap($str, $j, $size - 1);
        }
        permute($str, $size - 1);
    }
}

// function to swap the char at pos $i and $j of $str.
function swap(&$str,$i,$j) {
    $temp = $str[$i];
    $str[$i] = $str[$j];
    $str[$j] = $temp;
}

