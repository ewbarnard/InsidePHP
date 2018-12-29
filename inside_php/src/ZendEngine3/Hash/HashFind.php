<?php

namespace App\ZendEngine3\Hash;


use App\ZendEngine3\ZendTypes\Bucket;
use App\ZendEngine3\ZendTypes\HashTable;
use App\ZendEngine3\ZendTypes\ZendString;
use App\ZendEngine3\ZendTypes\Zval;

/**
 * Class HashFind - Data Retrieval
 *
 * @package App\ZendEngine3\Hash
 *
 * Extern Zend/zend_hash.h line 171
 */
class HashFind {
    private function __construct() { // Static only
    }

    /**
     * Extern Zend/zend_hash.h line 172
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @return Zval|null
     */
    public static function zend_hash_find(HashTable $ht, ZendString $key): ?Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 173
     *
     * @param HashTable $ht
     * @param string $key
     * @param int $len
     * @return Zval
     */
    public static function zend_hash_str_find(HashTable $ht, string $key, int $len): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 174
     *
     * @param HashTable $ht
     * @param int $h
     * @return Zval
     */
    public static function zend_hash_index_find(HashTable $ht, int $h): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 175
     *
     * @param HashTable $ht
     * @param int $h
     * @return Zval
     */
    public static function _zend_hash_index_find(HashTable $ht, int $h): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 178
     * The same as zend_hash_find(), but hash value of the key must be already calculated
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @return Zval
     */
    public static function _zend_hash_find_known_hash(HashTable $ht, ZendString $key): Zval {
    }

    /**
     * Zend/zend_hash.h line 180
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param bool $known_hash
     * @return Zval
     */
    public static function zend_hash_find_ex(HashTable $ht, ZendString $key, bool $known_hash): Zval {
        if ($known_hash) {
            return HashFind::_zend_hash_find_known_hash($ht, $key);
        } else {
            return HashFind::zend_hash_find($ht, $key);
        }
    }

    /**
     * Zend/zend_hash.h line 209
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @return bool
     */
    public static function zend_hash_exists(HashTable $ht, ZendString $key): bool {
        return (HashFind::zend_hash_find($ht, $key) !== null);
    }

    /**
     * Zend/zend_hash.h line 214
     *
     * @param HashTable $ht
     * @param string $str
     * @param int $len
     * @return bool
     */
    public static function zend_hash_str_exists(HashTable $ht, string $str, int $len): bool {
        return (HashFind::zend_hash_str_find($ht, $str, $len) !== null);
    }

    /**
     * Zend/zend_hash.h line 219
     *
     * @param HashTable $ht
     * @param int $h
     * @return bool
     */
    public static function zend_hash_index_exists(HashTable $ht, int $h): bool {
        return (HashFind::zend_hash_index_find($ht, $h) !== null);
    }

    /**
     * Zend/zend_hash.h line 355
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @return Zval
     * @throws \Exception
     */
    public static function zend_hash_find_ind(HashTable $ht, ZendString $key): Zval {
        if ($ht || $key) {
            throw new \Exception('Indirect not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 365
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param bool $known_hash
     * @return Zval
     * @throws \Exception
     */
    public static function zend_hash_find_ex_ind(HashTable $ht, ZendString $key, bool $known_hash): Zval {
        if ($ht || $key || $known_hash) {
            throw new \Exception('Indirect not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 375
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @return int
     * @throws \Exception
     */
    public static function zend_hash_exists_ind(HashTable $ht, ZendString $key): int {
        if ($ht || $key) {
            throw new \Exception('Indirect not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 385
     *
     * @param HashTable $ht
     * @param string $str
     * @param int $len
     * @return Zval
     * @throws \Exception
     */
    public static function zend_hash_str_find_ind(HashTable $ht, string $str, int $len): Zval {
        if ($ht || $str || $len) {
            throw new \Exception('Indirect not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 395
     *
     * @param HashTable $ht
     * @param string $str
     * @param int $len
     * @return int
     * @throws \Exception
     */
    public static function zend_hash_str_exists_ind(HashTable $ht, string $str, int $len): int {
        if ($ht || $str || $len) {
            throw new \Exception('Indirect not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 463
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @return Zval
     */
    public static function zend_symtable_find(HashTable $ht, ZendString $key): Zval {
        $idx = null;

        if (HashResize::ZEND_HANDLE_NUMERIC($key, $idx)) {
            return HashFind::zend_hash_index_find($ht, $idx);
        } else {
            return HashFind::zend_hash_find($ht, $key);
        }
    }

    /**
     * Zend/zend_hash.h line 475
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @return Zval
     * @throws \Exception
     */
    public static function zend_symtable_find_ind(HashTable $ht, ZendString $key): Zval {
        $idx = null;

        if (HashResize::ZEND_HANDLE_NUMERIC($key, $idx)) {
            return HashFind::zend_hash_index_find($ht, $idx);
        } else {
            return HashFind::zend_hash_find_ind($ht, $key);
        }
    }

    /**
     * Zend/zend_hash.h line 487
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @return int
     * @throws \Exception
     */
    public static function zend_symtable_exists(HashTable $ht, ZendString $key): int {
        $idx = null;

        if (HashResize::ZEND_HANDLE_NUMERIC($key, $idx)) {
            return HashFind::zend_hash_index_exists($ht, $idx);
        } else {
            return HashFind::zend_hash_exists($ht, $key);
        }
    }

    /**
     * Zend/zend_hash.h line 499
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @return int
     * @throws \Exception
     */
    public static function zend_symtable_exists_ind(HashTable $ht, ZendString $key): int {
        $idx = null;

        if (HashResize::ZEND_HANDLE_NUMERIC($key, $idx)) {
            return HashFind::zend_hash_index_exists($ht, $idx);
        } else {
            return HashFind::zend_hash_exists_ind($ht, $key);
        }
    }

    /**
     * Zend/zend_hash.h line 559
     *
     * @param HashTable $ht
     * @param string $str
     * @param int $len
     * @return Zval
     */
    public static function zend_symtable_str_find(HashTable $ht, string $str, int $len): Zval {
        $idx = null;

        if (HashResize::ZEND_HANDLE_NUMERIC_STR($str, $len, $idx)) {
            return HashFind::zend_hash_index_find($ht, $idx);
        } else {
            return HashFind::zend_hash_str_find($ht, $str, $len);
        }
    }

    /**
     * Zend/zend_hash.h line 571
     *
     * @param HashTable $ht
     * @param string $str
     * @param int $len
     * @return int
     */
    public static function zend_symtable_str_exists(HashTable $ht, string $str, int $len): int {
        $idx = null;

        if (HashResize::ZEND_HANDLE_NUMERIC_STR($str, $len, $idx)) {
            return HashFind::zend_hash_index_exists($ht, $idx);
        } else {
            return HashFind::zend_hash_str_exists($ht, $str, $len);
        }
    }

    /**
     * Zend/zend_hash.h line 805
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @throws \Exception
     */
    public static function zend_hash_find_ptr(HashTable $ht, ZendString $key): void {
        if ($ht || $key) {
            throw new \Exception('Pointers not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 818
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param bool $known_hash
     * @throws \Exception
     */
    public static function zend_hash_find_ex_ptr(HashTable $ht, ZendString $key, bool $known_hash): void {
        if ($ht || $key || $known_hash) {
            throw new \Exception('Pointers not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 831
     *
     * @param HashTable $ht
     * @param string $str
     * @param int $len
     * @throws \Exception
     */
    public static function zend_hash_str_find_ptr(HashTable $ht, string $str, int $len): void {
        if ($ht || $str || $len) {
            throw new \Exception('Pointers not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 844
     *
     * @param HashTable $ht
     * @param int $h
     * @throws \Exception
     */
    public static function zend_hash_index_find_ptr(HashTable $ht, int $h): void {
        if ($ht || $h) {
            throw new \Exception('Pointers not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 857
     *
     * @param HashTable $ht
     * @param int $h
     * @throws \Exception
     */
    public static function zend_hash_index_find_deref(HashTable $ht, int $h): void {
        if ($ht || $h) {
            throw new \Exception('Dereference not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 866
     *
     * @param HashTable $ht
     * @param ZendString $str
     * @throws \Exception
     */
    public static function zend_hash_find_deref(HashTable $ht, ZendString $str): void {
        if ($ht || $str) {
            throw new \Exception('Dereference not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 875
     *
     * @param HashTable $ht
     * @param string $str
     * @param int $len
     * @throws \Exception
     */
    public static function zend_hash_str_find_deref(HashTable $ht, string $str, int $len): void {
        if ($ht || $str || $len) {
            throw new \Exception('Dereference not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 884
     *
     * @param HashTable $ht
     * @param string $str
     * @param int $len
     * @throws \Exception
     */
    public static function zend_symtable_str_find_ptr(HashTable $ht, string $str, int $len): void {
        if ($ht || $str || $len) {
            throw new \Exception('Pointers not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 895
     *
     * @param HashTable $ht
     * @param int $pos
     * @throws \Exception
     */
    public static function zend_hash_get_current_data_ptr_ex(HashTable $ht, int $pos): void {
        if ($ht || $pos) {
            throw new \Exception('Pointers not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 908
     *
     * @param HashTable $ht
     * @throws \Exception
     */
    public static function zend_hash_get_current_data_ptr(HashTable $ht): void {
        HashFind::zend_hash_get_current_data_ptr_ex($ht, $ht->nInternalPointer);
    }

    /**
     * Zend/zend_hash.h line 911
     *
     * @param HashTable $_ht
     * @param bool $indirect
     * @throws \Exception
     */
    public static function ZEND_HASH_FOREACH(HashTable $_ht, bool $indirect): void {
        if ($_ht || $indirect) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 922
     *
     * @param HashTable $_ht
     * @param bool $indirect
     * @throws \Exception
     */
    public static function ZEND_HASH_REVERSE_FOREACH(HashTable $_ht, bool $indirect): void {
        if ($_ht || $indirect) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 935
     *
     * @throws \Exception
     */
    public static function ZEND_HASH_FOREACH_END(): void {
        throw new \Exception('HASH FOREACH not implemented');
    }

    /**
     * Zend/zend_hash.h line 939
     *
     * @throws \Exception
     */
    public static function ZEND_HASH_FOREACH_END_DEL(): void {
        throw new \Exception('HASH FOREACH not implemented');
    }

    /**
     * Zend/zend_hash.h line 960
     *
     * @param HashTable $ht
     * @param Bucket $_bucket
     * @throws \Exception
     */
    public static function ZEND_HASH_FOREACH_BUCKET(HashTable $ht, Bucket $_bucket): void {
        if ($ht || $_bucket) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 964
     *
     * @param HashTable $ht
     * @param int $_val
     * @throws \Exception
     */
    public static function ZEND_HASH_FOREACH_VAL(HashTable $ht, int $_val): void {
        if ($ht || $_val) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 968
     *
     * @param HashTable $ht
     * @param int $_val
     * @throws \Exception
     */
    public static function ZEND_HASH_FOREACH_VAL_IND(HashTable $ht, int $_val): void {
        if ($ht || $_val) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 972
     *
     * @param HashTable $ht
     * @param int $_ptr
     * @throws \Exception
     */
    public static function ZEND_HASH_FOREACH_PTR(HashTable $ht, int $_ptr): void {
        if ($ht || $_ptr) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 976
     *
     * @param HashTable $ht
     * @param int $_h
     * @throws \Exception
     */
    public static function ZEND_HASH_FOREACH_NUM_KEY(HashTable $ht, int $_h): void {
        if ($ht || $_h) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 980
     *
     * @param HashTable $ht
     * @param int $_key
     * @throws \Exception
     */
    public static function ZEND_HASH_FOREACH_STR_KEY(HashTable $ht, int $_key): void {
        if ($ht || $_key) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 984
     *
     * @param HashTable $ht
     * @param int $_h
     * @param int $_key
     * @throws \Exception
     */
    public static function ZEND_HASH_FOREACH_KEY(HashTable $ht, int $_h, int $_key): void {
        if ($ht || $_h || $_key) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 989
     *
     * @param HashTable $ht
     * @param int $_h
     * @param int $_val
     * @throws \Exception
     */
    public static function ZEND_HASH_FOREACH_NUM_KEY_VAL(HashTable $ht, int $_h, int $_val): void {
        if ($ht || $_h || $_val) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 994
     *
     * @param HashTable $ht
     * @param int $_key
     * @param int $_val
     * @throws \Exception
     */
    public static function ZEND_HASH_FOREACH_STR_KEY_VAL(HashTable $ht, int $_key, int $_val): void {
        if ($ht || $_key || $_val) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 999
     *
     * @param HashTable $ht
     * @param int $_h
     * @param int $_key
     * @param int $_val
     * @throws \Exception
     */
    public static function ZEND_HASH_FOREACH_KEY_VAL(HashTable $ht, int $_h, int $_key, int $_val): void {
        if ($ht || $_h || $_key || $_val) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 1005
     *
     * @param HashTable $ht
     * @param int $_key
     * @param int $_val
     * @throws \Exception
     */
    public static function ZEND_HASH_FOREACH_STR_KEY_VAL_IND(HashTable $ht, int $_key, int $_val): void {
        if ($ht || $_key || $_val) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 1010
     *
     * @param HashTable $ht
     * @param int $_h
     * @param int $_key
     * @param int $_val
     * @throws \Exception
     */
    public static function ZEND_HASH_FOREACH_KEY_VAL_IND(HashTable $ht, int $_h, int $_key, int $_val): void {
        if ($ht || $_h || $_key || $_val) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 1016
     *
     * @param HashTable $ht
     * @param int $_h
     * @param int $_ptr
     * @throws \Exception
     */
    public static function ZEND_HASH_FOREACH_NUM_KEY_PTR(HashTable $ht, int $_h, int $_ptr): void {
        if ($ht || $_h || $_ptr) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 1021
     *
     * @param HashTable $ht
     * @param int $_key
     * @param int $_ptr
     * @throws \Exception
     */
    public static function ZEND_HASH_FOREACH_STR_KEY_PTR(HashTable $ht, int $_key, int $_ptr): void {
        if ($ht || $_key || $_ptr) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 1026
     *
     * @param HashTable $ht
     * @param int $_h
     * @param int $_key
     * @param int $_ptr
     * @throws \Exception
     */
    public static function ZEND_HASH_FOREACH_KEY_PTR(HashTable $ht, int $_h, int $_key, int $_ptr): void {
        if ($ht || $_h || $_key || $_ptr) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 1032
     *
     * @param HashTable $ht
     * @param \App\ZendEngine3\ZendTypes\Bucket $_bucket
     * @throws \Exception
     */
    public static function ZEND_HASH_REVERSE_FOREACH_BUCKET(HashTable $ht, Bucket $_bucket): void {
        if ($ht || $_bucket) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 1036
     *
     * @param HashTable $ht
     * @param int $_val
     * @throws \Exception
     */
    public static function ZEND_HASH_REVERSE_FOREACH_VAL(HashTable $ht, int $_val): void {
        if ($ht || $_val) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 1040
     *
     * @param HashTable $ht
     * @param int $_ptr
     * @throws \Exception
     */
    public static function ZEND_HASH_REVERSE_FOREACH_PTR(HashTable $ht, int $_ptr): void {
        if ($ht || $_ptr) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 1044
     *
     * @param HashTable $ht
     * @param int $_ptr
     * @throws \Exception
     */
    public static function ZEND_HASH_REVERSE_FOREACH_VAL_IND(HashTable $ht, int $_ptr): void {
        if ($ht || $_ptr) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 1048
     *
     * @param HashTable $ht
     * @param int $_key
     * @param int $_val
     * @throws \Exception
     */
    public static function ZEND_HASH_REVERSE_FOREACH_STR_KEY_VAL(HashTable $ht, int $_key, int $_val): void {
        if ($ht || $_key || $_val) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 1053
     *
     * @param HashTable $ht
     * @param int $_h
     * @param int $_key
     * @param int $_val
     * @throws \Exception
     */
    public static function ZEND_HASH_REVERSE_FOREACH_KEY_VAL(HashTable $ht, int $_h, int $_key, int $_val): void {
        if ($ht || $_h || $_key || $_val) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

    /**
     * Zend/zend_hash.h line 1059
     *
     * @param HashTable $ht
     * @param int $_h
     * @param int $_key
     * @param int $_val
     * @throws \Exception
     */
    public static function ZEND_HASH_REVERSE_FOREACH_KEY_VAL_IND(HashTable $ht, int $_h, int $_key, int $_val): void {
        if ($ht || $_h || $_key || $_val) {
            throw new \Exception('HASH FOREACH not implemented');
        }
    }

}
