<?php

namespace App\ZendEngine3\Hash;

use App\ZendEngine3\Zval\ZendTypes;
use App\ZendEngine3\Zval\Zval;

final class HashResize {
    private function __construct() { // Static only
    }

    /**
     * Zend/zend_hash.c line 78
     *
     * @param HashTable $ht
     * @throws \Exception
     */
    public static function ZEND_HASH_IF_FULL_DO_RESIZE(HashTable $ht): void {
        if ($ht->nNumUsed >= $ht->nTableSize) {
            static::zend_hash_do_resize($ht);
        }
    }

    /**
     * Zend/zend_hash.c line 85
     *
     * @param int $nSize
     * @return int
     * @throws \Exception
     */
    public static function zend_hash_check_size(int $nSize): int {
        /* Use big enough power of 2 */
        /* Size should be between HT_MIN_SIZE and HT_MAX_SIZE */
        if ($nSize <= HashTable::HT_MIN_SIZE) {
            return HashTable::HT_MIN_SIZE;
        } elseif ($nSize >= HashTable::HT_MAX_SIZE) {
            throw new \Exception('Possible integer overflow in memory allocation');
        }

        $nSize -= 1;
        $nSize |= ($nSize >> 1);
        $nSize |= ($nSize >> 2);
        $nSize |= ($nSize >> 4);
        $nSize |= ($nSize >> 8);
        $nSize |= ($nSize >> 16);

        return $nSize + 1;
    }

    /**
     * Zend/zend_hash.c line 120
     *
     * The "packed hashtable" is for continuous, integer-indexed arrays ("real" arrays).
     * The hash slots are NULL and lookups index directly into the bucket slots. If you
     * are looking for key 5 then it will be at bucket 5 or not exist at all. There is
     * no collision chain.
     *
     * @param HashTable $ht
     */
    public static function zend_hash_real_init_packed_ex(HashTable $ht): void {
        $ht->HASH_FLAG_INITIALIZED = 1;
        $ht->HASH_FLAG_PACKED = 1;
        static::HT_HASH_RESET_PACKED($ht);
    }

    /**
     * Zend/zend_hash.c line 136
     *
     * The real code allocates space for hash slots and bucket slots together:
     *  - If we are representing a persistent array, we use pemalloc() to allocate space
     *  - Otherwise we use the standard emalloc() to allocate space
     *
     * If we are initializing a standard (non-persistent) array that is the minimum size,
     * we initialize both the hash slots and bucket slots to -1 to represent the empty array
     *
     * If we are initializing a larger standard array, we call HT_HASH_RESET() to set all the
     * hash slots to -1. We leave the buckets uninitialized.
     *
     * @param HashTable $ht
     */
    public static function zend_hash_real_init_mixed_ex(HashTable $ht): void {
        $nSize = $ht->nTableSize;
        if ($nSize === HashTable::HT_MIN_SIZE) {
            $ht->nTableMask = static::HT_SIZE_TO_MASK(HashTable::HT_MIN_SIZE);
            $ht->HASH_FLAG_INITIALIZED = 1;
            $ht->arData = \array_fill(0, HashTable::HT_MIN_SIZE, null);
            $ht->arHash = \array_fill(0, HashTable::HT_MIN_SIZE, HashTable::HT_INVALID_IDX);
            return;
        }

        /* We can't simulate "persistent array" so treat it the same as a larger standard array */
        $ht->nTableMask = static::HT_SIZE_TO_MASK($nSize);
        $ht->HASH_FLAG_INITIALIZED = 1;
        static::HT_HASH_RESET($ht);
    }

    /**
     * Zend/zend_hash.c line 185
     *
     * @param HashTable $ht
     * @param int $packed
     * @throws \Exception
     */
    public static function zend_hash_real_init_ex(HashTable $ht, int $packed): void {
        if ($ht->HASH_FLAG_INITIALIZED) {
            throw new \Exception('HashTable already initialized');
        }
        if ($packed) {
            static::zend_hash_real_init_packed_ex($ht);
        } else {
            static::zend_hash_real_init_mixed_ex($ht);
        }
    }

    /**
     * Based on Zend/zend_hash.c line 196
     *
     * The uninitialized bucket is compiled in for efficiency's sake.
     * All uninitialized hash tables point to this same bucket.
     *
     * @param HashTable $ht
     */
    public static function setUnitializedBucket(HashTable $ht): void {
        $ht->arHash = [HashTable::HT_INVALID_IDX, HashTable::HT_INVALID_IDX];
        $ht->arData = [null, null];
    }

    /**
     * Zend/zend_hash.c line 213
     *
     * Ignoring persistent flag since we're not supporting ref counts or garbage collection
     *
     * @param HashTable $ht
     * @param int $nSize
     * @param callable $pDestructor
     * @throws \Exception
     */
    public static function _zend_hash_init_int(HashTable $ht, int $nSize, callable $pDestructor): void {
        $ht->HASH_FLAG_STATIC_KEYS = 1;
        $ht->nTableMask = HashTable::HT_MIN_MASK;
        static::setUnitializedBucket($ht);
        $ht->nNumUsed = 0;
        $ht->nNumOfElements = 0;
        $ht->nInternalPointer = 0;
        $ht->nNextFreeElement = 0;
        $ht->pDestructor = $pDestructor;
        $ht->nTableSize = static::zend_hash_check_size($nSize);
    }

    /**
     * Zend/zend_hash.c line 1112
     *
     * @param HashTable $ht
     * @throws \Exception
     */
    public static function zend_hash_do_resize(HashTable $ht): void {
        /* Additional term is there to amortize the cost of compaction */
        if ($ht->nNumUsed > $ht->nNumOfElements + ($ht->nNumOfElements >> 5)) {
            static::zend_hash_rehash($ht);
        } elseif ($ht->nTableSize < HashTable::HT_MAX_SIZE) {
            /* Let's double the table size */
            $nSize = $ht->nTableSize + $ht->nTableSize;
            $ht->arHash += \array_fill($ht->nTableSize, $ht->nTableSize, HashTable::HT_INVALID_IDX);
            $ht->arData += \array_fill($ht->nTableSize, $ht->nTableSize, null);
            $ht->nTableSize = $nSize;
            $ht->nTableMask = static::HT_SIZE_TO_MASK($ht->nTableSize);
        } else {
            throw new \Exception('Possible integer overflow in memory allocation');
        }
    }

    /**
     * Zend/zend_hash.c line 1137
     * Compress bucket slots to remove inactive buckets
     * "Next" pointers on collision chain always point to lower-numbered slots
     *
     * @param HashTable $ht
     * @return int
     * @throws \Exception
     */
    public static function zend_hash_rehash(HashTable $ht): int {
        if ($ht->nNumOfElements === 0) {
            /* requesting empty array */
            if ($ht->HASH_FLAG_INITIALIZED) {
                /* Only need to clear if initialized; uninitialized is already empty */
                $ht->nNumUsed = 0;
                static::HT_HASH_RESET($ht);
            }
            return ZendTypes::SUCCESS;
        }

        static::HT_HASH_RESET($ht);
        $i = 0;
        $bucketSlot = 0;
        /** @var Bucket $p */
        $p = $ht->arData[$bucketSlot];
        if (static::HT_IS_WITHOUT_HOLES($ht)) {
            do {
                $nIndex = $p->h | $ht->nTableMask;
                $p->val->next = $nIndex;
                $ht->arHash[$nIndex] = $i;
                $p = $ht->arData[++$bucketSlot];
            } while (++$i < $ht->nNumUsed);
        } else {
            do {
                if ($p->val->type === Zval::IS_UNDEF) {
                    $j = $i;
                    $q = $p;
                    $qBucketSlot = $bucketSlot;

                    if (!static::HT_HAS_ITERATORS($ht)) {
                        while (++$i < $ht->nNumUsed) {
                            ++$bucketSlot;
                            $p = $ht->arData[$bucketSlot];
                            if ($p->val->type !== Zval::IS_UNDEF) {
                                // Move Bucket down to fill in the hole
                                Zval::COPY_VALUE($q->val, $p->val);
                                $q->h = $p->h;
                                $nIndex = $q->h | $ht->nTableMask;
                                $q->key = $p->key;
                                $q->val->next = $nIndex;
                                $ht->arHash[$nIndex] = $j;
                                if ($ht->nInternalPointer === $i) {
                                    $ht->nInternalPointer = $j;
                                }
                                $q = $ht->arData[++$qBucketSlot];
                                $j++;
                            }
                        }
                    } else {
                        // Zend/zend_hash.c line 1186
                        throw new \Exception('Not supporting hashtable with iterators');
                    }
                    $ht->nNumUsed = $j;
                    break;
                }
                $nIndex = $p->h | $ht->nTableMask;
                $p->val->next = $nIndex;
                $ht->arHash[$nIndex] = $i;
                $p = $ht->arData[++$bucketSlot];
            } while (++$i < $ht->nNumUsed);
        }
        return ZendTypes::SUCCESS;
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
     * Zend/zend_types.h line 317
     *
     * @param HashTable $ht
     */
    public static function HT_HASH_RESET(HashTable $ht): void {
        $ht->arHash = \array_fill(0, $ht->nTableSize, HashTable::HT_INVALID_IDX);
        /* Simulate leaving the buckets uninitialized */
        $ht->arData = [];
    }

    /**
     * Zend/zend_types.h line 336
     *
     * @param HashTable $ht
     */
    public static function HT_HASH_RESET_PACKED(HashTable $ht): void {
        static::setUnitializedBucket($ht);
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
     * Zend/zend_hash.h line 60
     *
     * @param HashTable $ht
     * @return int
     */
    public static function HT_ITERATORS_COUNT(HashTable $ht): int {
        // Might not have this implementation correct, actual field buried in a union
        return $ht->nIteratorsCount;
    }

    /**
     * Zend/zend_hash.h line 62
     *
     * @param HashTable $ht
     * @return bool
     */
    public static function HT_HAS_ITERATORS(HashTable $ht): bool {
        return (static::HT_ITERATORS_COUNT($ht) !== 0);
    }

}
