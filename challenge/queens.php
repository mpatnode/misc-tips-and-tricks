<?php


nQueens(4);
$results;
function nQueens($n) {
    global $results;
    $results = [];

    for ($i = 0; $i < $n; $i++) {
        place($i, 0, $n, []);
    }

    return $results;
}

function place($x, $y, $n, $board) {
    global $results;

    if ($x < 0 || $y < 0 || $x >= $n || $y >= $n) {
        // Out of bounds
        return false;
    }

    if (isset($board[$y])) {
        // Row taken
        return false;
    }

    foreach ($board as $py => $px) {
        if (abs($px - $x) == abs($py - $y) || $x == $px) {
            // Diag/column fail
            return false;
        }
    }

    $board[$y] = $x;

    if (count($board) == $n) {
        ksort($board);
        $results[] = array_map(function($v) {return $v + 1;}, $board);
        return true;
    }

    // Given we just placed $x & y, we know we
    // need to try one of these next
    $next_place = [
        [$x - 1, $y - 2],
        [$x - 2, $y - 1],
        [$x - 1, $y + 2],
        [$x - 2, $y + 1],
        [$x + 1, $y - 2],
        [$x + 2, $y - 1],
        [$x + 1, $y + 2],
        [$x + 2, $y + 1],
    ];

    foreach ($next_place as $p) {
        if (place($p[0], $p[1], $n, $board)) {
            return true;  // only 1 per x?
        }
    }

    return false;
}

