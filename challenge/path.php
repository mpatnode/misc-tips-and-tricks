<?php
class FileTree {
    public $name;
    public $children;

    public function __construct($name = null) {
        $this->name = $name;
        $this->children = [];
    }
}

longestPath("user\f\tpictures\f\t\tphoto.png\f\t\tcamera\f\tdocuments\f\t\tlectures\f\t\t\tnotes.txt");
longestPath("user\f\tpictures\f\tdocuments\f\t\tnotes.txt");
longestPath("user\n\tpictures\n\tdocuments\n\t\tnotes.txt\nuser2\n\tpictures\n\tdocuments\n\t\tnotes.txt");
// longestPath("f");


function longestPath($fileSystem) {
    $fileSystem = str_replace('    ', "\t", $fileSystem);
    $paths = explode("\f", $fileSystem);

    $t = new FileTree('');
    parse($paths, -1, $t);

    $fullpath = '';
    $longest = 0;
    walk($t, $fullpath, $longest);

    return $longest;
}

function walk($t, $fullpath, &$longest) {

    $fullpath .= $t->name;
    if (empty($t->children) && validFilename($fullpath)) {
        $longest = max($longest, strlen($fullpath));
    }
    foreach ($t->children as $child) {
        if (!empty($child->children)) {
            walk($child, $fullpath, $longest);
        }
        elseif (validFilename($child->name)) {

            $longest = max($longest, strlen($fullpath . "{$child->name}"));
        }
    }
}

function parse(&$paths, $depth, $t = null) {
    while (!empty($paths)) {
        $p = $paths[0];
        if ($depth == -1) {
            $t->children[] = new FileTree(array_shift($paths));
            parse($paths, $depth + 1, end($t->children));
        }
        elseif ($p[$depth] == "\t") {
            if ($p[$depth + 1] != "\t") {
                $t->children[] = new FileTree("/" . trim(array_shift($paths), "\t"));
            }
            else {
                parse($paths, $depth + 1, end($t->children));
            }
        }
        else {
            return;
        }
    }
}

function validFilename($name) {
    return !empty(pathinfo($name, PATHINFO_EXTENSION));
}

