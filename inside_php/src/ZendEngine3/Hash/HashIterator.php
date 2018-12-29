<?php

namespace App\ZendEngine3\Hash;

use App\ZendEngine3\ZendTypes\HashTable;
use App\ZendEngine3\ZendTypes\Zval;

class HashIterator {
    private function __construct() { // Static only
    }

    /**
     * Extern Zend/zend_hash.h line 306
     * Zend/zend_hash.c line 428
     *
     * @param HashTable $ht
     * @param int $pos
     * @return int
     * @throws \Exception
     */
    public static function zend_hash_iterator_add(HashTable $ht, int $pos): int {
        if ($ht || $pos) {
            throw new \Exception('Iterator not supported');
        }
        return 0;
    }

    /**
     * Extern Zend/zend_hash.h line 307
     * Zend/zend_hash.c line 465
     *
     * @param int $idx
     * @param HashTable $ht
     * @return int
     * @throws \Exception
     */
    public static function zend_hash_iterator_pos(int $idx, HashTable $ht): int {
        if ($idx || $ht) {
            throw new \Exception('Iterator not supported');
        }
        return 0;
    }

    /**
     * Extern Zend/zend_hash.h line 308
     * Zend/zend_hash.c line 484
     *
     * @param int $idx
     * @param Zval $array
     * @return int
     * @throws \Exception
     */
    public static function zend_hash_iterator_pos_ex(int $idx, Zval $array): int {
        if ($idx || $array) {
            throw new \Exception('Iterator not supported');
        }
        return 0;
    }

    /**
     * Extern Zend/zend_hash.h line 309
     * Zend/zend_hash.c line 506
     *
     * @param int $idx
     * @throws \Exception
     */
    public static function zend_hash_iterator_del(int $idx): void {
        if ($idx) {
            throw new \Exception('Iterator not supported');
        }
    }

    /**
     * Zend/zend_hash.c line 526
     *
     * @param HashTable $ht
     * @throws \Exception
     */
    private static function _zend_hash_iterators_remove(HashTable $ht): void {
        if ($ht) {
            throw new \Exception('Iterator not supported');
        }
    }

    /**
     * Zend/zend_hash.c line 539
     * Referenced lines 1539, 1589
     *
     * @param HashTable $ht
     * @throws \Exception
     */
    private static function zend_hash_iterators_remove(HashTable $ht): void {
        if (HashTable::HT_HAS_ITERATORS($ht)) {
            HashIterator::_zend_hash_iterators_remove($ht);
        }
    }

    /**
     * Extern Zend/zend_hash.h line 310
     * Zend/zend_hash.c line 546
     *
     * @param HashTable $ht
     * @param int $start
     * @return int
     * @throws \Exception
     */
    public static function zend_hash_iterators_lower_pos(HashTable $ht, int $start): int {
        if ($ht || $start) {
            throw new \Exception('Iterator not supported');
        }
        return 0;
    }

    /**
     * Extern Zend/zend_hash.h line 311
     * Zend/zend_hash.c line 563
     *
     * @param HashTable $ht
     * @param int $from
     * @param int $to
     * @throws \Exception
     */
    public static function _zend_hash_iterators_update(HashTable $ht, int $from, int $to): void {
        if ($ht || $from || $to) {
            throw new \Exception('Iterator not supported');
        }
    }

    /**
     * Extern Zend/zend_hash.h line 312
     * Zend/zend_hash.c line 576
     *
     * @param HashTable $ht
     * @param int $step
     * @throws \Exception
     */
    public static function zend_hash_iterators_advance(HashTable $ht, int $step): void {
        if ($ht || $step) {
            throw new \Exception('Iterator not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 314
     *
     * @param HashTable $ht
     * @param int $from
     * @param int $to
     * @throws \Exception
     */
    public static function zend_hash_iterators_update(HashTable $ht, int $from, int $to): void {
        if (HashTable::HT_HAS_ITERATORS($ht)) {
            HashIterator::_zend_hash_iterators_update($ht, $from, $to);
        }
    }
}
