<?php

namespace App\Shell;

use App\ZendEngine3\Structures\Zval;
use App\ZendEngine3\Hashtable\SimulateArray;
use Cake\Console\Shell;

class SimulateArrayShell extends Shell {
    private static $example01 = [
        ['key' => 'foo', 'value' => 0, 'type' => Zval::IS_LONG],
        ['key' => 'bar', 'value' => 1, 'type' => Zval::IS_LONG],
        ['key' => 0, 'value' => 2, 'type' => Zval::IS_LONG],
        ['key' => 'xyz', 'value' => 3, 'type' => Zval::IS_LONG],
        ['key' => 2, 'value' => 4, 'type' => Zval::IS_LONG],
        ['value' => 5, 'type' => Zval::IS_LONG],
    ];
    public function main(...$args) {
        try {
            $sim = new SimulateArray(static::$example01);
            $sim->insert('bar', 3, Zval::IS_LONG);
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
        print_r(['example01' => $sim]);
    }
}
