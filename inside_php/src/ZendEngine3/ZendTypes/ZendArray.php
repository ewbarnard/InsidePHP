<?php

namespace App\ZendEngine3\ZendTypes;

use App\ZendEngine3\Hash\Bucket;

/**
 * Class ZendArray
 *
 * @package App\ZendEngine3\ZendTypes
 *
 * Zend/zend_types.h line 237
 */
class ZendArray {
    /** @var ZendRefcountedH */
    public $gc;
    /** @var int */
    public $u_v_flags;
    /** @var int */
    public $u_v_nIteratorsCount;
    /** @var int */
    public $u_flags;
    /** @var int */
    public $nTableMask;
    /** @var Bucket */
    public $arData;
    /** @var int */
    public $nNumUsed;
    /** @var int */
    public $nNumOfElements;
    /** @var int */
    public $nNTableSize;
    /** @var int */
    public $nInternalPointer;
    /** @var int */
    public $nNextFreeElement;
    /** @var callable */
    public $pDestructor;
}
