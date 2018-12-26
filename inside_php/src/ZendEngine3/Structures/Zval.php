<?php

namespace App\ZendEngine3\Structures;
/**
 * Class Zval
 *
 * Reference: Zend/zend_types.h
 * https://github.com/php/php-src/blob/master/Zend/zend_types.h
 *
 *  - zend_value is line 162
 *  - zval is line 182
 *  - zend_string is line 222
 *  - Bucket is line 229
 *  - HashTable is lines 235-380
 *  - zend_array is line 237
 */
class Zval {
    /* Regular data types, Zend/zend_types.h line 382 */
    public CONST IS_UNDEF = 0;
    public CONST IS_NULL = 1;
    public CONST IS_FALSE = 2;
    public CONST IS_TRUE = 3;
    public CONST IS_LONG = 4;
    public CONST IS_DOUBLE = 5;
    public CONST IS_STRING = 6;
    public CONST IS_ARRAY = 7;
    public CONST IS_OBJECT = 8;
    public CONST IS_RESOURCE = 9;
    public CONST IS_REFERENCE = 10;

    /* Constant expressions, Zend/zend_types.h line 396 */
    public CONST IS_CONSTANT_AST = 11;

    /* Internal types, Zend/zend_types.h line 398 */
    public CONST IS_INDIRECT = 13;
    public CONST IS_PTR = 14;
    public CONST _IS_ERROR = 15;

    /* Fake types used only for type hinting, Zend/zend_types.h line 403 */
    public CONST _IS_BOOL = 16;
    public CONST IS_CALLABLE = 17;
    public CONST IS_ITERABLE = 18;
    public CONST IS_VOID = 19;
    public CONST _IS_NUMBER = 20;

    public $value; // zend_value (mixed, 8 bytes)
    public $type; // zend_uchar (unsigned 8-bit integer)
    public $type_flags; // zend_uchar
    public $const_flags; // zend_uchar
    public $reserved; // zend_uchar
    public $type_info; // uint32_t (unsigned 32-bit integer)
    public $var_flags; // uint32_t
    public $next; // uint32_t - hash collision chain
    public $cache_slot; // uint32_t - literal cache slot
    public $lineno; // uint32_t - line number for AST (Abstract Syntax Tree) nodes

    public function unlink(): void {
        $this->type = static::IS_UNDEF;
        $this->next = null;
    }

    /**
     * @param int|null $value
     */
    public function setNext($value): void {
        $this->next = $value;
    }
}
