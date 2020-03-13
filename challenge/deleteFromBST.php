<?php

//
// Binary trees are already defined with this interface:
class BTree {
   public $value;
   public $left;
   public $right;

   public function __construct($x) {
     $this->value = $x;
     $this->left = null;
     $this->right = null;
   }
}


$json = file_get_contents('./test-8.json');
$json = $string = preg_replace('/\s+/', '', $json);
$j = json_decode($json);

deleteFromBST();

function deleteFromBST($t, $queries) {

    foreach($queries as $q) {
        $t = removeFromBST($t, $q);
    }

    return $t;
}

function removeFromBST($t, $q) {
    list($parent, $target) = find(null, $t, $q);

    if (!$target) {
        return $t;
    }

    if ($target->left) {
        if ($replacement = findAndDetachLargestRight($target->left)) {
            $target->value = $replacement->value;
        }
        else {
            $target->value = $target->left->value;
            $target->left = $target->left->left;
        }
    }
    else if ($target->right) {
        $target->value = $target->right->value;
        $target->left = $target->right->left;
        $target->right = $target->right->right;
    }
    else if ($parent) {
        if ($parent->left == $target) {
            $parent->left = null;
        }
        else {
            $parent->right = null;
        }
    }
    else {
        $t = null;
    }
    return $t;
}

function find($p, $t, $q) {
    if (!$t || $t->value == $q) {
        return [$p, $t];
    }
    else if ($q < $t->value && $t->left) {
        return find($t, $t->left, $q);
    }
    else if ($q > $t->value && $t->right) {
        return find($t, $t->right, $q);
    }
    else {
        return [$t, null];
    }
}

function findAndDetachLargestRight($t) {
    if (!$t->right) {
        return null;
    }

    $return = findAndDetachLargestRight($t->right);

    if (!$return) {
        $return = $t->right;
        $t->right = $t->right->left;
    }

    return $return;
}



