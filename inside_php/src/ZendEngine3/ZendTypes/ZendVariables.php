<?php

namespace App\ZendEngine3\ZendTypes;

/**
 * Class ZendVariables
 *
 * @package App\ZendEngine3\ZendTypes
 *
 * Based on Zend/zend_variables.c
 */
class ZendVariables {
    public CONST ZVAL_PTR_DTOR = self::class . '::zval_ptr_dtor';
    private function __construct() {

    }

    /**
     * Based on Zend/zend_variables.c line 75
     *
     * @param Zval $zvalPtr
     */
    public static function zval_ptr_dtor(Zval $zvalPtr):void {

    }
}
