<?php

namespace App\ZendEngine3\Hash;


class HashTable extends Injectable
{
    /* Zend/zend_types.h line 274 */
    public CONST HT_INVALID_IDX = -1;
    public CONST HT_MIN_SIZE = 8;

    /* For 32-bit words; set small enough to avoid overflow checks */
    public CONST HT_MAX_SIZE = 0x04000000;

    /** @var int[] Masked hash is slot, slot content is bucket-slot */
    public $arHash = [];
    /** @var Bucket[] or null */
    public $arData = [];

    /** @var int Offset of next free Bucket slot */
    public $nNumUsed;

    /** @var int arData size (number of bucket slots), generally a power of two */
    public $nTableSize;

    /** @var int Actual number of (valid) stored elements in bucket slots */
    public $nNumOfElements;

    /** @var int */
    public $nTableMask;

    public $nIteratorsCount = 0;
    /** @var int */
    public $nInternalPointer;

    public $HASH_FLAG_INITIALIZED = 0;
    public $HASH_FLAG_PACKED = 0;
    public $IS_ARRAY_PERSISTENT = 0;

//    /** @var int */
//    public $nTableMask;
//    /** @var int */
//    public $nNextFreeElement;
//    /** @var Bucket[] Array elements, allocated in powers of two */
//    public $arData = [];
//    /** @var int[] */
//    public $arHash = [];
//    /** @var callable */
//    public $pDestructor;
//    /** @var int */
//    public $nInternalPointer;
//    /** @var int */
//    public $flags;
//    /** @var int */
//    public $nApplyCount;
//    /** @var int */
//    public $reserve;
//    /** @var int */
//    public $allFlags;

}
