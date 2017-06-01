<?php

class Trie
{
    public function __construct()
    {
        $this->root = new Node();
    }

    public function addPhone(string $phone)
    {
        $current = $this->root;
        $length = strlen($phone);
        for ($i = 0; $i < $length; $i++) {
            $current = $current->addChild($phone[$i]);
            if ($current->isLeaf()) {
                return false;
            }
        }

        if (!$current->makeLeaf()) {
            return false;
        }

        return true;
    }
}

class Node
{
    public $children = [];
    public $isLeaf = false;

    public function addChild($value)
    {
        $child = $this->getChildByValue($value);
        if (!$child) {
            $child = new self();
            $this->children[$value] = $child;
        }

        return $child;
    }

    public function getChildByValue($value)
    {
        return isset($this->children[$value]) ? $this->children[$value] : null;
    }

    public function isLeaf()
    {
        return $this->isLeaf;
    }

    public function makeLeaf()
    {
        if (!empty($this->children)) {
            return false;
        }

        $this->isLeaf = true;
        return true;
    }
}

list($t) = fscanf(STDIN, '%d');

while ($t) {
    $skip = false;
    $result = true;
    $trie = new Trie();
    list($n) = fscanf(STDIN, '%d');
    while ($n) {
        list($phone) = fscanf(STDIN, '%s');
        if (!$skip) {
            if (!$trie->addPhone($phone)) {
                $result = false;
                $skip = true;
            }
        }

        $n--;
    }
    fprintf(STDOUT, "%s\n", $result ? 'YES' : 'NO');

    $t--;
}

$data = getrusage();
echo "User time: ".
    ($data['ru_utime.tv_sec'] +
        $data['ru_utime.tv_usec'] / 1000000) . "\n";
echo "System time: ".
    ($data['ru_stime.tv_sec'] +
        $data['ru_stime.tv_usec'] / 1000000) . "\n";

exit(0);
