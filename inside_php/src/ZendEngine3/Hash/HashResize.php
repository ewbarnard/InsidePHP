<?php

namespace App\ZendEngine3\Hash;

use App\ZendEngine3\ZendTypes\Bucket;
use App\ZendEngine3\ZendTypes\HashTable;
use App\ZendEngine3\ZendTypes\ZendString;
use App\ZendEngine3\ZendTypes\ZendTypes;
use App\ZendEngine3\ZendTypes\ZendVariables;
use const SORT_NUMERIC;
use function str_split;

/**
 * Class HashResize
 *
 * @package App\ZendEngine3\Hash
 */
class HashResize {
    private function __construct() { // Static only
    }

    /**
     * Extern Zend/zend_hash.h line 98
     *
     * @param HashTable $ht
     */
    public static function zend_hash_destroy(HashTable $ht): void {
    }

    /**
     * Extern Zend/zend_hash.h line 99
     *
     * @param HashTable $ht
     */
    public static function zend_hash_clean(HashTable $ht): void {
    }

    /**
     * Zend/zend_hash.c line 78
     * If the hashtable can be compacted, do so.
     * Otherwise double its size and initialize the second half appropriately
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
     * Check and normalize the requested hashtable size.
     * It needs to be between the min and max allowed size. Min is 8, and max
     * differs depending on whether we have 32-bit or 64-bit word size.
     * The size normalization appears to be aimed at getting us on a power
     * of two, but I'm not sure.
     *
     * @param int $nSize
     * @return int
     * @throws \Exception
     */
    public static function zend_hash_check_size(int $nSize): int {
        /* Use big enough power of 2 */
        /* Size should be between HT_MIN_SIZE and HT_MAX_SIZE */
        if ($nSize <= ZendTypes::HT_MIN_SIZE) {
            return ZendTypes::HT_MIN_SIZE;
        } elseif ($nSize >= ZendTypes::HT_MAX_SIZE) {
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
        $ht->HASH_FLAG_PACKED = 1;
        HashTable::HT_HASH_RESET_PACKED($ht);
        $ht->HASH_FLAG_UNINITIALIZED = 0;
    }

    /**
     * Zend/zend_hash.c line 136
     *
     * The real code allocates space for hash slots and bucket slots together:
     *  - If we are representing a persistent array, we use pemalloc() to allocate space
     *  - Otherwise we use the standard emalloc() to allocate space
     *
     * We can't simulate "persistent array" so treat it the same as a standard array.
     *
     * @param HashTable $ht
     * @throws \Exception
     */
    public static function zend_hash_real_init_mixed_ex(HashTable $ht): void {
        $ht->nTableMask = HashTable::HT_SIZE_TO_MASK($ht->nTableSize);
        $ht->HASH_FLAG_UNINITIALIZED = 0;
        $ht->HASH_FLAG_PACKED = 0;
        HashTable::HT_HASH_RESET($ht);
    }

    /**
     * Zend/zend_hash.c line 185
     * We do different initialization for packed or mixed hashtables
     *
     * @param HashTable $ht
     * @param int $packed
     * @throws \Exception
     */
    public static function zend_hash_real_init_ex(HashTable $ht, int $packed): void {
        if (!$ht->HASH_FLAG_UNINITIALIZED) {
            throw new \Exception('HashTable already initialized');
        }
        if ($packed) {
            HashResize::zend_hash_real_init_packed_ex($ht);
        } else {
            HashResize::zend_hash_real_init_mixed_ex($ht);
        }
    }

    /**
     * Zend/zend_hash.c line 213
     * Set up an empty array. There is no need to allocate space for the buckets and hash slots.
     * HASH_FLAG_UNINITIALIZED remains one, indicating that if we ever add any elements to this
     * array, we'll first need to allocate space for bucket/hash slots.
     *
     * @param HashTable $ht
     * @param int $nSize
     * @param callable $pDestructor
     * @param bool $persistent
     * @throws \Exception
     */
    public static function _zend_hash_init_int(HashTable $ht, int $nSize, callable $pDestructor,
        bool $persistent): void {
        $ht->gc->IS_ARRAY = 1;
        if ($persistent) {
            $ht->gc->GC_PERSISTENT = 1;
        } else {
            $ht->gc->GC_COLLECTABLE = 1;
        }
        $ht->nTableMask = ZendTypes::HT_MIN_MASK;
        HashTable::HT_HASH_RESET_PACKED($ht);
        $ht->nNumUsed = 0;
        $ht->nNumOfElements = 0;
        $ht->nInternalPointer = 0;
        $ht->nNextFreeElement = 0;
        $ht->pDestructor = $pDestructor;
        $ht->nTableSize = static::zend_hash_check_size($nSize);
    }

    /**
     * Zend/zend_hash.c line 228
     * Set up an empty array.
     *
     * @param HashTable $ht
     * @param int $nSize
     * @param callable $pDestructor
     * @param bool $persistent
     * @throws \Exception
     */
    public static function _zend_hash_init(HashTable $ht, int $nSize, callable $pDestructor, bool $persistent): void {
        HashResize::_zend_hash_init_int($ht, $nSize, $pDestructor, $persistent);
    }

    /**
     * Zend/zend_hash.h line 291
     *
     * @param int $size
     * @return HashTable
     * @throws \Exception
     */
    public static function zend_new_array(int $size): HashTable {
        return HashResize::_zend_new_array($size);
    }

    /**
     * Extern Zend/zend_hash.h line 295
     * Zend/zend_hash.c line 233
     * Set up an empty array with the minimum allocation size and default ZendTypes destructor.
     *
     * @return HashTable
     * @throws \Exception
     */
    public static function _zend_new_array_0(): HashTable {
        $ht = new HashTable();
        HashResize::_zend_hash_init_int($ht, ZendTypes::HT_MIN_SIZE, ZendVariables::ZVAL_PTR_DTOR, 0);
        return $ht;
    }

    /**
     * Extern Zend/zend_hash.h line 296
     * Zend/zend_hash.c line 240
     * Set up an empty array with a specified allocation size and default ZendTypes destructor.
     * Although the allocation size is set, space is not yet allocated - it will be the first
     * time we add an element to the array.
     *
     * @param int $nSize
     * @return HashTable
     * @throws \Exception
     */
    public static function _zend_new_array(int $nSize): HashTable {
        $ht = new HashTable();
        HashResize::_zend_hash_init_int($ht, $nSize, ZendVariables::ZVAL_PTR_DTOR, 0);
        return $ht;
    }

    /**
     * Extern Zend/zend_hash.h line 297
     *
     * @param HashTable $ht
     * @return int
     */
    public static function zend_array_count(HashTable $ht): int {
    }

    /**
     * Extern Zend/zend_hash.h line 298
     *
     * @param HashTable $source
     * @return HashTable
     */
    public static function zend_array_dup(HashTable $source): HashTable {
    }

    /**
     * Extern Zend/zend_hash.h line 299
     *
     * @param HashTable $ht
     */
    public static function zend_array_destroy(HashTable $ht): void {
    }

    /**
     * Extern Zend/zend_hash.h line 300
     *
     * @param HashTable $ht
     */
    public static function zend_symtable_clean(HashTable $ht): void {
    }

    /**
     * Extern Zend/zend_hash.h line 301
     *
     * @param HashTable $ht
     * @return HashTable
     */
    public static function zend_symtable_to_proptable(HashTable $ht): HashTable {
    }

    /**
     * Extern Zend/zend_hash.h line 302
     *
     * @param HashTable $ht
     * @param bool $always_duplicate
     * @return HashTable
     */
    public static function zend_proptable_to_symtable(HashTable $ht, bool $always_duplicate): HashTable {
    }

    /**
     * Extern Zend/zend_hash.h line 304
     *
     * @param string $key
     * @param int $length
     * @param int $idx
     * @return int
     */
    public static function _zend_handle_numeric_str_ex(string $key, int $length, int $idx): int {
    }

    /**
     * Zend/zend_hash.h line 330
     *
     * @param string $key
     * @param int $length
     * @param int $idx
     * @return int
     */
    public static function _zend_handle_numeric_str(string $key, int $length, int $idx): int {
        $tmp = str_split($key);
        if ($tmp[0] > '9') {
            return 0;
        } elseif ($tmp[0] < '0') {
            if ($tmp[0] !== '-') {
                return 0;
            }
            if (($tmp[1] > '9') || ($tmp[1] < '0')) {
                return 0;
            }
        }
        return HashResize::_zend_handle_numeric_str_ex($key, $length, $idx);
    }

    /**
     * Zend/zend_hash.h line 351
     *
     * @param ZendString $key
     * @param int $idx
     * @return int
     */
    public static function ZEND_HANDLE_NUMERIC(ZendString $key, int $idx): int {
        return HashResize::ZEND_HANDLE_NUMERIC_STR(ZendString::ZSTR_VAL($key), ZendString::ZSTR_LEN($key), $idx);
    }

    /**
     * Zend/zend_hash.h line 348
     *
     * @param string $key
     * @param int $length
     * @param int $idx
     * @return int
     */
    public static function ZEND_HANDLE_NUMERIC_STR(string $key, int $length, int $idx): int {
        return HashResize::_zend_handle_numeric_str($key, $length, $idx);
    }

    /**
     * Zend/zend_hash.c line 247
     * Increase the space allocation for this hashtable.
     *
     * @param HashTable $ht
     * @throws \Exception
     */
    public static function zend_hash_packed_grow(HashTable $ht): void {
        if ($ht->nTableSize >= ZendTypes::HT_MAX_SIZE) {
            throw new \Exception('Possible integer overflow in memory allocation');
        }
        HashResize::doubleTableSize($ht);
    }

    /**
     * Zend/zend_hash.c line 257
     * Initialize the hashtable - allocate space for the bucket and hash slots; set the bucket
     * slots to null (unused); set the hash slots to invalid-index (unused).
     *
     * @param HashTable $ht
     * @param bool $packed
     * @throws \Exception
     */
    public static function zend_hash_real_init(HashTable $ht, bool $packed): void {
        HashResize::zend_hash_real_init_ex($ht, $packed);
    }

    /**
     * Zend/zend_hash.c line 265
     * Initialize the hashtable as a packed array - the bucket slot is the same as the
     * numeric key and the hash slots are unused. The bucket slots are set to null, indicating
     * no buckets are yet in use. It's an empty packed hashtable.
     *
     * @param HashTable $ht
     */
    public static function zend_hash_real_init_packed(HashTable $ht): void {
        HashResize::zend_hash_real_init_packed_ex($ht);
    }

    /**
     * Zend/zend_hash.c line 273
     * Initialize the hashtable - allocate space for the bucket and hash slots, setting
     * each to invalid/unused.
     *
     * @param HashTable $ht
     * @throws \Exception
     */
    public static function zend_hash_real_init_mixed(HashTable $ht): void {
        HashResize::zend_hash_real_init_mixed_ex($ht);
    }

    /**
     * Zend/zend_hash.c line 281
     * Convert a packed hashtable to a regular (mixed) hashtable. For each bucket
     * slot containing a valid bucket, set the corresponding hash slot to point to
     * its bucket. At this point it's a one-to-one correspondence with no collisions.
     *
     * @param HashTable $ht
     * @throws \Exception
     */
    public static function zend_hash_packed_to_hash(HashTable $ht): void {
        $ht->HASH_FLAG_PACKED = 0;
        $ht->nTableMask = HashTable::HT_SIZE_TO_MASK($ht->nTableSize);
        HashResize::zend_hash_rehash($ht);
    }

    /**
     * Zend/zend_hash.c line 297
     * Convert a regular hashtable to a packed hashtable. We assume the buckets are already
     * correctly set up. We flag it as packed and invalidate the hash slots. The packed table
     * does not use the hash slots at all.
     *
     * @param HashTable $ht
     */
    public static function zend_hash_to_packed(HashTable $ht): void {
        $ht->HASH_FLAG_PACKED = 1;
        $ht->HASH_FLAG_STATIC_KEYS = 1;
        $ht->nTableMask = HashTable::HT_MIN_MASK;
        $ht->arHash = [HashTable::HT_INVALID_IDX, HashTable::HT_INVALID_IDX];
    }

    /**
     * Zend/zend_hash.c line 312
     * Extend the hashtable to the specified size
     *
     * @param HashTable $ht
     * @param int $nSize
     * @param bool $packed
     * @throws \Exception
     */
    public static function zend_hash_extend(HashTable $ht, int $nSize, bool $packed): void {
        if ($nSize === 0) {
            return;
        }
        if (!$ht->HASH_FLAG_UNINITIALIZED) {
            // Not yet initialized
            if ($nSize > $ht->nTableSize) {
                $ht->nTableSize = static::zend_hash_check_size($nSize);
            }
            HashResize::zend_hash_real_init($ht, $packed);
        } else {
            // Has been previously initialized
            if ($packed) {
                if (!$ht->HASH_FLAG_PACKED) {
                    throw new \Exception('Unpacked hashtable being extended as packed');
                }
                if ($nSize > $ht->nTableSize) {
                    // Expanding packed hashtable
                    $priorSize = $ht->nTableSize;
                    $ht->nTableSize = HashResize::zend_hash_check_size($nSize);
                    $delta = $ht->nTableSize - $priorSize;
                    $ht->arData += \array_fill($ht->nTableSize, $delta, null);
                }
            } else {
                // Expanding regular hashtable
                if ($ht->HASH_FLAG_PACKED) {
                    throw new \Exception('Packed hashtable being extended as standard');
                }
                if ($nSize > $ht->nTableSize) {
                    // Expanding regular hashtable that has already been initialized
                    $nSize = HashResize::zend_hash_check_size($nSize);
                    $delta = $nSize - $ht->nTableSize;
                    $ht->arData += \array_fill($ht->nTableSize, $delta, null);
                    $ht->arHash += \array_fill($ht->nTableSize, $delta, HashTable::HT_INVALID_IDX);
                    $ht->nTableSize = $nSize;
                    HashResize::zend_hash_rehash($ht);
                }
            }
        }
    }

    /**
     * Zend/zend_hash.c line 346
     * Discard elements - array_pop, perhaps?
     *
     * @param HashTable $ht
     * @param int $nNumUsed
     */
    public static function zend_hash_discard(HashTable $ht, int $nNumUsed): void {
        $pSlot = $ht->nNumUsed;
        $endSlot = $nNumUsed;
        $ht->nNumUsed = $nNumUsed;

        while ($pSlot !== $endSlot) {
            $pSlot--;
            $p = $ht->arData[$pSlot];
            if (!$p || ($p->val->type === Zval::IS_UNDEF)) {
                continue;
            }
            $ht->nNumOfElements--;
            /* Collision pointers always directed from higher to lower buckets */
            $nIndex = $p->h | $ht->nTableMask;
            $ht->arHash[$nIndex] = $p->val->next;
        }
    }

    /**
     * Zend/zend_hash.c line 1112
     * Compact the table if there are enough unused slots to make it worthwhile.
     * Otherwise, assuming the table is less than the maximum allowed size, double
     * its size and initialize the new part as appropriate.
     *
     * @param HashTable $ht
     * @throws \Exception
     */
    public static function zend_hash_do_resize(HashTable $ht): void {
        /* Additional term is there to amortize the cost of compaction */
        if ($ht->nNumUsed > $ht->nNumOfElements + ($ht->nNumOfElements >> 5)) {
            HashResize::zend_hash_rehash($ht);
        } elseif ($ht->nTableSize < HashTable::HT_MAX_SIZE) {
            self::doubleTableSize($ht);
            $ht->nTableMask = static::HT_SIZE_TO_MASK($ht->nTableSize);
        } else {
            throw new \Exception('Possible integer overflow in memory allocation');
        }
    }

    /**
     * @param HashTable $ht
     */
    public static function doubleTableSize(HashTable $ht): void {
        /* Let's double the table size */
        $nSize = $ht->nTableSize + $ht->nTableSize;
        $key = -$nSize;
        $end = -$ht->nTableSize;
        while ($key < $end) {
            $ht->arData[$key++] = ZendTypes::HT_INVALID_IDX;
        }
        $key = $ht->nTableSize;
        while ($key < $nSize) {
            $ht->arData[$key++] = null;
        }
        \ksort($ht->arData, SORT_NUMERIC);
        $ht->nTableSize = $nSize;
        $ht->nTableMask = HashTable::HT_SIZE_TO_MASK($ht->nTableSize);
    }

    /**
     * @param HashTable $ht
     * @param int $slot
     * @throws \Exception
     */
    public static function initializeBucket(HashTable $ht, int $slot): void {
        if ($slot >= $ht->nTableSize) {
            throw new \Exception('Initializing out-of-range bucket');
        }
        $p = $ht->arData[$slot];
        if ($p !== null) {
            throw new \Exception('Bucket already initialized');
        }
        $p = new Bucket();
        $p->val = new Zval();
        $ht->arData[$slot] = $p;
    }

    /**
     * @param HashTable $ht
     * @param int $slot
     * @return Bucket
     * @throws \Exception
     */
    public static function ensureBucketInitialized(HashTable $ht, int $slot): Bucket {
        if ($ht->arData[$slot] === null) {
            HashResize::initializeBucket($ht, $slot);
        }
        return $ht->arData[$slot];
    }
}
