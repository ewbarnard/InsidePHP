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
}
