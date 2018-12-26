<?php

namespace App\ZendEngine3\Hash;

use function array_fill;

final class HashResize
{
    private function __construct()
    {
    }

    /**
     * Zend/zend_hash.c line 78
     *
     * @param HashTable $ht
     * @throws \Exception
     */
    public static function ZEND_HASH_IF_FULL_DO_RESIZE(HashTable $ht): void
    {
        if ($ht->nNumUsed >= $ht->nTableSize) {
            static::zend_hash_do_resize($ht);
        }
    }

    /**
     * Zend/zend_hash.c line 1112
     * @param HashTable $ht
     * @throws \Exception
     */
    public static function zend_hash_do_resize(HashTable $ht): void
    {
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
     * @param HashTable $ht
     */
    public static function zend_hash_rehash(HashTable $ht): void
    {

    }

    /**
     * Zend/zend_types.h line 304
     * @param int $nTableSize
     * @return int
     */
    public static function HT_SIZE_TO_MASK(int $nTableSize): int
    {
        return (-($nTableSize + $nTableSize));
    }
}
