<?php

namespace App\ZendEngine3\ZendTypes;

/**
 * Class ZendString
 *
 * @package App\ZendEngine3\ZendTypes
 *
 * Zend/zend_types.h line 222
 */
class ZendString {
    /** @var ZendRefcountedH Reference count */
    public $gc;

    /** @var int hash value */
    public $h;

    /** @var int String length */
    public $len;

    /** @var string String value */
    public $val;

    public static function ZSTR_IS_INTERNED(ZendString $key): int {
        return $key->gc->IS_INTERNED;
    }

    /**
     * Zend/zend_string.h line 52
     *
     * @param ZendString $zstr
     * @return string
     */
    public static function ZSTR_VAL(ZendString $zstr): string {
        return $zstr->val;
    }

    /**
     * Zend/zend_string.h line 53
     *
     * @param ZendString $zstr
     * @return int
     */
    public static function ZSTR_LEN(ZendString $zstr): int {
        return $zstr->len;
    }

    /**
     * Zend/zend_string.h line 54
     *
     * @param ZendString $zstr
     * @return int
     */
    public static function ZSTR_H(ZendString $zstr): int {
        return $zstr->h;
    }

    /**
     * Zend/zend_string.h line 55
     *
     * @param ZendString $zstr
     * @return int
     */
    public function ZSTR_HASH(ZendString $zstr): int {
        return ZendString::zend_string_hash_val($zstr);
    }

    /**
     * Replaces hash function at Zend/zend_string.h line 359
     * zend_inline_hash_func
     *
     * Zend/zend_hash.h line 1101 (_zend_hash_append_ex) implies that this function
     * sets the hash inside the incoming zend_string.
     *
     * @param ZendString $zstr
     * @return int
     */
    public static function zend_string_hash_val(ZendString $zstr): int {
        /* Hash value can't be zero, so we always set the high bit */
        $zstr->h = ZendString::fakeHash($zstr->val);
        return $zstr->h;
    }

    public static function fakeHash(string $key): int {
        /* Hash value can't be zero, so we always set the high bit */
        $hash = \crc32($key);
        return ($hash < 0) ? $hash : -$hash;
    }

    public static function fakeIntHash(int $key): int {
        return -abs($key);
    }
}
