<?php

namespace App\ZendEngine3\Zval;

/**
 * Class Zval
 *
 * @package App\ZendEngine3\Zval
 *
 * Reference: Zend/zend_types.h
 * https://github.com/php/php-src/blob/master/Zend/zend_types.h
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

    public $value; // zend_value (mixed, 8 bytes)
    public $type = self::IS_UNDEF; // zend_uchar (unsigned 8-bit integer)
    public $next; // uint32_t - hash collision chain

    public static function COPY_VALUE(Zval $destination, Zval $source): void {
        $destination->value = $source->value;
        $destination->type = $source->type;
        $destination->next = $source->next;
    }

    public function invalidate(): void {
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
