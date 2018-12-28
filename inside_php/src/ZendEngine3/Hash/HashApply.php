<?php

namespace App\ZendEngine3\Hash;

use App\ZendEngine3\ZendTypes\HashTable;

/**
 * Class HashApply
 *
 * @package App\ZendEngine3\Hash
 *
 * Zend/zend_hash.h line 133
 */
class HashApply {
    /* Zend/zend_hash.h line 133 */
    public CONST ZEND_HASH_APPLY_KEEP = 0;
    public CONST ZEND_HASH_APPLY_REMOVE = 1;
    public CONST ZEND_HASH_APPLY_STOP = 2;

    private function __construct() { // Static only
    }

    /**
     * Extern Zend/zend_types.h line 141
     *
     * @param HashTable $ht
     */
    public static function zend_hash_graceful_destroy(HashTable $ht): void {
    }

    /**
     * Extern Zend/zend_types.h line 142
     *
     * @param HashTable $ht
     */
    public static function zend_hash_graceful_reverse_destroy(HashTable $ht): void {
    }

    /**
     * Extern Zend/zend_types.h line 143
     *
     * @param HashTable $ht
     * @param callable $apply_func
     */
    public static function zend_hash_apply(HashTable $ht, callable $apply_func): void {
    }

    /**
     * Extern Zend/zend_types.h line 144
     *
     * @param HashTable $ht
     * @param callable $apply_func
     * @param int $arg
     */
    public static function zend_hash_apply_with_argument(HashTable $ht, callable $apply_func, int $arg): void {
    }

    /**
     * Extern Zend/zend_types.h line 145
     *
     * @param HashTable $ht
     * @param callable $apply_func
     * @param int $argc
     * @param $args
     */
    public static function zend_hash_apply_with_arguments(HashTable $ht, callable $apply_func, int $argc,
        ...$args): void {
    }

    /**
     * Extern Zend/zend_types.h line 153
     *
     * @param \App\ZendEngine3\ZendTypes\HashTable $ht
     * @param callable $apply_func
     */
    public static function zend_hash_reverse_apply(HashTable $ht, callable $apply_func): void {
        /* This function should be used with special care (in other words,
		 * it should usually not be used).  When used with the ZEND_HASH_APPLY_STOP
		 * return value, it assumes things about the order of the elements in the hash.
		 * Also, it does not provide the same kind of reentrancy protection that
		 * the standard apply functions do.
		 */
    }
}
