<?php

 class Tree {
     public $value;
     public $left;
     public $right;

     public function __construct($x) {
         $this->value = $x;
         $this->left = NULL;
         $this->right = NULL;
     }
 };

$inorder = [4, 2, 1, 5, 3, 6];
$preorder = [1, 2, 4, 3, 5, 6];
restoreBinaryTree($inorder, $preorder);

function restoreBinaryTree($inorder, $preorder) {
    $i = 0;
    $root = new Tree(null);
    treeAdd($root, $preorder, $inorder, $i);
    return $root;
}

function treeAdd($t, $preorder, $inorder, &$i) {

    $t->value = $preorder[$i];
    if (!isset($preorder[$i + 1])) {
        return $t;
    }
    $pos = array_search($preorder[$i], $inorder);
    $left = array_slice($inorder, 0, $pos);
    $right = array_slice($inorder, $pos + 1);
    $i++;

    if (!empty($left)) {
        $t->left = new Tree(NULL);
        treeAdd($t->left, $preorder, $left, $i);
    }

    if (!empty($right)) {
        $t->right = new Tree(NULL);
        treeAdd($t->right, $preorder, $right, $i);
    }
}



