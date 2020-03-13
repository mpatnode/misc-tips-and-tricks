<?php

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
foreach ([1, 1000000000, -1000000000, -1000000000, 1000000000, 1] as $v) {
    $n = new ListNode($v);
    if (!$l) {
        $last = $l = $n;
    }
    else {
        $last->next = $n;
        $last = $last->next;
    }
}

isListPalindrome($l);

function isListPalindrome($l) {
    $slow = $l;
    $fast = $l;

    if (!$l->next) {
        return true;
    }

    do {
        $fast = $fast->next->next;
        if ($fast) {
            $slow = $slow->next;
            $odd = true;
        }
        else {
            $odd = false;
        }
    } while($fast && $fast->next);

    $l2 = $slow->next;
    if ($odd) {
        $l2 = $l2->next;
    }

    reverse($l2);

    return compare_lists($l, $l2);
}

function reverse(&$l) {
    $prev = NULL;
    $current = $l;
    $next = $current;
    do {
        $next = $next->next;
        $current->next = $prev;
        $prev = $current;
        $current = $next;
    } while($next);
    $l = $prev;
}

function compare_lists($l, $l2) {
    $c = $l;
    $c2 = $l2;
    do {
        if ($c->value != $c2->value) {
            return false;
        }
        $c = $c->next;
        $c2 = $c2->next;
    } while ($c2);

    return true;
}
