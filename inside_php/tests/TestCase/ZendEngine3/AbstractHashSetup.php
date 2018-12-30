<?php

namespace App\ZendEngine3;

use App\ZendEngine3\ZendTypes\Bucket;
use App\ZendEngine3\ZendTypes\HashTable;
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

    /** @var HashTable */
    protected $ht;
    /** @var callable */
    protected $func;

    public function setUp() {
        $this->ht = new HashTable();
        $this->func = function () {
        };
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

    public function show(): array {
       // $trace = '';
        $result = [];
        foreach ($this->ht->arData as $key => $value) {
            if (($key < 0) || ($value === null)) {
                continue;
            }
            /** @var Bucket $bucket */
            $bucket = $value;
            //$trace .= "key $key, value type: ". $bucket->val->u1_v_type.PHP_EOL;
            if ($bucket->val->u1_v_type !== ZendTypes::IS_UNDEF) {
                $theKey = ($bucket->key === null) ? $bucket->h : $bucket->key;
                $theValue = ($bucket->val->u1_v_type === ZendTypes::IS_STRING) ? $bucket->val->value->str :
                    $bucket->val->value->lval;
                $result[$theKey] = $theValue;
                //$trace .= " - $theKey => $theValue".PHP_EOL;
            }
        }
        //$result['trace'] = $trace;
        return $result;
    }
}
