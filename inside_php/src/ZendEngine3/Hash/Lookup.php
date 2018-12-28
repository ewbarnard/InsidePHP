<?php

namespace App\ZendEngine3\Hash;

use App\ZendEngine3\Zval\Zval;

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
     * @throws \Exception
     */
    public static function zend_array_count(HashTable $ht): int {
        // Symbol table as hash table not supported

        if ($ht->HASH_FLAG_HAS_EMPTY_IND) {
            $num = static::zend_array_recalc_elements($ht);
            if ($ht->nNumOfElements === $num) {
                $ht->HASH_FLAG_HAS_EMPTY_IND = 0;
            }
        } else {
            $num = static::zend_hash_num_elements($ht);
        }
        return $num;
    }

    /**
     * Zend/zend_hash.c line 403
     *
     * @param HashTable $ht
     * @return int
     */
    private static function _zend_hash_get_first_pos(HashTable $ht): int {
        $pos = 0;

        while (($pos < $ht->nNumUsed) && static::Z_ISUNDEF($ht, $pos)) {
            $pos++;
        }
        return $pos;
    }

    /**
     * Zend/zend_hash.c line 413
     *
     * @param HashTable $ht
     * @return int
     */
    private static function _zend_hash_get_current_pos(HashTable $ht): int {
        $pos = $ht->nInternalPointer;

        if ($pos === 0) {
            $pos = static::_zend_hash_get_first_pos($ht);
        }
        return $pos;
    }

    /**
     * Zend/zend_hash.c line 423
     *
     * @param HashTable $ht
     * @return int
     */
    public static function zend_hash_get_current_pos(HashTable $ht): int {
        return static::_zend_hash_get_current_pos($ht);
    }

    /**
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
    }

    /**
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
    }

    /**
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
    }

    /**
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
        if (HashResize::HT_HAS_ITERATORS($ht)) {
            static::_zend_hash_iterators_remove($ht);
        }
    }
//FIXME 546

    /**
     * Zend/zend_hash.h line 264
     *
     * @param HashTable $ht
     * @return int
     */
    public static function zend_hash_num_elements(HashTable $ht): int {
        return $ht->nNumOfElements;
    }

    public static function Z_ISUNDEF(HashTable $ht, int $slot): bool {
        $p = $ht->arData[$slot];
        return (($p === null) || ($p->val->type === Zval::IS_UNDEF));
    }
}
