<?php

namespace App\ZendEngine3;

use App\ZendEngine3\ZendTypes\Bucket;
use App\ZendEngine3\ZendTypes\HashTable;
use App\ZendEngine3\ZendTypes\ZendString;
use App\ZendEngine3\ZendTypes\ZendTypes;
use const PHP_EOL;
use PHPUnit\Framework\TestCase;

abstract class AbstractHashSetup extends TestCase {
    public CONST UNDEF = [-2 => -1, -1 => -1];
    public CONST MIN = [
        -8 => -1, -7 => -1, -6 => -1, -5 => -1, -4 => -1, -3 => -1, -2 => -1, -1 => -1,
        0 => null, 1 => null, 2 => null, 3 => null, 4 => null, 5 => null, 6 => null, 7 => null,
    ];
    public CONST MEDIUM = [
        -16 => -1, -15 => -1, -14 => -1, -13 => -1, -12 => -1, -11 => -1, -10 => -1, -9 => -1,
        -8 => -1, -7 => -1, -6 => -1, -5 => -1, -4 => -1, -3 => -1, -2 => -1, -1 => -1,
        0 => null, 1 => null, 2 => null, 3 => null, 4 => null, 5 => null, 6 => null, 7 => null,
        8 => null, 9 => null, 10 => null, 11 => null, 12 => null, 13 => null, 14 => null, 15 => null,
    ];
    public CONST MIXED_MIN = [
        'show' => [
            'aaa' => 'one',
            1 => 'two',
            'aab' => 'three',
            'aac' => 'four',
            0 => 105,
            'aad' => 106,
            'aae' => 110,
            'aaf' => 111,
        ],
        'hash' => [-1 => 4, -2 => 7],
        'buckets' => [
            // bucket slot => h, key, value-type, value, next
            0 => [0, 'aaa', 'string', 'one', null],
            1 => [1, 1, 'string', 'two', null],
            2 => [1, 'aab', 'string', 'three', 1],
            3 => [1, 'aac', 'string', 'four', 2],
            4 => [0, 0, 'int', 105, 0],
            5 => [1, 'aad', 'int', 106, 3],
            6 => [1, 'aae', 'int', 110, 5],
            7 => [1, 'aaf', 'int', 111, 6],
        ],
    ];
    public CONST MIXED_HOLES = [
        'show' => [
            'aab' => 'three',
            'aac' => 'four',
            0 => 105,
            'aae' => 110,
        ],
        'hash' => [-1 => 4, -2 => 7],
        'buckets' => [
            // bucket slot => h, key, value-type, value, next
            0 => [0, 'aaa', 'undef', 'one', null],
            1 => [1, 1, 'undef', 'two', null],
            2 => [1, 'aab', 'string', 'three', null],
            3 => [1, 'aac', 'string', 'four', 2],
            4 => [0, 0, 'int', 105, null],
            5 => [1, 'aad', 'undef', 106, null],
            6 => [1, 'aae', 'int', 110, 3],
            7 => [1, 'aaf', 'undef', 111, null],
        ],
    ];

    /** @var HashTable */
    protected $ht;
    /** @var callable */
    protected $func;
    protected $trace = PHP_EOL;

    public function setUp() {
        $this->trace = PHP_EOL;
        $this->ht = new HashTable();
        $this->func = function () {
        };
    }

    public function dataEmpty() {
        $data = [];

        $data[] = [null, true];
        $data[] = [0, true];
        $data[] = [1, false];
        $data[] = [8, false];

        return $data;
    }

    public function dataBit() {
        $data = [];

        $data[] = [0];
        $data[] = [1];

        return $data;
    }

    public function dataValidSizes() {
        $data = [];

        $data[] = [0, 8];
        $data[] = [10, 16];
        $data[] = [17, 32];
        $data[] = [1048575, 1048576];
        $data[] = [1048576, 1048576];
        $data[] = [1048577, 2097152];
        $data[] = [0x333333, 0x400000];
        $data[] = [0x200001, 0x400000];
        $data[] = [0x40707071, 0x80000000];

        return $data;
    }

    /**
     * @param string|int $key
     * @return mixed
     * @throws \Exception
     */
    public function find($key) {
        $this->trace(__FUNCTION__ . "($key)");
        if (HashTable::HT_IS_PACKED($this->ht)) {
            return $this->bucketValue($key);
        }
        $keyIsInt = ($key === (int)$key);
        $h = $keyIsInt ? ZendString::fakeIntHash($key) : ZendString::fakeHash($key);
        $bucketSlot = $this->bucketSlot($h);
        $this->trace(" - find($key) h $h, bucketSlot $bucketSlot");
        if (($bucketSlot === null) || ($bucketSlot === ZendTypes::HT_INVALID_IDX)) {
            $this->trace(" - Hash slot is empty, returning null");
            return null;
        }
        $this->ht->validateBucketSlot($bucketSlot);
        /** @var Bucket $bucket */
        $bucket = $this->ht->arData[$bucketSlot];
        $this->traceBucket($bucket);
        while (($bucket->h !== $h) && ($bucket->val->u2_next !== null) && ($bucket->val->u2_next >= 0)) {
            $bucketSlot = $bucket->val->u2_next;
            $bucket = $this->ht->arData[$bucketSlot];
            $this->traceBucket($bucket);
        }
        $return = null;
        $found = $keyIsInt ? ($key === $bucket->intKey) : ($key === $bucket->key);
        if ($found) {
            $return = $this->bucketValue($bucketSlot);
            $this->trace(" - Matching h, returning $return");
        } else {
            $this->trace(" - Not found, returning null");
        }
        return $return;
    }

    protected function traceBucket(Bucket $bucket): void {
        $this->trace(" - traceBucket: bucketSlot {$bucket->bucketSlot}, h {$bucket->h}, key {$bucket->key}, intKey {$bucket->intKey}, bucket next {$bucket->val->u2_next}");
    }

    protected function trace(string $message): void {
        $this->trace .= $message . PHP_EOL;
    }

    /**
     * @param $key
     * @return ZendString|int
     * @throws \Exception
     */
    private function bucketValue($key) {
        $this->ht->validateBucketSlot($key);
        /** @var Bucket $bucket */
        $bucket = $this->ht->arData[$key];
        $int = $bucket->val->value->lval;
        if ($int !== null) {
            $this->trace(" - bucketValue($key) returning int $int");
            return $int;
        }
        $this->trace(" - bucketValue($key) returning string " . $bucket->val->value->str->val);
        return $bucket->val->value->str->val;
    }

    /**
     * @param int $h
     * @return int|null
     * @throws \Exception
     */
    public function bucketSlot($h): ?int {
        $hashSlot = $h | $this->ht->nTableMask;
        $this->trace(" - bucketSlot($h) hashSlot $hashSlot");
        $this->ht->validateHashSlot($hashSlot);
        $bucketSlot = (int)$this->ht->arData[$hashSlot];
        $this->trace(" - bucketSlot($h) bucketSlot $bucketSlot");
        if ($bucketSlot === ZendTypes::HT_INVALID_IDX) {
            return null;
        }
        $this->ht->validateBucketSlot($bucketSlot);
        return $bucketSlot;
    }

    public function show(): array {
        $result = [];
        foreach ($this->ht->arData as $key => $value) {
            if (($key < 0) || ($value === null)) {
                continue;
            }
            /** @var Bucket $bucket */
            $bucket = $value;
            if ($bucket->val->u1_v_type !== ZendTypes::IS_UNDEF) {
                $theKey = ($bucket->key === null) ? $bucket->h : $bucket->key;
                $theValue = ($bucket->val->u1_v_type === ZendTypes::IS_STRING) ? $bucket->val->value->str->val :
                    $bucket->val->value->lval;
                $result[$theKey] = $theValue;
            }
        }
        return $result;
    }
}
