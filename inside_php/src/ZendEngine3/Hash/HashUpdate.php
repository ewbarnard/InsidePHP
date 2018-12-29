<?php

namespace App\ZendEngine3\Hash;

use App\ZendEngine3\ZendTypes\Bucket;
use App\ZendEngine3\ZendTypes\HashTable;
use App\ZendEngine3\ZendTypes\ZendString;
use App\ZendEngine3\ZendTypes\Zval;
use function throwException;

/**
 * Class HashUpdate - Additions/updates/changes
 *
 * @package App\ZendEngine3\Hash
 *
 * Extern Zend/zend_hash.h line 107
 */
class HashUpdate {
    private function __construct() { // Static only
    }

    /**
     * Extern Zend/zend_hash.h line 108
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param Zval $pData
     * @param int $flag
     * @return Zval
     */
    public static function zend_hash_add_or_update(HashTable $ht, ZendString $key, Zval $pData, int $flag): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 109
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param Zval $pData
     * @return Zval
     */
    public static function zend_hash_update(HashTable $ht, ZendString $key, Zval $pData): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 110
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param Zval $pData
     * @return Zval
     */
    public static function zend_hash_update_ind(HashTable $ht, ZendString $key, Zval $pData): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 111
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param Zval $pData
     * @return Zval
     */
    public static function zend_hash_add(HashTable $ht, ZendString $key, Zval $pData): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 112
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param Zval $pData
     * @return Zval
     */
    public static function zend_hash_add_new(HashTable $ht, ZendString $key, Zval $pData): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 114
     *
     * @param HashTable $ht
     * @param string $key
     * @param int $len
     * @param Zval $pData
     * @param int $flag
     * @return Zval
     */
    public static function zend_hash_str_add_or_update(HashTable $ht, string $key, int $len, Zval $pData,
        int $flag): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 115
     *
     * @param HashTable $ht
     * @param string $key
     * @param int $len
     * @param Zval $pData
     * @return Zval
     */
    public static function zend_hash_str_update(HashTable $ht, string $key, int $len, Zval $pData): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 116
     *
     * @param HashTable $ht
     * @param string $key
     * @param int $len
     * @param Zval $pData
     * @return Zval
     */
    public static function zend_hash_str_update_ind(HashTable $ht, string $key, int $len, Zval $pData): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 117
     *
     * @param HashTable $ht
     * @param string $key
     * @param int $len
     * @param Zval $pData
     * @return Zval
     */
    public static function zend_hash_str_add(HashTable $ht, string $key, int $len, Zval $pData): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 118
     *
     * @param HashTable $ht
     * @param string $key
     * @param int $len
     * @param Zval $pData
     * @return Zval
     */
    public static function zend_hash_str_add_new(HashTable $ht, string $key, int $len, Zval $pData): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 120
     *
     * @param HashTable $ht
     * @param int $h
     * @param Zval $pData
     * @param int $flag
     * @return Zval
     */
    public static function zend_hash_index_add_or_update(HashTable $ht, int $h, Zval $pData, int $flag): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 121
     *
     * @param HashTable $ht
     * @param int $h
     * @param Zval $pData
     * @return Zval
     */
    public static function zend_hash_index_add(HashTable $ht, int $h, Zval $pData): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 122
     *
     * @param HashTable $ht
     * @param int $h
     * @param Zval $pData
     * @return Zval
     */
    public static function zend_hash_index_add_new(HashTable $ht, int $h, Zval $pData): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 123
     *
     * @param HashTable $ht
     * @param int $h
     * @param Zval $pData
     * @return Zval
     */
    public static function zend_hash_index_update(HashTable $ht, int $h, Zval $pData): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 124
     *
     * @param HashTable $ht
     * @param Zval $pData
     * @return Zval
     */
    public static function zend_hash_next_index_insert(HashTable $ht, Zval $pData): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 125
     *
     * @param HashTable $ht
     * @param Zval $pData
     * @return Zval
     */
    public static function zend_hash_next_index_insert_new(HashTable $ht, Zval $pData): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 127
     *
     * @param HashTable $ht
     * @param int $h
     * @return Zval
     */
    public static function zend_hash_index_add_empty_element(HashTable $ht, int $h): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 128
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @return Zval
     */
    public static function zend_hash_add_empty_element(HashTable $ht, ZendString $key): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 129
     *
     * @param HashTable $ht
     * @param string $key
     * @param int $len
     * @return Zval
     */
    public static function zend_hash_str_add_empty_element(HashTable $ht, string $key, int $len): Zval {
    }

    /**
     * Extern Zend/zend_hash.h line 131
     *
     * @param HashTable $ht
     * @param Bucket $p
     * @param ZendString $key
     * @return Zval
     */
    public static function zend_hash_set_bucket_key(HashTable $ht, Bucket $p, ZendString $key): Zval {
    }

    /**
     * Zend/zend_hash.h line 404
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param Zval $pData
     * @return Zval
     */
    public static function zend_symtable_add_new(HashTable $ht, ZendString $key, Zval $pData): Zval {
        $idx = null;

        if (HashResize::ZEND_HANDLE_NUMERIC($key, $idx)) {
            return HashUpdate::zend_hash_index_add_new($ht, $idx, $pData);
        } else {
            return HashUpdate::zend_hash_add_new($ht, $key, $pData);
        }
    }

    /**
     * Zend/zend_hash.h line 415
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param Zval $pData
     * @return Zval
     */
    public static function zend_symtable_update(HashTable $ht, ZendString $key, Zval $pData): Zval {
        $idx = null;

        if (HashResize::ZEND_HANDLE_NUMERIC($key, $idx)) {
            return HashUpdate::zend_hash_index_update($ht, $idx, $pData);
        } else {
            return HashUpdate::zend_hash_update($ht, $key, $pData);
        }
    }

    /**
     * Zend/zend_hash.h line 427
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param Zval $pData
     * @return Zval
     */
    public static function zend_symtable_update_ind(HashTable $ht, ZendString $key, Zval $pData): Zval {
        $idx = null;

        if (HashResize::ZEND_HANDLE_NUMERIC($key, $idx)) {
            return HashUpdate::zend_hash_index_update($ht, $idx, $pData);
        } else {
            return HashUpdate::zend_hash_update_ind($ht, $key, $pData);
        }
    }

    /**
     * Zend/zend_hash.h line 511
     *
     * @param HashTable $ht
     * @param string $str
     * @param int $len
     * @param Zval $pData
     * @return Zval
     */
    public static function zend_symtable_str_update(HashTable $ht, string $str, int $len, Zval $pData): Zval {
        $idx = null;

        if (HashResize::ZEND_HANDLE_NUMERIC_STR($str, $len, $idx)) {
            return HashUpdate::zend_hash_index_update($ht, $idx, $pData);
        } else {
            return HashUpdate::zend_hash_str_update($ht, $str, $len, $pData);
        }
    }

    /**
     * Zend/zend_hash.h line 523
     *
     * @param HashTable $ht
     * @param string $str
     * @param int $len
     * @param Zval $pData
     * @return Zval
     */
    public static function zend_symtable_str_update_ind(HashTable $ht, string $str, int $len, Zval $pData): Zval {
        $idx = null;

        if (HashResize::ZEND_HANDLE_NUMERIC_STR($str, $len, $idx)) {
            return HashUpdate::zend_hash_index_update($ht, $idx, $pData);
        } else {
            return HashUpdate::zend_hash_str_update_ind($ht, $str, $len, $pData);
        }
    }

    /**
     * Zend/zend_hash.h line 582
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param Zval $pData
     * @throws \Exception
     */
    public static function zend_hash_add_ptr(HashTable $ht, ZendString $key, Zval $pData): void {
        if ($ht || $key || $pData) {
            throw new \Exception('Pointers not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 596
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param Zval $pData
     * @throws \Exception
     */
    public static function zend_hash_add_new_ptr(HashTable $ht, ZendString $key, Zval $pData): void {
        if ($ht || $key || $pData) {
            throw new \Exception('Pointers not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 610
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param int $len
     * @param Zval $pData
     * @throws \Exception
     */
    public static function zend_hash_str_add_ptr(HashTable $ht, ZendString $key, int $len, Zval $pData): void {
        if ($ht || $key || $len || $pData) {
            throw new \Exception('Pointers not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 624
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param int $len
     * @param Zval $pData
     * @throws \Exception
     */
    public static function zend_hash_str_add_new_ptr(HashTable $ht, ZendString $key, int $len, Zval $pData): void {
        if ($ht || $key || $len || $pData) {
            throw new \Exception('Pointers not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 638
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param Zval $pData
     * @throws \Exception
     */
    public static function zend_hash_update_ptr(HashTable $ht, ZendString $key, Zval $pData): void {
        if ($ht || $key || $pData) {
            throw new \Exception('Pointers not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 624
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param int $len
     * @param Zval $pData
     * @throws \Exception
     */
    public static function zend_hash_str_update_ptr(HashTable $ht, ZendString $key, int $len, Zval $pData): void {
        if ($ht || $key || $len || $pData) {
            throw new \Exception('Pointers not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 658
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param Zval $pData
     * @param int $size
     * @throws \Exception
     */
    public static function zend_hash_add_mem(HashTable $ht, ZendString $key, Zval $pData, int $size): void {
        if ($ht || $key || $pData || $size) {
            throw new \Exception('Add with allocation not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 671
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param Zval $pData
     * @param int $size
     * @throws \Exception
     */
    public static function zend_hash_add_new_mem(HashTable $ht, ZendString $key, Zval $pData, int $size): void {
        if ($ht || $key || $pData || $size) {
            throw new \Exception('Add with allocation not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 684
     *
     * @param HashTable $ht
     * @param string $str
     * @param int $len
     * @param Zval $pData
     * @param int $size
     * @throws \Exception
     */
    public static function zend_hash_str_add_mem(HashTable $ht, string $str, int $len, Zval $pData, int $size): void {
        if ($ht || $str || $len || $pData || $size) {
            throw new \Exception('Add with allocation not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 697
     *
     * @param HashTable $ht
     * @param string $str
     * @param int $len
     * @param Zval $pData
     * @param int $size
     * @throws \Exception
     */
    public static function zend_hash_str_add_new_mem(HashTable $ht, string $str, int $len, Zval $pData,
        int $size): void {
        if ($ht || $str || $len || $pData || $size) {
            throw new \Exception('Add with allocation not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 710
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param Zval $pData
     * @param int $size
     * @throws \Exception
     */
    public static function zend_hash_update_mem(HashTable $ht, ZendString $key, Zval $pData, int $size): void {
        if ($ht || $key || $pData || $size) {
            throw new \Exception('Update with allocation not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 719
     *
     * @param HashTable $ht
     * @param string $str
     * @param int $len
     * @param Zval $pData
     * @param int $size
     * @throws \Exception
     */
    public static function zend_hash_str_update_mem(HashTable $ht, string $str, int $len, Zval $pData,
        int $size): void {
        if ($ht || $str || $len || $pData || $size) {
            throw new \Exception('Update with allocation not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 728
     *
     * @param HashTable $ht
     * @param int $h
     * @param Zval $pData
     * @throws \Exception
     */
    public static function zend_hash_index_add_ptr(HashTable $ht, int $h, Zval $pData): void {
        if ($ht || $h || $pData) {
            throw new \Exception('Pointers not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 737
     *
     * @param HashTable $ht
     * @param int $h
     * @param Zval $pData
     * @throws \Exception
     */
    public static function zend_hash_index_add_new_ptr(HashTable $ht, int $h, Zval $pData): void {
        if ($ht || $h || $pData) {
            throw new \Exception('Pointers not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 746
     *
     * @param HashTable $ht
     * @param int $h
     * @param Zval $pData
     * @throws \Exception
     */
    public static function zend_hash_index_update_ptr(HashTable $ht, int $h, Zval $pData): void {
        if ($ht || $h || $pData) {
            throw new \Exception('Pointers not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 756
     *
     * @param HashTable $ht
     * @param int $h
     * @param Zval $pData
     * @param int $size
     * @throws \Exception
     */
    public static function zend_hash_index_add_mem(HashTable $ht, int $h, Zval $pData, int $size): void {
        if ($ht || $h || $pData || $size) {
            throw new \Exception('Pointers not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 769
     *
     * @param HashTable $ht
     * @param Zval $pData
     * @throws \Exception
     */
    public static function zend_hash_next_index_insert_ptr(HashTable $ht, Zval $pData): void {
        if ($ht || $pData) {
            throw new \Exception('Pointers not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 783
     *
     * @param HashTable $ht
     * @param int $h
     * @param Zval $pData
     * @param int $size
     * @throws \Exception
     */
    public static function zend_hash_index_update_mem(HashTable $ht, int $h, Zval $pData, int $size): void {
        if ($ht || $h || $pData || $size) {
            throw new \Exception('Pointers not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 792
     *
     * @param HashTable $ht
     * @param Zval $pData
     * @param int $size
     * @throws \Exception
     */
    public static function zend_hash_next_index_insert_mem(HashTable $ht, Zval $pData, int $size): void {
        if ($ht || $pData || $size) {
            throw new \Exception('Pointers not supported');
        }
    }

    /**
     * Zend/zend_hash.h line 1091
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param Zval $zv
     * @param int $interned
     * @return Zval
     * @throws \Exception
     */
    public static function _zend_hash_append_ex(HashTable $ht, ZendString $key, Zval $zv, int $interned): Zval {
        // Build a new bucket in the next free slot
        $idx = $ht->validateBucketSlot($ht->nNumUsed++);
        $nIndex = null;
        $ht->arData[$idx] = new Bucket($idx);
        /** @var Bucket $p */
        $p = $ht->arData[$idx];

        // Copy the zval into the bucket
        Zval::COPY_VALUE($p->val, $zv);

        if (!$interned && ZendString::ZSTR_IS_INTERNED($key)) {
            // Compute the array key's hash value for later lookup
            $ht->HASH_FLAG_STATIC_KEYS = 0;
            ZendString::zend_string_hash_val($key);
        }

        // Copy the array key and its hash value into the bucket
        $p->key = $key;
        $p->h = ZendString::ZSTR_H($key);

        // Compute the hash slot and grab its value
        $nIndex = $ht->validateHashSlot($p->h | $ht->nTableMask);
        $hashSlotValue = $ht->arData[$nIndex];

        // To insert the new item at the begin of the collision chain, point the
        // hash slot to the new item, and point the new item's "next" value to
        // whatever the hash slot had been pointing to (possibly nothing).
        $ht->arData[$nIndex] = $idx;
        $p->val->u2_next = $hashSlotValue;

        // Increment the total number of bucket slots in use (including holes)
        $ht->nNumOfElements++;

        // Return the new copy of the zval from the bucket
        return $p->val;
    }

    /**
     * Zend/zend_hash.h line 1112
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param Zval $zv
     * @return Zval
     * @throws \Exception
     */
    public static function _zend_hash_append(HashTable $ht, ZendString $key, Zval $zv): Zval {
        return HashUpdate::_zend_hash_append_ex($ht, $key, $zv, 0);
    }

    /**
     * Zend/zend_hash.h line 1117
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param int $ptr
     * @param int $interned
     * @return Zval
     * @throws \Exception
     */
    public static function _zend_hash_append_ptr_ex(HashTable $ht, ZendString $key, int $ptr, int $interned): Zval {
        if ($ht || $key || $ptr || $interned) {
            throw new \Exception('Pointers not supported');
        }
        return new Zval();
    }

    /**
     * Zend/zend_hash.h line 1138
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param int $ptr
     * @return Zval
     * @throws \Exception
     */
    public static function _zend_hash_append_ptr(HashTable $ht, ZendString $key, int $ptr): Zval {
        return HashUpdate::_zend_hash_append_ptr_ex($ht, $key, $ptr, 0);
    }

    /**
     * Zend/zend_hash.h line 1143
     *
     * @param HashTable $ht
     * @param ZendString $key
     * @param Zval $ptr
     * @throws \Exception
     */
    public static function _zend_hash_append_ind(HashTable $ht, ZendString $key, Zval $ptr): void {
        if ($ht || $key || $ptr) {
            throw new \Exception('Indirects not supported');
        }
    }
}
