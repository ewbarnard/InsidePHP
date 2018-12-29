<?php

namespace App\ZendEngine3\Hash;


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
            return static::_zend_hash_find_known_hash($ht, $key);
        } else {
            return static::zend_hash_find($ht, $key);
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
        return (static::zend_hash_find($ht, $key) !== null);
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
        return (static::zend_hash_str_find($ht, $str, $len) !== null);
    }

    /**
     * Zend/zend_hash.h line 219
     *
     * @param HashTable $ht
     * @param int $h
     * @return bool
     */
    public static function zend_hash_index_exists(HashTable $ht, int $h): bool {
        return (static::zend_hash_index_find($ht, $h) !== null);
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
}
