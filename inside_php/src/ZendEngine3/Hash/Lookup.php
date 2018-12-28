<?php

namespace App\ZendEngine3\Hash;

class Lookup {
    private function __construct() { // Static only
    }

    /**
     * Zend/zend_hash.c line 370
     *
     * @param HashTable $ht
     * @return int
     * @throws \Exception
     */
    private static function zend_array_recalc_elements(HashTable $ht): int {
        if ($ht) {
            throw new \Exception('ZEND_HASH_FOREACH not supported');
        }
    }

    /**
     * Zend/zend_hash.c line 386
     *
     * @param HashTable $ht
     * @return int
     */
    public static function zend_array_count(HashTable $ht): int {
        // Symbol table as hash table not supported
    }


}
