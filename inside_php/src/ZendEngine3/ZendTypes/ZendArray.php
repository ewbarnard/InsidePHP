<?php

namespace App\ZendEngine3\ZendTypes;

/**
 * Class ZendArray
 *
 * @package App\ZendEngine3\ZendTypes
 *
 * Zend/zend_types.h line 237
 */
class ZendArray {
    public $trace = PHP_EOL;
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
    /** @var Bucket[]|mixed[] */
    public $arData;
    /** @var int Number of next available slot */
    public $nNumUsed;
    /** @var int Number of valid elements */
    public $nNumOfElements;
    /** @var int */
    public $nTableSize;
    /** @var int */
    public $nInternalPointer;
    /** @var int */
    public $nNextFreeElement;
    /** @var callable */
    public $pDestructor;

    public function __construct() {
        $this->gc = new ZendRefcountedH();
        $this->arData = [];
    }

    public function trace(string $message): void {
        $this->trace .= $message . PHP_EOL;
    }

    public function begin(string $message): void {
        $this->trace('Begin ' . $message);
    }

    public function progress(string $message): void {
        $this->trace(' - ' . $message);
    }
}
