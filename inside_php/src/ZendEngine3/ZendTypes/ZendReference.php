<?php

namespace App\ZendEngine3\ZendTypes;

/**
 * Class ZendReference
 *
 * @package App\ZendEngine3\ZendTypes
 *
 * Zend/zend_types.h line 372
 */
class ZendReference {
    /** @var ZendRefcountedH */
    public $gc;
    /** @var Zval */
    public $val;
}
