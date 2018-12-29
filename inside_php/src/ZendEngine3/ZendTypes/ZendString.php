<?php

namespace App\ZendEngine3\ZendTypes;

use function crc32;

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
        return static::zend_string_hash_val($zstr);
    }

    /**
     * Replaces hash function at Zend/zend_string.h line 359
     * zend_inline_hash_func
     *
     * @param ZendString $zstr
     * @return int
     */
    public static function zend_string_hash_val(ZendString $zstr):int {
        /* Hash value can't be zero, so we always set the high bit */
        return (crc32($zstr->val) | 0x80000000);
    }
}
