<?php

namespace App\ZendEngine3\ZendTypes;
/**
 * Class ZendTypes
 *
 * @package App\ZendEngine3\ZendTypes
 *
 * Zend/zend_types.h
 */
class ZendTypes {
    /* Zend/zend_types.h line 52 */
    public CONST SUCCESS = 0;
    public CONST FAILURE = -1;

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

    /* Zend/zend_types.h line 274 */
    public CONST HT_INVALID_IDX = -1;
    public CONST HT_MIN_MASK = -2;
    public CONST HT_MIN_SIZE = 8;

    /* For 64-bit words - Zend/zend_types.h line 288 */
    public CONST HT_MAX_SIZE = 0x80000000;

    private function __construct() { // Constants only
    }
}
