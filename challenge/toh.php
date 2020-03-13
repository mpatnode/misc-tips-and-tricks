<?php



$tower1 = [7, 6, 5, 4, 3, 2, 1];
$tower2 = [];
$tower3 = [];

moveRings(count($tower1), $tower1, $tower3, $tower2);

function moveRings($count, &$src, &$dst, &$tmp) {


    if ($count == 1) {
        moveRing($src, $dst);
        return;
    }
    moveRings($count - 1, $src, $tmp, $dst);
    moveRing($src, $dst);
    moveRings($count - 1, $tmp, $dst, $src);
}

function moveRing(&$src, &$dst) {
    if (!empty($dst) && end($dst) < end($src)) {
        print "You suck \n";
        exit;
    }
    $dst[] = array_pop($src);
}

