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
        $ht->begin(__FUNCTION__);
        if (HashRehash::isEmptyArray($ht)) {
            return HashRehash::clearEmptyArray($ht);
        }

        if (HashTable::HT_IS_PACKED($ht)) {
            return HashRehash::clearPackedArray($ht);
        }

        if (HashTable::HT_HAS_ITERATORS($ht)) {
            // Zend/zend_hash.c line 1186
            // @codeCoverageIgnoreStart
            throw new \Exception('Not supporting hash table with iterators');
        }
        // @codeCoverageIgnoreEnd
        HashTable::HT_HASH_RESET($ht);

        if (HashTable::HT_IS_WITHOUT_HOLES($ht)) {
            return HashRehash::rehashNoHoles($ht);
        }

        return HashRehash::rehashHoles($ht);
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

    /**
     * The bucket "next" pointer (the collision chain) always points to a lower-numbered
     * bucket slot, or is a negative number (meaning invalid, i.e., we have reached the
     * end of the chain). When there are no collisions, the next pointer will therefore
     * be a negative number (or possibly null in this simulation).
     *
     * Bucket slots are >= 0, and hash slots are < 0. The hash slot's value will be the
     * number of a bucket slot, or -1 to indicate it's an unused hash slot. Bucket slots
     * contain a bucket pointer, or null to indicate it's an unused bucket slot (in this
     * simulation).
     *
     * The hash slot always points to the highest-numbered bucket slot of a collision
     * chain. We start high and work our way low. The bucket's "next" pointer, if any,
     * always points to a lower-numbered bucket slot. In the real implementation, "next"
     * is a pointer; here it is merely a slot number.
     *
     * When there are no gaps in the bucket slots, we can rehash the hash table by walking
     * through the bucket slots, from slot 0 up to the highest slot currently in use.
     *  - For the bucket slot, compute the corresponding hash slot
     *  - Take the hash slot's current value and store it in the bucket's "next" field.
     *  - Store the current bucket slot number as the new hash slot's value
     *
     * In this way, we rebuild the hash collision chain as we go. The hash slot keeps
     * getting updated to the highest-numbered bucket using this hash value, and the
     * bucket points to the next-lower slot in the collision chain.
     *
     * The "collision chain" is the list of all PHP array keys that hash to the same
     * hash slot number. For example, in this implementation (using crc32 as the hashing
     * function), both PHP numeric array key "1" and PHP string array key "aab" map
     * to hash slot -7, when the hash table size is the minimum size of 8.
     *
     * When looking up the value for array key "1", or the value for array key "aab",
     * both lead us to hash slot -7. Each bucket stores both the PHP value we're seeking,
     * AND the actual PHP array key (either 1 or "aab" in this case). We walk through
     * the buckets until we find the bucket with our array key, or hit the end of the
     * chain (key not found).
     *
     * @param HashTable $ht
     * @return int
     * @throws \Exception
     */
    public static function rehashNoHoles(HashTable $ht): int {
        $bucketSlot = 0;
        do {
            $ht->validateBucketSlot($bucketSlot);
            HashRehash::rehashBucketSlot($ht, $bucketSlot);
        } while (++$bucketSlot < $ht->nNumUsed);
        return ZendTypes::SUCCESS;
    }

    /**
     * @param \App\ZendEngine3\ZendTypes\HashTable $ht
     * @param int $bucketSlot
     * @throws \Exception
     */
    public static function rehashBucketSlot(HashTable $ht, int $bucketSlot): void {
        /** @var Bucket $bucket */
        $bucket = $ht->arData[$bucketSlot];

        if ($bucket === null) {
            // @codeCoverageIgnoreStart
            throw new \Exception(__FUNCTION__ . "bucketSlot $bucketSlot is empty");
        }
        // @codeCoverageIgnoreEnd

        $hashSlot = $bucket->h | $ht->nTableMask;
        $ht->validateHashSlot($hashSlot);
        $bucket->val->u2_next = $ht->arData[$hashSlot];
        $ht->arData[$hashSlot] = $bucketSlot;
    }

    /**
     * Since our bucket slots merely contain pointers to Bucket objects, we don't need
     * to copy buckets. We can just shift the pointer from the old slot to the new slot.
     *
     * @param HashTable $ht
     * @return int
     * @throws \Exception
     */
    public static function rehashHoles(HashTable $ht): int {
        $ht->progress(__FUNCTION__);
        $currentBucketSlot = 0;
        $unusedBucketSlot = -1;
        do {
            $ht->validateBucketSlot($currentBucketSlot);
            if (HashRehash::bucketSlotUnused($ht, $currentBucketSlot)) {
                $ht->arData[$currentBucketSlot] = null;
                if ($unusedBucketSlot < 0) {
                    $unusedBucketSlot = $currentBucketSlot;
                }
                $ht->progress("Slot $currentBucketSlot marked unused, unusedBucketSlot is $unusedBucketSlot");
            } else {
                if ($unusedBucketSlot >= 0) {
                    $ht->progress("Bringing bucket $currentBucketSlot down to $unusedBucketSlot");
                    // Bring the bucket down to the unused slot, effectively
                    // bubbling-up the unused slot to the next position
                    $ht->arData[$unusedBucketSlot] = $ht->arData[$currentBucketSlot];
                    $ht->arData[$currentBucketSlot] = null;
                    $currentBucketSlot = $unusedBucketSlot;
                    $unusedBucketSlot = -1;
                    $ht->arData[$currentBucketSlot]->bucketSlot = $currentBucketSlot;
                }
                $ht->progress("currentBucketSlot $currentBucketSlot, unusedBucketSlot $unusedBucketSlot");
            }
        } while (++$currentBucketSlot < $ht->nNumUsed);
        $ht->nNumUsed = $ht->nNumOfElements;
        return HashRehash::rehashNoHoles($ht);
    }

    /**
     * @param \App\ZendEngine3\ZendTypes\HashTable $ht
     * @param int $bucketSlot
     * @return bool
     * @throws \Exception
     */
    public static function bucketSlotUnused(HashTable $ht, int $bucketSlot): bool {
        if ($ht->arData[$bucketSlot] === null) {
            return true;
        }
        /** @var Bucket $bucket */
        $bucket = $ht->arData[$bucketSlot];
        return ($bucket->val->u1_v_type === ZendTypes::IS_UNDEF);
    }
}
