<?php

namespace App\Shell;

use App\ZendEngine3\Hash\HashResize;
use App\ZendEngine3\ZendTypes\HashTable;
use App\ZendEngine3\ZendTypes\ZendString;
use Cake\Console\Shell;

class HashingShell extends Shell {
    /**
     * @param mixed ...$args
     * @return int
     * @throws \Exception
     */
    public function main(...$args): int {
        $ht = new HashTable();
        $a = ['the' => 'article', 'book' => 'noun', 'read' => 'verb',
            'hash' => 'table', 'bucket' => 'slot', 'string' => 'key',
            'throw' => 'fit', 'expand' => 'table', 'size' => 'double',
            'PHP' => 1, 'C' => 2,
        ];
        $nValues = count($a);
        $nValues = HashResize::zend_hash_check_size($nValues);
        $ht->nTableSize = $nValues;
        $ht->nTableMask = HashTable::HT_SIZE_TO_MASK($nValues);
        $ht->nNumUsed = $nValues;
        $b = [];
        $indexes = [];
        foreach ($a as $key => $value) {
            $h = ZendString::fakeHash($value);
            $idx = $h | $ht->nTableMask;
            $indexes[] = $idx;
            $b[$key] = ['h' => $h, 'idx' => $idx, 'value' => $value];
        }
        sort($indexes, SORT_NUMERIC);
        print_r(['ht' => $ht, 'b' => $b, 'idx' => $indexes]);
        return 0;
    }
}
