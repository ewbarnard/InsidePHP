<?php

namespace App\ZendEngine3\ZendTypes;

/**
 * Class ZendRefcountedH
 *
 * @package App\ZendEngine3\ZendTypes
 *
 * Zend/zend_types.h line 211
 */
class ZendRefcountedH {
    /** @var int */
    public $refcount;

    /** @var int */
    public $u_type_info;
    public $IS_INTERNED = 0;
    public $IS_ARRAY = 0;

    /* zend_types.h line 515 */
    public $GC_COLLECTABLE = 0;
    public $GC_PROTECTED = 0;
    public $GC_IMMUTABLE = 0;
    public $GC_PERSISTENT = 0;
    public $GC_PERSISTENT_LOCAL = 0;

}
