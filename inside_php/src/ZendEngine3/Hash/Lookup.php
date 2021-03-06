<?php

namespace App\ZendEngine3\Hash;

use App\ZendEngine3\ZendTypes\Bucket;
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
        return 0;
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
            $num = Lookup::zend_array_recalc_elements($ht);
            if ($ht->nNumOfElements === $num) {
                $ht->HASH_FLAG_HAS_EMPTY_IND = 0;
            }
        } else {
            $num = Lookup::zend_hash_num_elements($ht);
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
        return Lookup::_zend_hash_get_current_pos($ht);
    }

    /**
     * Zend/zend_hash.c line 589
     *
     * @param HashTable $ht
     * @param string $key
     * @param bool $known_hash
     * @return Bucket
     */
    private static function zend_hash_find_bucket(HashTable $ht, string $key, bool $known_hash): Bucket {

    }


    public static function Z_ISUNDEF(HashTable $ht, int $slot): bool {
        $p = $ht->arData[$slot];
        return (($p === null) || ($p->val->type === Zval::IS_UNDEF));
    }
}
