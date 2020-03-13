<?php

function findProfession($level, $pos) {
    $lkey = "EDDEDEEDDEEDEDDE";
    $rkey = "DEEDEDDEEDDEDEED";
    $halfrow = (2 ** $level) / 2;
    if ($pos <= $halfrow) {
        $l = $lkey[($pos - 1) % 16];
    }
    else {
        $l = $rkey[($pos - 1) % 16];
    }
    if ($l == 'D') {
        return 'Doctor';
    }
    return 'Engineer';

}

$t = new Tree(8);
$s = 8;
hasPathWithGivenSum($t, $s);

$foundSum = false;
function hasPathWithGivenSum($t, $s) {
    global $foundSum;
    $foundSum = false;

    walkNodes($t, $s);
    return $foundSum;
}

function walkNodes($t, $s) {
    static $total = 0;
    global $foundSum;

    if ($t == NULL) {
        return 0;
    }

    $total += $t->value;
    print "Total {$total}\n";

    if ($t->right == NULL && $t->left == NULL) {
        if ($total == $s) {
            $foundSum = TRUE;
        }
    }
    else {
        $subSum = walkNodes($t->right, $s);
        $total -= $subSum;
        $subSum = walkNodes($t->left, $s);
        $total -= $subSum;
    }

    return $t->value;
}





$coins = [10, 50, 100, 500];
$quantity = [5, 3, 2, 2];



$str = "abdc";
$pairs = [[1,4], [3,4]];

// 1, 3, 6, 8
// 2, 7

$str = "acxrabdz";
$pairs = [[1,3], [6,8], [3,8], [2,7]];

$str = "lvvyfrbhgiyexoirhunnuejzhesylojwbyatfkrv";
$pairs =
[[13,23],
    [13,28],
    [15,20],
    [24,29],
    [6,7],
    [3,4],
    [21,30],
    [2,13],
    [12,15],
    [19,23],
    [10,19],
    [13,14],
    [6,16],
    [17,25],
    [6,21],
    [17,26],
    [5,6],
    [12,24]];

swapLexOrder($str, $pairs);

function swapLexOrder($str, $pairs) {
    $pairs = array_map(function ($p) { return [min($p) - 1, max($p) - 1]; }, $pairs);
    // sort($pairs);
    $graphs = [];
    $graph_map = [];
    $gindex = 0;

    foreach ($pairs as $p) {
        $idx1 = $graph_map[$p[0]] ?? false;
        $idx2 = $graph_map[$p[1]] ?? false;
        if ($idx1 !== false && $idx2 != false) {
            if ($idx1 != $idx2) {
                $save = min($idx1, $idx2);
                $del = max($idx1, $idx2);
                $graphs[$save] = array_merge($graphs[$save], $graphs[$del], $p);
                foreach ($graphs[$del] as $di) {
                    $graph_map[$di] = $save;
                }
                unset($graphs[$del]);
                $graph_map[$p[0]] = $graph_map[$p[1]] = $save;
            }
        }
        elseif ($idx1 !== false && $idx2 === false) {
            $graphs[$idx1] = array_merge($graphs[$idx1], $p);
            $graph_map[$p[0]] = $graph_map[$p[1]] = $idx1;
        }
        elseif ($idx2 !== false && $idx1 === false) {
            $graphs[$idx2] = array_merge($graphs[$idx2], $p);
            $graph_map[$p[0]] = $graph_map[$p[1]] = $idx2;
        }
        else {
            $graphs[$gindex] = $p;
            $graph_map[$p[0]] = $gindex;
            $graph_map[$p[1]] = $gindex;
            $gindex++;
        }
    }

    // Extract the characters from each graph, sort and replace
    foreach ($graphs as &$graph) {
        $graph = array_unique($graph);
        sort($graph);

        $chars = [];
        foreach ($graph as $l) {
            $chars[] = $str[$l];
        }
        // reverse sort and put them back
        rsort($chars);
        foreach ($graph as $i => $l) {
            $str[$l] = $chars[$i];
        }
    }
    return $str;
}



    exit();

class ListNode {
   public $value;
   public $next;

   public function __construct($x) {
     $this->value = $x;
     $this->next = null;
   }
}

$l = null;
$last = null;
foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11] as $v) {
    $n = new ListNode($v);
    if (!$l) {
        $last = $l = $n;
    }
    else {
        $last->next = $n;
        $last = $last->next;
    }
}

reverseNodesInKGroups($l, 3);

function reverseNodesInKGroups($l, $k) {

    $c = $l;
    $prev = null;

    if ($k == 1) {
        return $l;
    }

    while ($c) {
        $stack[] = $c;
        $c = $c->next;
    }

    $loops = (int)(count($stack) / $k);

    $c = $l;
    for ($i = 0; $i < $loops; $i++) {
        for ($j = 0; $j < $k; $j++) {
            $next = $c->next;
            $c->next = $prev;
            $prev = $c;
            $c = $next;
        }
        $next_index = ($i * $k) + $j - 1 + $k;
        $stack[$i * $k]->next = $stack[$next_index] ?? $next;
    }


    return $stack[$k-1];

}

function reverse(&$l, $k) {
    $prev = NULL;
    $current = $l;
    $next = $current;
    do {
        $next = $next->next;
        $current->next = $prev;
        $prev = $current;
        $current = $next;
    } while($next && --$k);
    $l = $prev;
}

function swapLexOrder3($str, $pairs) {
    $pairs = array_map(function($p) {
        return [min($p) - 1, max($p) - 1];
    }, $pairs);
    sort($pairs);
    foreach ($pairs as $p) {
        foreach ($graphs as &$g) {
            if (count(array_diff($p, $g)) < 2) {
                $g = array_unique(array_merge($p, $g));
                continue 2;
            }
        }
        // New graph
        $graphs[] = $p;
    };

    // reduce the graphs
    $delete = [];
    foreach ($graphs as $i => &$g) {
        if (in_array($i, $delete)) {
            continue;
        }
        foreach ($graphs as $j => $g2) {
            if ($i == $j || in_array($j, $delete)) {
                continue;
            }
            if (count(array_diff($g2, $g)) < count($g2)) {
                $g = array_merge($g2, $g);
                $delete[] = $j;
            }
        }
    }

    foreach ($delete as $i) {
        unset($graphs[$i]);
    }

    // Extract the characters from each graph, sort and replace
    foreach ($graphs as $graph) {
        $graph = array_unique($graph);
        sort($graph);
        $chars = [];
        foreach ($graph as $l) {
            $chars[] = $str[$l];
        }
        // reverse sort and put them back
        rsort($chars);
        foreach ($graph as $i => $l) {
            $str[$l] = $chars[$i];
        }
    }
    return $str;
}

