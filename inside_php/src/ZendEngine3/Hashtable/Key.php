<?php

namespace App\ZendEngine3\Hashtable;

class Key extends Injectable {
    /** @var int|string */
    private $key;
    /** @var int */
    private $isIntegerKey;
    private $largestIntegerKey = -1;

    public function fullHash(): int {
        return $this->isIntegerKey ? $this->key : \crc32($this->key);
    }

    /**
     * @return int|string
     */
    public function currentKey() {
        return $this->key;
    }

    public function stringKey(): ?string {
        return $this->isIntegerKey ? null : $this->key;
    }

    /**
     * @param mixed $key
     */
    public function determineKey($key): void {
        $this->buildKey($key);
        $this->updateLargestKey();
    }

    /**
     * @param $key
     */
    private function buildKey($key): void {
        if ($key === null) {
            $this->key = $this->autoKey();
            $this->isIntegerKey = 1;
        } else {
            $this->isIntegerKey = $this->isIntegerKey($key);
            $this->key = $this->isIntegerKey ? (int)$key : (string)$key;
        }
    }

    /**
     * One higher than highest-used integer key
     *
     * @return int
     */
    private function autoKey(): int {
        return ++$this->largestIntegerKey;
    }

    /**
     * Simplified key casting
     *   See http://php.net/manual/en/language.types.array.php for the
     *   full set of rules
     *
     * @param mixed $key
     * @return int
     */
    private function isIntegerKey($key): int {
        if (!\is_numeric($key)) {
            $this->trace("Key $key is not numeric");
            return 0;
        }
        $intKey = (int)$key;
        $stringKey = (string)$key;
        if ((string)$intKey === $stringKey) {
            $this->trace("Key $key is integer");
            return 1;
        }
        $this->trace("Key $key is not integer");
        return 0;
    }

    private function updateLargestKey(): void {
        if ($this->isIntegerKey && ($this->key > $this->largestIntegerKey)) {
            $this->largestIntegerKey = $this->key;
        }
    }
}
