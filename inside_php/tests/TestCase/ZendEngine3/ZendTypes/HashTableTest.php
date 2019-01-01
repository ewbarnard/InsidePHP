<?php

namespace App\ZendEngine3\ZendTypes;

use App\ZendEngine3\AbstractHashSetup;
use App\ZendEngine3\Hash\HashResize;

class HashTableTest extends AbstractHashSetup {
    /**
     * @covers \App\ZendEngine3\ZendTypes\HashTable::HT_HASH_RESET
     */
    public function testResetPacked() {
        HashTable::HT_HASH_RESET_PACKED($this->ht);

        static::assertSame(static::UNDEF, $this->ht->arData);
    }

    /**
     * @covers \App\ZendEngine3\ZendTypes\HashTable::HT_HASH_RESET
     * @throws \Exception
     */
    public function testResetMin() {
        $this->ht->nTableSize = ZendTypes::HT_MIN_SIZE;
        $this->ht->nTableMask = HashTable::HT_SIZE_TO_MASK($this->ht->nTableSize);

        HashTable::HT_HASH_RESET($this->ht);
        HashTable::htBucketReset($this->ht);

        static::assertSame(static::MIN, $this->ht->arData);
    }

    /**
     * @covers \App\ZendEngine3\ZendTypes\HashTable::HT_HASH_RESET
     * @throws \Exception
     */
    public function testResetMedium() {
        $this->ht->nTableSize = HashResize::zend_hash_check_size(ZendTypes::HT_MIN_SIZE+1);
        $this->ht->nTableMask = HashTable::HT_SIZE_TO_MASK($this->ht->nTableSize);

        HashTable::HT_HASH_RESET($this->ht);
        HashTable::htBucketReset($this->ht);

        static::assertSame(static::MEDIUM, $this->ht->arData);
    }
}
