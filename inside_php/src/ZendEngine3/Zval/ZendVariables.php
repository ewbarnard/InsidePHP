<?php
/**
 * Created by PhpStorm.
 * User: ewb
 * Date: 2018-12-27
 * Time: 13:30
 */

namespace App\ZendEngine3\Zval;

/**
 * Class ZendVariables
 *
 * @package App\ZendEngine3\Zval
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
