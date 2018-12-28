<?php

namespace App\ZendEngine3\Hash;

use App\ZendEngine3\ZendTypes\Bucket;
use App\ZendEngine3\ZendTypes\HashTable;
use App\ZendEngine3\ZendTypes\Zval;

/**
 * Class HashCopy
 *
 * @package App\ZendEngine3\Hash
 *
 * Extern Zend/zend_hash.h line 257
 */
class HashCopy {
    private function __construct() { // Static only
    }

    /**
     * Extern Zend/zend_hash.h line 258
     *
     * @param HashTable $target
     * @param HashTable $source
     * @param callable $pCopyConstructor
     */
    public static function zend_hash_copy(HashTable $target, HashTable $source, callable $pCopyConstructor): void {
    }

    /**
     * Extern Zend/zend_hash.h line 259
     *
     * @param HashTable $target
     * @param HashTable $source
     * @param callable $pCopyConstructor
     * @param bool $overwrite
     */
    public static function zend_hash_merge(HashTable $target, HashTable $source, callable $pCopyConstructor,
        bool $overwrite): void {
    }

    /**
     * Extern Zend/zend_hash.h line 260
     *
     * @param HashTable $target
     * @param HashTable $source
     * @param callable $pCopyConstructor
     * @param callable $pMergeSource
     * @param int $pParam
     */
    public static function zend_hash_merge_ex(HashTable $target, HashTable $source, callable $pCopyConstructor,
        callable $pMergeSource, int $pParam) {
    }

    /**
     * Extern Zend/zend_hash.h line 261
     *
     * @param Bucket $p
     * @param Bucket $q
     */
    public static function zend_hash_bucket_swap(Bucket $p, Bucket $q): void {
    }

    /**
     * Extern Zend/zend_hash.h line 262
     *
     * @param Bucket $p
     * @param Bucket $q
     */
    public static function zend_hash_bucket_renum_swap(Bucket $p, Bucket $q): void {
    }

    /**
     * Extern Zend/zend_hash.h line 263
     *
     * @param Bucket $p
     * @param Bucket $q
     */
    public static function zend_hash_bucket_packed_swap(Bucket $p, Bucket $q): void {
    }

    /**
     * Extern Zend/zend_hash.h line 264
     *
     * @param HashTable $ht1
     * @param HashTable $ht2
     * @param callable $compar
     * @param bool $ordered
     * @return int
     */
    public static function zend_hash_compare(HashTable $ht1, HashTable $ht2, callable $compar, bool $ordered): int {
    }

    /**
     * Extern Zend/zend_hash.h line 265
     *
     * @param HashTable $ht
     * @param callable $sort_func
     * @param callable $compare_func
     * @param bool $renumber
     * @return int
     */
    public static function zend_hash_sort_ex(HashTable $ht, callable $sort_func, callable $compare_func,
        bool $renumber): int {
    }

    /**
     * Extern Zend/zend_hash.h line 266
     *
     * @param HashTable $ht
     * @param callable $compar
     * @param int $flag
     * @return Zval
     */
    public static function zend_hash_minmax(HashTable $ht, callable $compar, int $flag): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 268
     *
     * @param HashTable $ht
     * @param callable $compare_func
     * @param bool $renumber
     * @return int
     */
    public static function zend_hash_sort(HashTable $ht, callable $compare_func, bool $renumber): int {
        $zend_sort = function () {
        };
        return static::zend_hash_sort_ex($ht, $zend_sort, $compare_func, $renumber);
    }

    /**
     * Zend/zend_hash.h line 271
     *
     * @param HashTable $ht
     * @return int
     */
    public static function zend_hash_num_elements(HashTable $ht): int {
        return $ht->nNumOfElements;
    }

    /**
     * Zend/zend_hash.h line 274
     *
     * @param HashTable $ht
     * @return int
     */
    public static function zend_hash_next_free_element(HashTable $ht): int {
        return $ht->nNextFreeElement;
    }
}
