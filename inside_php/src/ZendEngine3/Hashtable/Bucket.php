<?php

namespace App\ZendEngine3\Hashtable;

use App\ZendEngine3\Structures\Zval;

/**
 * Class Bucket
 *
 * A Bucket is an entry in the hashtable, i.e., a PHP array element.
 *
 * Integer keys are stored in $h (the hash value) because the array
 * key and hash value are identical in this case. When the key is an
 * integer, $key is NULL.
 */
class Bucket {
    /** @var int The hashed key */
    public $h;
    /** @var string Array item's key (null for integer keys) */
    public $key;
    /** @var Zval Array item's value */
    public $val;

    /**
     * @return int|string
     */
    public function originalKey() {
        return ($this->key === null) ? $this->h : $this->key;
    }

    public function next(): ?int {
        return $this->val ? $this->val->next : null;
    }

    public function setNext(int $value): void {
        if ($this->val) {
            $this->val->setNext($value);
        }
    }

    public function unset(): void {
        if ($this->val) {
            $this->val->unlink();
        }
    }
}
