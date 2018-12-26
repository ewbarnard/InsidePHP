<?php

namespace App\ZendEngine3\Hashtable;

use App\ZendEngine3\Structures\Zval;

class HashTable extends Injectable {
    /* Zend/zend_types.h line 274 */
    public CONST HT_INVALID_IDX = -1;
    public CONST HT_MIN_MASK = -2;
    public CONST HT_MIN_SIZE = 8;

    /** @var int Allocated arData size, always a power of two */
    public $nTableSize;
    /** @var int */
    public $nTableMask;
    /** @var int Offset of next free Bucket slot */
    public $nNumUsed;
    /** @var int Actual number of (valid) stored elements */
    public $nNumOfElements;
    /** @var int */
    public $nNextFreeElement;
    /** @var Bucket[] Array elements, allocated in powers of two */
    public $arData = [];
    /** @var int[] */
    public $arHash = [];
    /** @var callable */
    public $pDestructor;
    /** @var int */
    public $nInternalPointer;
    /** @var int */
    public $flags;
    /** @var int */
    public $nApplyCount;
    /** @var int */
    public $reserve;
    /** @var int */
    public $allFlags;

    /** @var Key */
    protected $key;
    /** @var HashTableWalker */
    protected $walker;
    private $nextBucketSlot = 0;
    /** @var int */
    private $fullHash;
    /** @var int */
    private $maskedHash;
    /** @var Bucket */
    private $bucket;
    /** @var Zval */
    private $zval;

    /**
     * HashTable constructor: Set up an empty array
     *
     * @param array|null $dependencies
     */
    public function __construct(array $dependencies = null) {
        parent::__construct($dependencies);
        $this->initializeProperties();
    }

    private function initializeProperties(): void {
        $this->trace('');
        if (!$this->key) {
            $this->key = new Key();
        }
        if (!$this->walker) {
            $this->walker = new HashTableWalker([
                'hashtable' => $this,
                'key' => $this->key,
            ]);
        }
        if ($this->nTableSize === null) {
            $this->initEmptyArray();
        }
    }

    private function initEmptyArray(): void {
        $this->nTableSize = static::HT_MIN_SIZE;
        $this->arData = \array_fill(0, $this->nTableSize, null);
        $this->arHash = \array_fill(0, $this->nTableSize, static::HT_INVALID_IDX);
        $this->nTableMask = $this->nTableSize - 1;
        $this->nNumOfElements = 0;
        $this->nNumUsed = 0;
        $this->trace('Created empty array');
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @param int $type
     * @throws \Exception
     */
    public function insertElement($key, $value, int $type): void {
        $this->initZval($value, $type);
        $this->key->determineKey($key);
        $key = $this->key->currentKey();
        $this->determineHash();
        $this->initBucket();
        if ($this->unsetExistingKey()) {
            $this->trace("Unset existing $key");
        }
        $this->doInsertElement();

        $this->trace("Inserted $key");
    }

    /**
     * @param mixed $value
     * @param int $type
     */
    private function initZval($value, int $type): void {
        $this->zval = new Zval();
        $this->zval->value = $value;
        $this->zval->type = $type;
    }

    private function determineHash(): void {
        $this->fullHash = $this->key->fullHash();
        $this->nextBucketSlot = $this->nNumUsed++;
        $this->checkHashtableSize();
        $this->maskedHash = $this->fullHash & $this->nTableMask;
    }

    /**
     * When no more slots available, double hashtable size to
     * next power of two
     *
     * See Zend/zend_hash.c
     *  - zend_hash_do_resize() line 1112
     *  - zend_hash_rehash() line 1137
     *  - zend_hash_discard() line 346
     */
    private function checkHashtableSize(): void {
        if ($this->nNumUsed <= $this->nTableSize) {
            return;
        }
        $newTableSize = $this->nTableSize * 2;
        $delta = $newTableSize - $this->nTableSize;
        $this->arData += \array_fill($this->nTableSize, $delta, null);
        $this->arHash += \array_fill($this->nTableSize, $delta, static::HT_INVALID_IDX);
        $nBuckets = count($this->arData);
        $nHashMap = count($this->arHash);
        $this->nTableSize = $newTableSize;
        $this->nTableMask = $this->nTableSize - 1;
        $this->trace("Increased hash table by $delta to $newTableSize, $nBuckets buckets, $nHashMap hashes");
    }

    private function initBucket():void {
        $this->bucket = new Bucket();
        $this->bucket->h = $this->fullHash;
        $this->bucket->key = $this->key->stringKey();
        $this->bucket->val = $this->zval;
    }

    /**
     * @throws \Exception
     */
    private function unsetExistingKey() {
        $this->walker->unsetExistingKey($this->fullHash, $this->maskedHash);
    }

    private function doInsertElement(): void {
        $this->arData[$this->nextBucketSlot] = $this->bucket;
        ++$this->nNumOfElements;

        if ($this->haveNoCollision()) {
            $this->insertNoCollision();
        } else {
            $this->insertWithCollision();
        }
    }

    private function haveNoCollision(): bool {
        return $this->isInvalidSlot($this->findCollisionSlotHead());
    }

    private function isInvalidSlot(int $slot): bool {
        return ($slot === static::HT_INVALID_IDX);
    }

    private function findCollisionSlotHead(): int {
        return $this->arHash[$this->maskedHash];
    }

    private function insertNoCollision(): void {
        $this->arHash[$this->maskedHash] = $this->nextBucketSlot;
        $this->trace(__FUNCTION__.": hash {$this->maskedHash} placed new bucket at data slot {$this->nextBucketSlot}");
    }

    private function insertWithCollision(): void {
        $next = $this->findCollisionSlotHead();
        $bucket = $this->arData[$next];
        while ($next !== null) {
            $bucket = $this->arData[$next];
            $next = $bucket->next();
        }
        $bucket->setNext($this->nextBucketSlot);
        $this->trace(__FUNCTION__ .
            ": hash {$this->maskedHash} placed new bucket at data slot {$this->nextBucketSlot}");
    }

    /**
     * @param int $index
     * @return Bucket
     * @throws \Exception
     */
    private function getBucket(int $index): Bucket {
        $bucket = $this->arData[$index];
        if ($bucket === null) {
            throw new \Exception("Invalid bucket index $index");
        }
        return $bucket;
    }
}
