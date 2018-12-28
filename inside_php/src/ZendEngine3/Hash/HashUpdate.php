<?php

namespace App\ZendEngine3\Hash;

use App\ZendEngine3\ZendTypes\Bucket;
use App\ZendEngine3\ZendTypes\HashTable;
use App\ZendEngine3\ZendTypes\ZendString;
use App\ZendEngine3\ZendTypes\Zval;

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
}
