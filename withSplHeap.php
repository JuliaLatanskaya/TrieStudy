
<?php

class Trie
{
    public function __construct()
    {
        $this->root = new Node();
    }

    public function addPhone(String $phone)
    {
        $current = $this->root;
        $phone = SplFixedArray::fromArray(str_split($phone));

        while ($phone->valid()) {
            $current = $current->addChild($phone->current());

            if (!$current) {
                return false;
            }

            $phone->next();
        }
        return $current->makeLeaf();
    }
}

class Node
{
    public $children = null;
    public $isLeaf = false;

    public function addChild($value)
    {
        if ($this->isLeaf()) {
            return false;
        }

        if (!$this->children) {
            $this->children = new SplFixedArray(10);
        }

        if (!$this->children->offsetExists($value)) {
            $this->children->offsetSet($value, new Node());
        }

        return $this->children->offsetGet($value);
    }

    public function isLeaf()
    {
        return $this->isLeaf;
    }

    public function makeLeaf()
    {
        if (!$this->children) {
            $this->isLeaf = true;
        }

        return $this->isLeaf;
    }
}

class PhoneList extends SplHeap
{
    public function compare($phone1, $phone2)
    {
        return 1;
    }
}

function file_lines()
{
    $file = fopen('php://stdin', 'r');
    $testCases = fgets($file);
    while ($testCases) {
        $testCases -= 1;
        $lines = fgets($file);
        $phoneList = new PhoneList();
        while ($lines) {
            $lines -= 1;
            $phoneList->insert(trim(fgets($file)));
        }
        yield $phoneList;

    }
    fclose($file);
}

foreach (file_lines() as $phoneList) {
    $trie = new Trie();
    $result = true;
    while ($phoneList->valid()) {
        if (!$trie->addPhone($phoneList->current())) {
            $result = false;
            break;
        }

        $phoneList->next();
    }
    fprintf(STDOUT, "%s\n", $result ? 'YES' : 'NO');

}

$data = getrusage();
echo "User time: ".
    ($data['ru_utime.tv_sec'] +
        $data['ru_utime.tv_usec'] / 1000000) . "\n";
echo "System time: ".
    ($data['ru_stime.tv_sec'] +
        $data['ru_stime.tv_usec'] / 1000000) . "\n";
exit(0);
