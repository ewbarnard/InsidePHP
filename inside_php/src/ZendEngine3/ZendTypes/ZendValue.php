<?php

namespace App\ZendEngine3\ZendTypes;

/**
 * Class ZendValue
 *
 * @package App\ZendEngine3\ZendTypes
 *
 * Zend/zend_types.h line 162
 * We can't do a C-style union; show as separate fields
 */
class ZendValue {
    /** @var int long (integer) value */
    public $lval;
    /** @var float double (float) value */
    public $dval;
    /** @var ZendRefcounted */
    public $counted;
    /** @var ZendString */
    public $str;
    /** @var ZendArray */
    public $arr;
    /** @var ZendObject */
    public $obj;
    /** @var ZendResource */
    public $res;
    /** @var ZendReference */
    public $ref;
    /** @var ZendAstRef */
    public $ast;
    /** @var Zval */
    public $zv;
    /** @var void */
    public $ptr;
    /** @var ZendClassEntry */
    public $ce;
    /** @var ZendFunction */
    public $func;
    /** @var int */
    public $ww_w1;
    /** @var int */
    public $ww_w2;

    public function __construct() {
        $this->str = new ZendString();
    }
}
