<?php

namespace App\ZendEngine3\Hash;

use App\ZendEngine3\ZendTypes\Bucket;
use App\ZendEngine3\ZendTypes\HashTable;
use App\ZendEngine3\ZendTypes\ZendString;

/**
 * Class hashDelete - Deletes
 *
 * @package App\ZendEngine3\Hash
 *
 * Extern Zend/zend_hash.h line 163
 */
class HashDelete {
    private function __construct() { // Static only
    }

    /**
     * Extern Zend/zend_hash.h line 164
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @return int
     */
    public static function zend_hash_del(HashTable $ht, ZendString $key): int {
    }

    /**
     * Extern Zend/zend_hash.h line 165
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @return int
     */
    public static function zend_hash_del_ind(HashTable $ht, ZendString $key): int {
    }

    /**
     * Extern Zend/zend_hash.h line 166
     *
     * @param HashTable $ht
     * @param string $key
     * @param int $len
     * @return int
     */
    public static function zend_hash_str_del(HashTable $ht, string $key, int $len): int {
    }

    /**
     * Extern Zend/zend_hash.h line 167
     *
     * @param HashTable $ht
     * @param string $key
     * @param int $len
     * @return int
     */
    public static function zend_hash_str_del_ind(HashTable $ht, string $key, int $len): int {
    }

    /**
     * Extern Zend/zend_hash.h line 168
     *
     * @param HashTable $ht
     * @param int $h
     * @return int
     */
    public static function zend_hash_index_del(HashTable $ht, int $h): int {
    }

    /**
     * Extern Zend/zend_hash.h line 169
     *
     * @param HashTable $ht
     * @param Bucket $p
     */
    public static function zend_hash_del_bucket(HashTable $ht, Bucket $p): void {
    }
}
