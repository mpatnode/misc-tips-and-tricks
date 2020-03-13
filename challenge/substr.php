<?php

$words =
["Apple",
    "Melon",
    "Orange",
    "Watermelon"];
$parts =
["a",
    "mel",
    "lon",
    "el",
    "An"];

findSubstrings($words, $parts);


function findSubstrings($words, $parts) {
    $allwords = implode('', $words);
    $parts = array_filter(function($p) use($allwords) {return strpos($allwords, $p) !== false;}, $parts);
    $lengths = array_map(function($s) {
        return strlen($s);
    }, $parts);
    $parts = array_combine($parts, $lengths);
    arsort($parts);

    foreach ($words as &$word) {
        $found = null;
        $last_len = 0;
        $last_pos = 100;
        foreach ($parts as $part => $len) {
            if ($last_len > $len) {
                break;
            }
            if (($pos = strpos($word, $part)) !== FALSE) {
                if (empty($found) || $pos < $last_pos) {
                    $found = $part;
                    $last_len = $len;
                    $last_pos = $pos;
                }
            }
        }
        if ($found) {
            $word = str_replace($found, "[{$found}]", $word);
        }
    }
    return $words;
}

