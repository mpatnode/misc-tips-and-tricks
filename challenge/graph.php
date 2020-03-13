<?php

class Vertex {
   public $value;
   public $edges;
   public $visited;

   public function __construct($x) {
     $this->value = $x;
     $this->edges = [];
     $this->visited = false;
   }
}


$values = [1, 1, 0, 0, 0, 1, 1, 0, 1];
$w =3; $h = 3;
$hash = loadGraph($w, $h, $values);
$answer = largestArea($hash);

function loadGraph($w, $h, $values) {
    $hash = [];
    for ($x = 0; $x < $w; $x++) {
        for ($y = 0; $y < $h; $y++) {
            $hash["{$x},{$y}"] = new Vertex(next($values));
            gInsert($hash, $x, $y, $w, $h);
        }
    }
    return $hash;
}

function gInsert(&$hash, $x, $y, $w, $h) {
    $ckey = "{$x},{$y}";
    $c = $hash[$ckey];
    for ($row = $x - 1; $row <= $x + 1 && $row < $w; $row++) {
        if ($row >= 0) {
            for ($col = $y - 1; $col <= $y + 1 && $col < $h; $col++) {
                $key = "{$row},{$col}";
                if ($col >= 0 && $key != $ckey && !empty($hash[$key])) {
                    $c->edges[$key] = $hash[$key];
                    $hash[$key]->edges[$ckey] = $c;
                }
            }

        }
    }
}

function largestArea($hash) {
    $largest = 0;
    foreach ($hash as $vertex) {
        if ($vertex->visited || !$vertex->value) {
            continue;
        }
        $largest = max($largest, totalVertex($vertex));
    }
    return $largest;
}

function totalVertex($vertex) {
    $total = $vertex->value;
    $vertex->visited = true;
    if ($total) {
        foreach ($vertex->edges as $edge) {
            if (!$edge->visited && $edge->value) {
                $total += totalVertex($edge);
            }
        }
    }
    return $total;
}

