<?php

namespace App\OldZendEngine3\Hashtable;

class SimulateArray extends Injectable {
    /** @var HashTable */
    protected $hashTable;

    /**
     * SimulateArray constructor.
     *
     * @param array|null $init
     * @param array|null $dependencies
     * @throws \Exception
     */
    public function __construct(array $init = null, array $dependencies = null) {
        parent::__construct($dependencies);
        $this->initializeProperties();
        if (\is_array($init)) {
            $this->initializeSimulatedArray($init);
        }
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @param int $type
     * @throws \Exception
     */
    public function insert($key, $value, int $type): void {
        $this->hashTable->insertElement($key, $value, $type);
    }

    private function initializeProperties(): void {
        if (!$this->hashTable) {
            $this->hashTable = new HashTable();
        }
    }

    /**
     * @param array $init
     * @throws \Exception
     */
    private function initializeSimulatedArray(array $init): void {
        foreach ($init as $row) {
            $key = \array_key_exists('key', $row) ? $row['key'] : null;
            $this->hashTable->insertElement($key, $row['value'], $row['type']);
        }
    }
}
