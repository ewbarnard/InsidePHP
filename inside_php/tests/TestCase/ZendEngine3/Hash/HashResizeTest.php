<?php

namespace App\ZendEngine3\Hash;

use App\ZendEngine3\AbstractHashSetup;
use App\ZendEngine3\ZendTypes\HashTable;
use App\ZendEngine3\ZendTypes\ZendTypes;

class HashResizeTest extends AbstractHashSetup {
    /**
     * @covers \App\ZendEngine3\Hash\HashResize::zend_hash_check_size
     * @param int $nSize
     * @param int $expected
     * @dataProvider dataValidSizes
     * @throws \Exception
     */
    public function testValidSizes(int $nSize, int $expected): void {
        $actual = HashResize::zend_hash_check_size($nSize);
        static::assertSame($expected, $actual, sprintf("Expected 0x%x, actual 0x%x", $expected, $actual));
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashResize::zend_hash_check_size
     * @throws \Exception
     * @expectedException \Exception
     * @expectedExceptionMessage Possible integer overflow in memory allocation
     */
    public function testInvalidSize() {
        HashResize::zend_hash_check_size(ZendTypes::HT_MAX_SIZE);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashResize::zend_hash_real_init_packed_ex
     */
    public function testInitPackedInitialized(): void {
        static::assertSame(1, $this->ht->HASH_FLAG_UNINITIALIZED);
        static::assertSame(0, $this->ht->HASH_FLAG_PACKED);

        HashResize::zend_hash_real_init_packed_ex($this->ht);

        static::assertSame(0, $this->ht->HASH_FLAG_UNINITIALIZED);
        static::assertSame(1, $this->ht->HASH_FLAG_PACKED);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashResize::zend_hash_real_init_ex
     * @expectedException \Exception
     * @param int $packed
     * @throws \Exception
     * @dataProvider dataBit
     */
    public function testDoubleInitialize(int $packed): void {
        HashResize::zend_hash_real_init_ex($this->ht, $packed);
        HashResize::zend_hash_real_init_ex($this->ht, $packed);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashResize::zend_hash_real_init_ex
     * @throws \Exception
     */
    public function testInitPacked(): void {
        HashResize::zend_hash_real_init_ex($this->ht, 1);

        static::assertSame(static::UNDEF, $this->ht->arData);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashResize::zend_hash_real_init_ex
     * @throws \Exception
     */
    public function testInitMixed(): void {
        HashResize::zend_hash_real_init_ex($this->ht, 0);

        static::assertSame(static::MIN, $this->ht->arData);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashResize::zend_hash_real_init_ex
     * @throws \Exception
     */
    public function testInitMixedMedium(): void {
        $this->ht->nTableSize = 16;

        HashResize::zend_hash_real_init_ex($this->ht, 0);

        static::assertSame(static::MEDIUM, $this->ht->arData);
    }


    /**
     * @covers \App\ZendEngine3\Hash\HashResize::_zend_hash_init_int
     * zend_hash.c 216 _zend_hash_init_int
     *
     * @dataProvider dataBit
     * @param int $bit
     * @throws \Exception
     */
    public function testInitPersistent(int $bit): void {
        $persistent = (bool)$bit;
        $flip = (int)(!$bit);
        HashResize::_zend_hash_init_int($this->ht, ZendTypes::HT_MIN_SIZE, $this->func, $persistent);

        static::assertSame($bit, $this->ht->gc->GC_PERSISTENT);
        static::assertSame($flip, $this->ht->gc->GC_COLLECTABLE);
        static::assertSame(1, $this->ht->gc->IS_ARRAY);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashResize::_zend_hash_init_int
     * zend_hash.c 217 _zend_hash_init_int
     *
     * @dataProvider dataBit
     * @param int $bit
     * @throws \Exception
     */
    public function testInitUnitialized(int $bit): void {
        $persistent = (bool)$bit;
        HashResize::_zend_hash_init_int($this->ht, ZendTypes::HT_MIN_SIZE, $this->func, $persistent);

        static::assertSame(1, $this->ht->HASH_FLAG_UNINITIALIZED);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashResize::_zend_hash_init_int
     * zend_hash.c 218 _zend_hash_init_int
     *
     * @dataProvider dataBit
     * @param int $bit
     * @throws \Exception
     */
    public function testInitMask(int $bit): void {
        $persistent = (bool)$bit;
        HashResize::_zend_hash_init_int($this->ht, ZendTypes::HT_MIN_SIZE, $this->func, $persistent);

        static::assertSame(ZendTypes::HT_MIN_MASK, $this->ht->nTableMask);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashResize::_zend_hash_init_int
     * zend_hash.c 219 _zend_hash_init_int
     *
     * @dataProvider dataBit
     * @param int $bit
     * @throws \Exception
     */
    public function testInitUnitializedBucket(int $bit): void {
        $persistent = (bool)$bit;
        HashResize::_zend_hash_init_int($this->ht, ZendTypes::HT_MIN_SIZE, $this->func, $persistent);

        static::assertSame(static::UNDEF, $this->ht->arData);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashResize::_zend_hash_init_int
     * zend_hash.c 220-224 _zend_hash_init_int
     *
     * @dataProvider dataBit
     * @param int $bit
     * @throws \Exception
     */
    public function testInitProperties(int $bit): void {
        $persistent = (bool)$bit;
        HashResize::_zend_hash_init_int($this->ht, ZendTypes::HT_MIN_SIZE, $this->func, $persistent);

        static::assertSame(0, $this->ht->nNumUsed);
        static::assertSame(0, $this->ht->nNumOfElements);
        static::assertSame(0, $this->ht->nInternalPointer);
        static::assertSame(0, $this->ht->nNextFreeElement);
        static::assertSame($this->func, $this->ht->pDestructor);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashResize::_zend_hash_init_int
     * zend_hash.c 213 _zend_hash_init_int
     *
     * @param int $nSize
     * @param int $expected
     * @dataProvider dataValidSizes
     * @throws \Exception
     */
    public function testInitSize(int $nSize, int $expected): void {
        HashResize::_zend_hash_init_int($this->ht, $nSize, $this->func, false);

        static::assertSame($expected, $this->ht->nTableSize);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashResize::_zend_hash_init_int
     * zend_hash.c 228 _zend_hash_init
     *
     * @dataProvider dataBit
     * @param int $bit
     * @throws \Exception
     */
    public function test_zend_hash_init(int $bit): void {
        $persistent = (bool)$bit;
        HashResize::_zend_hash_init($this->ht, ZendTypes::HT_MIN_SIZE, $this->func, $persistent);

        static::assertSame(static::UNDEF, $this->ht->arData);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashResize::_zend_new_array_0
     * zend_hash.c 233 _zend_new_array_0
     *
     * @throws \Exception
     */
    public function test_zend_new_array_0(): void {
        $ht = HashResize::_zend_new_array_0();

        static::assertSame(static::UNDEF, $ht->arData);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashResize::_zend_new_array
     * zend_hash.c 240 _zend_new_array
     *
     * @param int $nSize
     * @param int $expected
     * @throws \Exception
     * @dataProvider dataValidSizes
     */
    public function test_zend_new_array(int $nSize, int $expected): void {
        $ht = HashResize::_zend_new_array($nSize);

        static::assertSame(static::UNDEF, $ht->arData);
        static::assertSame($expected, $ht->nTableSize);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashResize::zend_hash_packed_grow
     * @throws \Exception
     * @expectedException \Exception
     */
    public function testGrowInvalid() {
        $this->ht->nTableSize = ZendTypes::HT_MAX_SIZE;

        HashResize::zend_hash_packed_grow($this->ht);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashResize::zend_hash_packed_grow
     * zend_hash.c 247 zend_hash_packed_grow
     *
     * @throws \Exception
     */
    public function testGrow() {
        HashResize::zend_hash_real_init_ex($this->ht, 0);

        HashResize::zend_hash_packed_grow($this->ht);

        static::assertSame(static::MEDIUM, $this->ht->arData);
        static::assertSame(16, $this->ht->nTableSize);
        static::assertSame(HashTable::HT_SIZE_TO_MASK(16), $this->ht->nTableMask);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashResize::zend_hash_real_init
     * 257 zend_hash_real_init
     *
     * @throws \Exception
     */
    public function test_zend_hash_real_init() {
        $this->ht->nTableSize = 16;

        HashResize::zend_hash_real_init($this->ht, 0);

        static::assertSame(static::MEDIUM, $this->ht->arData);

    }

    /**
     * @covers \App\ZendEngine3\Hash\HashResize::zend_hash_real_init_packed
     * 265 zend_hash_real_init_packed
     */
    public function test_zend_hash_real_init_packed() {
        static::assertSame(1, $this->ht->HASH_FLAG_UNINITIALIZED);
        static::assertSame(0, $this->ht->HASH_FLAG_PACKED);

        HashResize::zend_hash_real_init_packed($this->ht);

        static::assertSame(0, $this->ht->HASH_FLAG_UNINITIALIZED);
        static::assertSame(1, $this->ht->HASH_FLAG_PACKED);
        static::assertSame(static::UNDEF, $this->ht->arData);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashResize::zend_hash_real_init_mixed
     * 273 zend_hash_real_init_mixed
     *
     * @throws \Exception
     */
    public function test_zend_hash_real_init_mixed() {
        $this->ht->nTableSize = 16;

        HashResize::zend_hash_real_init_mixed($this->ht);

        static::assertSame(static::MEDIUM, $this->ht->arData);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashResize::zend_hash_packed_to_hash
     * 281 zend_hash_packed_to_hash
     *
     * @throws \Exception
     */
    public function test_zend_hash_packed_to_hash() {
        HashResize::zend_hash_real_init_packed_ex($this->ht);
        static::assertSame(static::UNDEF, $this->ht->arData);
        static::assertSame(0, $this->ht->HASH_FLAG_UNINITIALIZED);
        static::assertSame(1, $this->ht->HASH_FLAG_PACKED);

        HashResize::zend_hash_packed_to_hash($this->ht);

        static::assertSame(static::MIN, $this->ht->arData);
        static::assertSame(0, $this->ht->HASH_FLAG_UNINITIALIZED);
        static::assertSame(0, $this->ht->HASH_FLAG_PACKED);
    }
}
