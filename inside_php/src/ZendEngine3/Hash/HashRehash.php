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
    private function __construct() { // Static only
    }

    /**
     * Extern Zend/zend_hash.h line 277
     * Zend/zend_hash.c line 1137
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
        if ($ht->nNumOfElements === 0) {
            /* requesting empty array */
            if (!$ht->HASH_FLAG_UNINITIALIZED) {
                /* Only need to clear if initialized; uninitialized is already empty */
                $ht->nNumUsed = 0;
                HashTable::HT_HASH_RESET($ht);
            }
            return ZendTypes::SUCCESS;
        }
        if ($ht->HASH_FLAG_PACKED) {
            return ZendTypes::SUCCESS;
        }
        return ZendTypes::SUCCESS;//FIXME

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

}
