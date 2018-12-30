<?php
/**
 * Created by PhpStorm.
 * User: ewb
 * Date: 2018-12-29
 * Time: 16:16
 */

namespace App\ZendEngine3\Hash;

use App\ZendEngine3\ZendTypes\Bucket;
use App\ZendEngine3\ZendTypes\HashTable;
use App\ZendEngine3\ZendTypes\ZendTypes;

class HashRehash {
    /** @codeCoverageIgnore */
    private function __construct() { // Static only
    }

    /**
     * Extern Zend/zend_hash.h line 277
     * Zend/zend_hash.c line 1141
     *
     * Compress bucket slots to remove inactive buckets.
     * "Next" pointers on collision chain always point to lower-numbered slots.
     * Our implementation uses null for uninitialized buckets rather than actual
     * bucket objects. In this method we need to check for null.
     *
     * @param HashTable $ht
     * @return int
     * @throws \Exception
     */
    public static function zend_hash_rehash(HashTable $ht): int {
        if (HashRehash::isEmptyArray($ht)) {
            return HashRehash::clearEmptyArray($ht);
        }
        if (HashTable::HT_IS_PACKED($ht)) {
            return HashRehash::clearPackedArray($ht);
        }
        return ZendTypes::SUCCESS;

        HashTable::HT_HASH_RESET($ht);
        $i = 0;
        $bucketSlot = 0;
        /** @var Bucket $p */
        $p = $ht->arData[$bucketSlot];
        if (HashTable::HT_IS_WITHOUT_HOLES($ht)) {
            do {
                $nIndex = $p->h | $ht->nTableMask;
                $p->val->next = $nIndex;
                $ht->arHash[$nIndex] = $i;
                $p = $ht->arData[++$bucketSlot];
            } while (++$i < $ht->nNumUsed);
        } else {
            // Null checks needed here
            do {
                if (($p === null) || ($p->val->type === Zval::IS_UNDEF)) {
                    $j = $i;
                    $qBucketSlot = $bucketSlot;

                    if (!HashIterator::HT_HAS_ITERATORS($ht)) {
                        while (++$i < $ht->nNumUsed) {
                            ++$bucketSlot;
                            $p = $ht->arData[$bucketSlot];
                            if ($p && ($p->val->type !== Zval::IS_UNDEF)) {
                                $q = static::ensureBucketInitialized($ht, $qBucketSlot);
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
                                ++$qBucketSlot;
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
     * Special-case empty array - nothing to rehash
     *
     * @param HashTable $ht
     * @return bool
     */
    public static function isEmptyArray(HashTable $ht): bool {
        return (($ht->nNumOfElements === 0) || ($ht->nNumOfElements === null));
    }

    /**
     * When the array is empty, only need to clear if it has been initialized.
     * An unitialized array is already set to empty.
     *
     * @param HashTable $ht
     * @return int
     * @throws \Exception
     */
    public static function clearEmptyArray(HashTable $ht): int {
        if (HashTable::HT_IS_INITIALIZED($ht)) {
            $ht->nNumUsed = 0;
            HashTable::HT_HASH_RESET($ht);
        }
        return ZendTypes::SUCCESS;
    }

    /**
     * A packed array cannot be compacted - the bucket slot already corresponds
     * to the lookup key; that is the definition of packed. A sparse packed array
     * must remain sparse
     *
     * @param HashTable $ht
     * @return int
     */
    public static function clearPackedArray(HashTable $ht): int {
        if (0 && $ht) { // dummy
            // @codeCoverageIgnoreStart
            return ZendTypes::SUCCESS;
        }
        // @codeCoverageIgnoreEnd
        return ZendTypes::SUCCESS;
    }

}
