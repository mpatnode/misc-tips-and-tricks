<?php

class Tree {
    public $name;
    public $children;

    public function __construct($name = null) {
        $this->name = $name;
        $this->children = [];
    }
};


$input1 = "<div><div></div></div>";
$input2 = "<html><head><style></style></head><body><h1></h1><div><div></div><a></a><a></a></div></body></html>";

prettyPrint($input2);

function prettyPrint($input) {
    $input = substr($input, 1, -1); // Remove the opening and closing <, >
    $tokens = explode('><', $input);
    $tok = array_shift($tokens); // pop off first item
    $head = new Tree($tok);
    parse($head, $tokens);
    $level = 0;
    pprint($head, $level);
}

function parse($node, &$tokens) {
    // Look for children
    while (count($tokens)) {
        $tok = array_shift($tokens);
        if ($tok[0] != '/') {
            $node->children[] = $next = new Tree($tok);
            parse($next, $tokens);
        }
        else {
            return;
        }
    }
}

function pprint($node, $level) {

    if (!$node) {
        return;
    }

    for ($i = 0; $i < $level; $i++) {
        print '-';
    }
    print "{$node->name}\n";
    $level++;
    foreach ($node->children as $child) {
        pprint($child, $level);
    }

}
