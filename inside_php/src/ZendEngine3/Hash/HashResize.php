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
     * Zend/zend_hash.h line 62
     *
     * @param HashTable $ht
     * @return bool
     */
    public static function HT_HAS_ITERATORS(HashTable $ht): bool {
        return (static::HT_ITERATORS_COUNT($ht) !== 0);
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
}
