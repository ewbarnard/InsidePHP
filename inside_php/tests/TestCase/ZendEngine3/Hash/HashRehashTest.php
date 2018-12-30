<?php

namespace App\ZendEngine3\Hash;

use App\ZendEngine3\AbstractHashSetup;
use App\ZendEngine3\ZendTypes\Bucket;
use App\ZendEngine3\ZendTypes\HashTable;
use App\ZendEngine3\ZendTypes\ZendTypes;

class HashRehashTest extends AbstractHashSetup {
    /**
     * @covers \App\ZendEngine3\Hash\HashRehash::zend_hash_rehash
     * @throws \Exception
     */
    public function testUnitialized(): void {
        $success = HashRehash::zend_hash_rehash($this->ht);

        static::assertSame(ZendTypes::SUCCESS, $success);
        static::assertSame([], $this->ht->arData);
        static::assertSame(0, $this->ht->nNumOfElements);
        static::assertSame(0, $this->ht->nNumUsed);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashRehash::zend_hash_rehash
     * @throws \Exception
     */
    public function testPackedUndef() {
        HashTable::HT_HASH_RESET_PACKED($this->ht);

        $success = HashRehash::zend_hash_rehash($this->ht);

        static::assertSame(ZendTypes::SUCCESS, $success);
        static::assertSame(static::UNDEF, $this->ht->arData);
        static::assertSame(0, $this->ht->nNumOfElements);
        static::assertSame(0, $this->ht->nNumUsed);
        static::assertSame(1, $this->ht->HASH_FLAG_UNINITIALIZED);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashRehash::zend_hash_rehash
     * @throws \Exception
     */
    public function testPackedNoHoles() {
        $nValues = 8;
        $profile = $this->buildPacked($nValues);

        $success = HashRehash::zend_hash_rehash($this->ht);

        static::assertSame(ZendTypes::SUCCESS, $success);
        static::assertSame($nValues, $this->ht->nNumOfElements);
        static::assertSame($nValues, $this->ht->nNumUsed);
        static::assertSame(0, $this->ht->HASH_FLAG_UNINITIALIZED);
        $this->probeTable($profile, __FUNCTION__);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashRehash::zend_hash_rehash
     * @throws \Exception
     */
    public function testPackedHoleAtEnd() {
        $nValues = 8;
        $profile = $this->buildPacked($nValues);
        $this->ht->arData[7]->val->invalidate();
        $this->ht->nNumOfElements = 7;
        $profile['buckets'][7] = ['type' => ZendTypes::IS_UNDEF];
        unset($profile['show'][7]);

        $success = HashRehash::zend_hash_rehash($this->ht);

        static::assertSame(ZendTypes::SUCCESS, $success);
        static::assertSame(7, $this->ht->nNumOfElements);
        static::assertSame(8, $this->ht->nNumUsed);
        static::assertSame(0, $this->ht->HASH_FLAG_UNINITIALIZED);
        $this->probeTable($profile, __FUNCTION__);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashRehash::zend_hash_rehash
     * @throws \Exception
     */
    public function testMixedNoHoles(): void {
        $profile = $this->buildMixed(static::MIXED_MIN);

        $success = HashRehash::zend_hash_rehash($this->ht);

        static::assertSame(ZendTypes::SUCCESS, $success);
        static::assertSame(8, $this->ht->nNumOfElements);
        static::assertSame(8, $this->ht->nNumUsed);
        static::assertSame(0, $this->ht->HASH_FLAG_UNINITIALIZED);
        $this->probeTable($profile, __FUNCTION__);

    }

    /**
     * @covers \App\ZendEngine3\Hash\HashRehash::zend_hash_rehash
     * @throws \Exception
     */
    public function testMixedHoles(): void {
        static::markTestSkipped(__FUNCTION__ . ' line ' . __LINE__ . ': Need refactor first');
        $profile = $this->buildMixed(static::MIXED_HOLES);

        $success = HashRehash::zend_hash_rehash($this->ht);

        static::assertSame(ZendTypes::SUCCESS, $success);
        static::assertSame(4, $this->ht->nNumOfElements);
        static::assertSame(4, $this->ht->nNumUsed);
        static::assertSame(0, $this->ht->HASH_FLAG_UNINITIALIZED);
        $this->probeTable($profile, __FUNCTION__);

    }

    /**
     * @param array $profile
     * @param string $caller
     * @throws \Exception
     */
    public function probeTable(array $profile, string $caller): void {
        static::assertSame($profile['show'], $this->show(), $caller . print_r($this->ht, true));
        $n = $profile['n'];
        $hashSlots = [];
        $bucketSlots = [];
        foreach ($this->ht->arData as $key => $value) {
            if ($key < 0) {
                $this->ht->validateHashSlot($key);
                $hashSlots[$key] = $value;
            } else {
                $this->ht->validateBucketSlot($key);
                $bucketSlots[$key] = $value;
            }
        }
        static::assertSame($n, count($hashSlots), $caller);
        static::assertSame($n, count($bucketSlots), $caller);
        static::assertSame(count($profile['buckets']), count($bucketSlots));
        foreach ($profile['buckets'] as $key => $row) {
            /** @var Bucket $bucket */
            $bucket = $bucketSlots[$key];
            if ($row['type'] !== ZendTypes::IS_UNDEF) {
                static::assertSame($row['value'], $bucket->val->value->{$row['field']}, $caller);
                static::assertSame($row['type'], $bucket->val->u1_v_type, $caller);
                static::assertSame($row['h'], $bucket->h, $caller);
                static::assertSame($row['next'], $bucket->val->u2_next, $caller);
            } else {
                static::assertSame(ZendTypes::IS_UNDEF, $bucket->val->u1_v_type, $caller);
                static::assertSame(null, $bucket->val->u2_next, $caller);
            }
        }
    }

    /**
     * @param array $mixed
     * @return array
     * @throws \Exception
     */
    public function buildMixed(array $mixed): array {
        $show = $mixed['show'];
        $n = count($mixed['buckets']);
        $return = [
            'show' => $show,
            'n' => $n,
            'hash' => [],
            'buckets' => [],
        ];
        $mask = HashTable::HT_SIZE_TO_MASK($n);
        $this->ht->nTableSize = $n;
        $this->ht->nTableMask = $mask;
        $this->ht->nNumOfElements = count($show);
        $this->ht->nNumUsed = $n;
        $this->ht->HASH_FLAG_UNINITIALIZED = 0;
        $this->ht->HASH_FLAG_PACKED = 0;
        $this->ht->arData = [];
        $slot = $mask;
        while ($slot < $n) {
            if ($slot < 0) {
                $this->ht->arData[$slot] = ZendTypes::HT_INVALID_IDX;
                $return['hash'][$slot] = ZendTypes::HT_INVALID_IDX;
            } else {
                $this->ht->arData[$slot] = null;
                $return['buckets'][$slot] = null;
            }
            $slot++;
        }
        foreach ($mixed['hash'] as $key => $value) {
            $this->ht->arData[$key] = $value;
            $return['hash'][$key] = $value;
        }
        foreach ($mixed['buckets'] as $slot => $row) {
            $bucket = new Bucket($slot);
            list($h, $key, $type, $value, $next) = $row;
            $bucket->val->u2_next = $next;
            $bucket->h = $h;
            $bucketKey = ($key === (int)$key) ? null : $key;
            $bucket->key = $bucketKey;
            if ($type === 'string') {
                $bucket->val->value->str = $value;
                $field = 'str';
                $zendType = ZendTypes::IS_STRING;
                $bucket->key = $key;
            } elseif ($type === 'int') {
                $bucket->val->value->lval = $value;
                $field = 'lval';
                $zendType = ZendTypes::IS_LONG;
            } elseif ($type === 'undef') {
                $bucket->val->invalidate();
                $field = 'str';
                $zendType = ZendTypes::IS_UNDEF;
            } else {
                throw new \Exception("Unknown type $type");
            }
            $bucket->val->u1_v_type = $zendType;
            $return['buckets'][$slot] = [
                'value' => $value,
                'field' => $field,
                'type' => $zendType,
                'h' => $h,
                'bucketKey' => $bucketKey,
                'next' => $next,
            ];
            $this->ht->arData[$slot] = $bucket;
        }
        return $return;
    }

    /**
     * @param int $nValues
     * @return array
     * @throws \Exception
     */
    public function buildPacked(int $nValues): array {
        $show = [];
        $return = ['n' => $nValues, 'hash' => [], 'buckets' => []];
        $nValues = HashResize::zend_hash_check_size($nValues);
        $this->ht->nTableSize = $nValues;
        $this->ht->nTableMask = HashTable::HT_SIZE_TO_MASK($nValues);
        $this->ht->nNumOfElements = $nValues;
        $this->ht->nNumUsed = $nValues;
        $this->ht->HASH_FLAG_UNINITIALIZED = 0;
        $this->ht->HASH_FLAG_PACKED = 1;
        $this->ht->arData = [];
        $slot = $this->ht->nTableMask;
        while ($slot < 0) {
            $this->ht->arData[$slot] = ZendTypes::HT_INVALID_IDX;
            $return['hash'][$slot] = ZendTypes::HT_INVALID_IDX;
            $slot++;
        }
        $value = 'zz';
        while ($slot < $nValues) {
            $bucket = new Bucket($slot);
            $bucket->val->value->str = ++$value;
            $bucket->val->u1_v_type = ZendTypes::IS_STRING;
            $bucket->val->u2_next = null;
            $bucket->h = $slot;
            $this->ht->arData[$slot] = $bucket;
            $return['buckets'][$slot] =
                [
                    'value' => $value,
                    'field' => 'str',
                    'type' => ZendTypes::IS_STRING,
                    'h' => $slot,
                    'next' => null,
                ];
            $show[$slot] = $value;
            $slot++;
        }
        $return['show'] = $show;
        return $return;
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashRehash::isEmptyArray
     * @param int $nNumOfElements
     * @param bool $expected
     * @dataProvider dataEmpty
     */
    public function testIsEmpty(?int $nNumOfElements, bool $expected): void {
        $this->ht->nNumOfElements = $nNumOfElements;

        $actual = HashRehash::isEmptyArray($this->ht);

        static::assertSame($expected, $actual);
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashRehash::clearEmptyArray
     * @throws \Exception
     */
    public function testClearEmptyNotInitialized(): void {
        $success = HashRehash::clearEmptyArray($this->ht);

        static::assertSame(ZendTypes::SUCCESS, $success);
        static::assertSame(0, count($this->ht->arData));
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashRehash::clearEmptyArray
     * @throws \Exception
     */
    public function testClearEmptyInitialized(): void {
        $this->ht->HASH_FLAG_UNINITIALIZED = 0;

        $success = HashRehash::clearEmptyArray($this->ht);

        static::assertSame(ZendTypes::SUCCESS, $success);
        static::assertSame(16, count($this->ht->arData));
    }

    /**
     * @covers \App\ZendEngine3\Hash\HashRehash::clearPackedArray
     */
    public function testClearPackedArray(): void {
        $success = HashRehash::clearPackedArray($this->ht);

        static::assertSame(ZendTypes::SUCCESS, $success);
    }
}
