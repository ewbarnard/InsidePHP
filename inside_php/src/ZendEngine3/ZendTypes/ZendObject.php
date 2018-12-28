<?php

namespace App\ZendEngine3\ZendTypes;

use App\ZendEngine3\Hash\HashTable;

/**
 * Class ZendObject
 *
 * @package App\ZendEngine3\ZendTypes
 *
 * Zend/zend_types.h line 356
 */
class ZendObject {
    /** @var ZendRefcountedH */
    public $gc;
    /** @var ZendClassEntry */
    public $ce;
    /** @var ZendObjectHandlers */
    public $handlers;
    /** @var HashTable */
    public $properties;
    /** @var Zval[] */
    public $properties_table = [];
}
