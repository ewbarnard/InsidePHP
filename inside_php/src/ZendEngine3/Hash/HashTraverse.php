<?php

namespace App\ZendEngine3\Hash;

use App\ZendEngine3\ZendTypes\HashTable;
use App\ZendEngine3\ZendTypes\ZendString;
use App\ZendEngine3\ZendTypes\ZendTypes;
use App\ZendEngine3\ZendTypes\Zval;

/**
 * Class HashTraverse - Traversing
 *
 * @package App\ZendEngine3\Hash
 *
 * Extern Zend/zend_hash.h line 224
 */
class HashTraverse {
    private function __construct() { // Static only
    }

    /**
     * Extern Zend/zend_hash.h line 225
     *
     * @param HashTable $ht
     * @return int
     */
    public static function zend_hash_get_current_pos(HashTable $ht): int {
    }

    /**
     * Zend/zend_hash.h line 227
     *
     * @param HashTable $ht
     * @param int $pos
     * @return int
     */
    public static function zend_hash_has_more_elements_ex(HashTable $ht, int $pos): int {
        return (HashTraverse::zend_hash_get_current_key_type_ex($ht, $pos) == HashTable::HASH_KEY_NON_EXISTENT ?
            ZendTypes::FAILURE : ZendTypes::SUCCESS);
    }

    /**
     * Extern Zend/zend_hash.h line 229
     *
     * @param HashTable $ht
     * @param int $pos
     * @return int
     */
    public static function zend_hash_move_forward_ex(HashTable $ht, int $pos): int {
    }

    /**
     * Extern Zend/zend_hash.h line 230
     *
     * @param HashTable $ht
     * @param int $pos
     * @return int
     */
    public static function zend_hash_move_backwards_ex(HashTable $ht, int $pos): int {
    }

    /**
     * Extern Zend/zend_hash.h line 231
     *
     * @param HashTable $ht
     * @param ZendString $str_index
     * @param int $num_index
     * @param int $pos
     * @return int
     */
    public static function zend_hash_get_current_key_ex(HashTable $ht, ZendString $str_index, int $num_index,
        int $pos): int {
    }

    /**
     * Extern Zend/zend_hash.h line 232
     *
     * @param HashTable $ht
     * @param Zval $key
     * @param int $pos
     */
    public static function zend_hash_get_current_key_zval_ex(HashTable $ht, Zval $key, int $pos): void {
    }

    /**
     * Extern Zend/zend_hash.h line 233
     *
     * @param HashTable $ht
     * @param int $pos
     * @return int
     */
    public static function zend_hash_get_current_key_type_ex(HashTable $ht, int $pos): int {
    }

    /**
     * Extern Zend/zend_hash.h line 234
     *
     * @param HashTable $ht
     * @param int $pos
     * @return Zval
     */
    public static function zend_hash_get_current_data_ex(HashTable $ht, int $pos): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 235
     *
     * @param HashTable $ht
     * @param int $pos
     */
    public static function zend_hash_internal_pointer_reset_ex(HashTable $ht, int $pos): void {
    }

    /**
     * Extern Zend/zend_hash.h line 236
     *
     * @param HashTable $ht
     * @param int $pos
     */
    public static function zend_hash_internal_pointer_end_ex(HashTable $ht, int $pos): void {
    }

    /**
     * Zend/zend_hash.h line 238
     *
     * @param HashTable $ht
     * @return int
     */
    public static function zend_hash_has_more_elements(HashTable $ht): int {
        return HashTraverse::zend_hash_has_more_elements_ex($ht, $ht->nInternalPointer);
    }

    /**
     * Zend/zend_hash.h line 240
     *
     * @param HashTable $ht
     * @return int
     */
    public static function zend_hash_move_forward(HashTable $ht): int {
        return HashTraverse::zend_hash_move_forward_ex($ht, $ht->nInternalPointer);
    }

    /**
     * Zend/zend_hash.h line 242
     *
     * @param HashTable $ht
     * @return int
     */
    public static function zend_hash_move_backwards(HashTable $ht): int {
        return HashTraverse::zend_hash_move_backwards_ex($ht, $ht->nInternalPointer);
    }

    /**
     * Zend/zend_hash.h line 244
     *
     * @param HashTable $ht
     * @param ZendString $str_index
     * @param int $num_index
     * @return int
     */
    public static function zend_hash_get_current_key(HashTable $ht, ZendString $str_index, int $num_index): int {
        return HashTraverse::zend_hash_get_current_key_ex($ht, $str_index, $num_index, $ht->nInternalPointer);
    }

    /**
     * Zend/zend_hash.h line 246
     *
     * @param HashTable $ht
     * @param Zval $key
     */
    public static function zend_hash_get_current_key_zval(HashTable $ht, Zval $key): void {
        HashTraverse::zend_hash_get_current_key_zval_ex($ht, $key, $ht->nInternalPointer);
    }

    /**
     * Zend/zend_hash.h line 248
     *
     * @param HashTable $ht
     * @return int
     */
    public static function zend_hash_get_current_key_type(HashTable $ht): int {
        return HashTraverse::zend_hash_get_current_key_type_ex($ht, $ht->nInternalPointer);
    }

    /**
     * Zend/zend_hash.h line 250
     *
     * @param HashTable $ht
     * @return Zval
     */
    public static function zend_hash_get_current_data(HashTable $ht): Zval {
        return HashTraverse::zend_hash_get_current_data_ex($ht, $ht->nInternalPointer);
    }

    /**
     * Zend/zend_hash.h line 252
     *
     * @param HashTable $ht
     */
    public static function zend_hash_internal_pointer_reset(HashTable $ht): void {
        HashTraverse::zend_hash_internal_pointer_reset_ex($ht, $ht->nInternalPointer);
    }

    /**
     * Zend/zend_hash.h line 254
     *
     * @param HashTable $ht
     */
    public static function zend_hash_internal_pointer_end(HashTable $ht): void {
        HashTraverse::zend_hash_internal_pointer_end_ex($ht, $ht->nInternalPointer);
    }
}
