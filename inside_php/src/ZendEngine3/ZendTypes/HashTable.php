<?php

namespace App\ZendEngine3\ZendTypes;

use App\ZendEngine3\Hash\HashResize;
use function array_key_exists;

/**
 * Class HashTable
 *
 * @package App\ZendEngine3\ZendTypes
 *
 * Zend/zend_types.h line 235, 260
 *
 * HashTable Data Layout
 * =====================
 *
 *                 +=============================+
 *                 | HT_HASH(ht, ht->nTableMask) |
 *                 | ...                         |
 *                 | HT_HASH(ht, -1)             |
 *                 +-----------------------------+
 * ht->arData ---> | Bucket[0]                   |
 *                 | ...                         |
 *                 | Bucket[ht->nTableSize-1]    |
 *                 +=============================+
 *
 * This means that $ht->arData[] numeric array keys run from
 * nTableMask (a negative number) up to -1,
 * then 0 (the first bucket pointer),
 * up to (nTableSize-1).
 */
class HashTable extends ZendArray {
    /* Zend/zend_hash.h line 26 */
    public CONST HASH_KEY_IS_STRING = 1;
    public CONST HASH_KEY_IS_LONG = 2;
    public CONST HASH_KEY_NON_EXISTENT = 3;

    public $HASH_UPDATE = 0;
    public $HASH_ADD = 0;
    public $HASH_UPDATE_INDIRECT = 0;
    public $HASH_ADD_NEW = 0;
    public $HASH_ADD_NEXT = 0;

    public $HASH_FLAG_CONSISTENCY = 0;
    public $HASH_FLAG_PACKED = 0;
    public $HASH_FLAG_UNINITIALIZED = 1;
    public $HASH_FLAG_STATIC_KEYS = 0; /* long and interned strings */
    public $HASH_FLAG_HAS_EMPTY_IND = 0;
    public $HASH_FLAG_ALLOW_COW_VIOLATION = 0;

    public $IS_ARRAY_PERSISTENT = 0;
    public $GC_TYPE_INFO = 0;
    public $GC_PERSISTENT = 0;
    public $GC_COLLECTABLE = 0;

    /**
     * @param int $slot
     * @return int
     * @throws \Exception
     */
    public function validateBucketSlot(int $slot): int {
        if (($slot >= 0) && array_key_exists($slot, $this->arData)) {
            return $slot;
        }
        throw new \Exception("Invalid bucket slot $slot");
    }
    /**
     * @param int $slot
     * @return int
     * @throws \Exception
     */
    public function validateHashSlot(int $slot): int {
        if (($slot < 0) && array_key_exists($slot, $this->arData)) {
            return $slot;
        }
            throw new \Exception("Invalid hash slot $slot");
    }

    /**
     * Zend/zend_hash.h line 45
     *
     * @param HashTable $ht
     * @return bool
     */
    public static function HT_IS_PACKED(HashTable $ht): bool {
        return (bool)$ht->HASH_FLAG_PACKED;
    }

    /**
     * Zend/zend_hash.h line 48
     *
     * @param HashTable $ht
     * @return bool
     */
    public static function HT_IS_WITHOUT_HOLES(HashTable $ht): bool {
        return ($ht->nNumUsed === $ht->nNumOfElements);
    }

    /**
     * Zend/zend_hash.h line 51
     *
     * @param HashTable $ht
     * @return bool
     */
    public static function HT_HAS_STATIC_KEYS_ONLY(HashTable $ht): bool {
        return (bool)($ht->HASH_FLAG_PACKED | $ht->HASH_FLAG_STATIC_KEYS);
    }

    /**
     * Zend/zend_hash.h line 55
     *
     * @param HashTable $ht
     */
    public static function HT_ALLOW_COW_VIOLATION(HashTable $ht): void {
        $ht->HASH_FLAG_ALLOW_COW_VIOLATION = 1;
    }

    /**
     * Zend/zend_hash.h line 60
     *
     * @param HashTable $ht
     * @return int
     */
    public static function HT_ITERATORS_COUNT(HashTable $ht): int {
        return $ht->u_v_nIteratorsCount;
    }

    /**
     * Zend/zend_hash.h line 61
     *
     * @param HashTable $ht
     * @return bool
     */
    public static function HT_ITERATORS_OVERFLOW(HashTable $ht): bool {
        return (HashTable::HT_ITERATORS_COUNT($ht) === 0xff);
    }

    /**
     * Zend/zend_hash.h line 62
     *
     * @param HashTable $ht
     * @return bool
     */
    public static function HT_HAS_ITERATORS(HashTable $ht): bool {
        return (HashTable::HT_ITERATORS_COUNT($ht) !== 0);
    }

    /**
     * Zend/zend_hash.h line 64
     *
     * @param HashTable $ht
     * @param int $iters
     */
    public static function HT_SET_ITERATORS_COUNT(HashTable $ht, int $iters): void {
        $ht->u_v_nIteratorsCount = $iters;
    }

    /**
     * Zend/zend_hash.h line 66
     *
     * @param HashTable $ht
     */
    public static function HT_INC_ITERATORS_COUNT(HashTable $ht): void {
        HashTable::HT_SET_ITERATORS_COUNT($ht, HashTable::HT_ITERATORS_COUNT($ht) + 1);
    }

    /**
     * Zend/zend_hash.h line 68
     *
     * @param HashTable $ht
     */
    public static function HT_DEC_ITERATORS_COUNT(HashTable $ht): void {
        HashTable::HT_SET_ITERATORS_COUNT($ht, HashTable::HT_ITERATORS_COUNT($ht) - 1);
    }

    /**
     * Zend/zend_hash.h line 94
     *
     * @param HashTable $ht
     * @param int $nSize
     * @param callable $pHashFunction
     * @param callable $pDestructor
     * @param bool $persistent
     * @throws \Exception
     */
    public static function zend_hash_init(HashTable $ht, int $nSize, callable $pHashFunction, callable $pDestructor,
        bool $persistent): void {
        HashResize::_zend_hash_init($ht, $nSize, $pDestructor, $persistent);
        if ($pHashFunction) {
            return; // dummy
        }
    }

    /**
     * Zend/zend_hash.h line 96
     *
     * @param HashTable $ht
     * @param int $nSize
     * @param callable $pHashFunction
     * @param callable $pDestructor
     * @param bool $persistent
     * @param bool $bApplyProtection
     * @throws \Exception
     */
    public static function zend_hash_init_ex(HashTable $ht, int $nSize, callable $pHashFunction, callable $pDestructor,
        bool $persistent, bool $bApplyProtection): void {
        HashResize::_zend_hash_init($ht, $nSize, $pDestructor, $persistent);
        if ($pHashFunction || $bApplyProtection) {
            return; // dummy
        }
    }

    /**
     * Zend/zend_hash.h line 324
     *
     * @param HashTable $ht
     * @throws \Exception
     */
    public static function ZEND_INIT_SYMTABLE(HashTable $ht): void {
        HashTable::ZEND_INIT_SYMTABLE_EX($ht, 8, 0);
    }

    /**
     * Zend/zend_hash.h line 327
     *
     * @param HashTable $ht
     * @param int $n
     * @param bool $persistent
     * @throws \Exception
     */
    public static function ZEND_INIT_SYMTABLE_EX(HashTable $ht, int $n, bool $persistent): void {
        $dtor = function () {
        };
        HashTable::zend_hash_init($ht, $n, null, $dtor, $persistent);
    }

    /**
     * Zend/zend_types.h line 289 for 64-bit
     *
     * @param HashTable $ht
     * @param int $idx
     * @return Bucket|null
     */
    public static function HT_HASH_TO_BUCKET_EX(HashTable $ht, int $idx): ?Bucket {
        return $ht->arData[$idx];
    }

    /**
     * Zend/zend_types.h line 291 for 64-bit
     *
     * @param int $idx
     * @return int
     */
    public static function HT_IDX_TO_HASH(int $idx): int {
        return $idx;
    }

    /**
     * Zend/zend_types.h line 293 for 64-bit
     *
     * @param int $idx
     * @return int
     */
    public static function HT_HASH_TO_IDX(int $idx): int {
        return $idx;
    }

    /**
     * Zend/zend_types.h line 299
     *
     * @param HashTable $ht
     * @param int $idx
     * @return Bucket|null
     */
    public static function HT_HASH_EX(HashTable $ht, int $idx): ?Bucket {
        return HashTable::HT_HASH_TO_BUCKET_EX($ht, $idx);
    }

    /**
     * Zend/zend_types.h line 301
     *
     * @param HashTable $ht
     * @param int $idx
     * @return Bucket|null
     */
    public static function HT_HASH(HashTable $ht, int $idx): ?Bucket {
        return HashTable::HT_HASH_EX($ht, $idx);
    }

    /**
     * Zend/zend_types.h line 304
     *
     * @param int $nTableSize
     * @return int
     */
    public static function HT_SIZE_TO_MASK(int $nTableSize): int {
        return (-($nTableSize + $nTableSize));
    }

    /**
     * Zend/zend_types.h line 306
     *
     * @param int $nTableMask
     * @return int
     */
    public static function HT_HASH_SIZE(int $nTableMask): int {
//        (((size_t)(uint32_t) - (int32_t)(nTableMask)) * sizeof(uint32_t))
        return $nTableMask * -4;
    }

    /**
     * Zend/zend_types.h line 308
     *
     * @param int $nTableSize
     * @return int
     */
    public static function HT_DATA_SIZE(int $nTableSize): int {
        return $nTableSize;
    }

    /**
     * Zend/zend_types.h line 310
     *
     * @param int $nTableSize
     * @param int $nTableMask
     * @return int
     */
    public static function HT_SIZE_EX(int $nTableSize, int $nTableMask): int {
        return (HashTable::HT_DATA_SIZE($nTableSize) + HashTable::HT_HASH_SIZE($nTableMask));
    }

    /**
     * Zend/zend_types.h line 312
     *
     * @param HashTable $ht
     * @return int
     */
    public static function HT_SIZE(HashTable $ht): int {
        return HashTable::HT_SIZE_EX($ht->nNTableSize, $ht->nTableMask);
    }

    /**
     * Zend/zend_types.h line 314
     *
     * @param HashTable $ht
     * @return int
     */
    public static function HT_USED_SIZE(HashTable $ht): int {
        return (HashTable::HT_HASH_SIZE($ht->nTableMask) + $ht->nNumUsed);
    }

    /**
     * Zend/zend_types.h line 333
     * Set all hash pointers to be invalid
     *
     * @param HashTable $ht
     */
    public static function HT_HASH_RESET(HashTable $ht): void {
        $slot = $ht->nTableMask;
        while ($slot < 0) {
            $ht->arData[$slot++] = ZendTypes::HT_INVALID_IDX;
        }
    }

    /**
     * Zend/zend_types.h line 336
     *
     * @param HashTable $ht
     */
    public static function HT_HASH_RESET_PACKED(HashTable $ht): void {
        $ht->arData[-2] = ZendTypes::HT_INVALID_IDX;
        $ht->arData[-1] = ZendTypes::HT_INVALID_IDX;
    }

    /**
     * Zend/zend_types.h line 340
     *
     * @param HashTable $ht
     * @param int $idx
     * @return Bucket|null
     */
    public static function HT_HASH_TO_BUCKET(HashTable $ht, int $idx): ?Bucket {
        return HashTable::HT_HASH_TO_BUCKET_EX($ht, $idx);
    }

    /**
     * Zend/zend_types.h line 343
     *
     * @param HashTable $ht
     * @param $ptr
     */
    public static function HT_SET_DATA_ADDR(HashTable $ht, $ptr): void {
        // Not applicable
    }

    /**
     * Zend/zend_types.h line 346
     *
     * @param HashTable $ht
     */
    public static function HT_GET_DATA_ADDR(HashTable $ht): void {
        // Not applicable
    }

    /**
     * Based on Zend/zend_hash.c line 196
     *
     * The uninitialized bucket is compiled in for efficiency's sake.
     * All uninitialized hash tables point to this same bucket. We can't simulate that, so
     * just set the hash and bucket slots to something simulating the outcome.
     *
     * @param HashTable $ht
     */
    /*    public static function setUninitializedBucket(HashTable $ht): void {
			$ht->arHash = [HashTable::HT_INVALID_IDX, HashTable::HT_INVALID_IDX];
			$ht->arData = [null, null];
		}*/

}
