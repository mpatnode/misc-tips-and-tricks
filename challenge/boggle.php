<?php

$board =
[["G","T"],
    ["O","A"]];
$words =
["TOGGLE",
    "GOAT",
    "TOO",
    "GO"];
wordBoggle($board, $words);

$ySize = 0;
$xSize = 0;
$gBoard = [];
$gWords = [];
$gFound = [];
function wordBoggle($board, $words) {
    global $xSize, $ySize, $gBoard, $gWords, $gFound;
    $ySize = count($board);
    $xSize = count($board[0]);
    $gBoard = $board;
    $gWords = array_combine($words, array_fill(0, count($words), 1));
    $gFound = [];
    wordparts($words);

    for ($y = 0; $y < $gSize; $y++) {
        for ($x = 0; $x < $gSize; $x++) {
            findwords($x, $y, '');
        }
    }

    ksort($gFound);
    return array_keys($gFound);

}

function findwords($x, $y, $word) {
    global $xSize, $ySize, $gBoard, $gWords, $gFound;
    static $visited = [];

    $word .= $gBoard[$y][$x];

    if (strlen($word) > 1) {
        if (!isset($gWords[$word])) {
            return;  // No words down this path
        }
        if (!empty($gWords[$word])) {
            $gFound[$word] = 1;
            if ($gWords[$word] == 1) {
                return;  // No more words down this path
            }
        }

    }
    $visited[$y][$x] = 1;
    for ($i = $x - 1; $i < $x + 2; $i++) {
        for ($j = $y - 1; $j < $y + 2; $j++) {
            if ($i >= 0 && $i < $xSize && $j >=0 && $j < $ySize && empty($visited[$j][$i])) {
                findwords($i, $j, $word);
            }
        }
    }
    $visited[$y][$x] = 0;

}

function wordparts($words) {
    global $gWords;
    foreach($words as $word) {
        for ($i = 1; $i < strlen($word); $i++) {
            $key = substr($word, 0, $i);
            $gWords[$key] = !empty($gWords[$key]) ? 2 : 0;
        }
    }
}

