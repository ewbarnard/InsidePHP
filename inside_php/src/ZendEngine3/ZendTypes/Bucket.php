<?php

namespace App\ZendEngine3\ZendTypes;

/**
 * Class Bucket
 *
 * @package App\ZendEngine3\ZendTypes
 *
 * Zend/zend_types.h line 229
 *
 * A Bucket is an entry in the hashtable. It occupies one slot in arData.
 * However, in our PHP implementation, arData is an array of pointers to Buckets.
 *
 * Integer keys are stored in $h (the hash value) because the array key and
 * hash value are identical in this case. When the key is an integer, $key is NULL.
 */
class Bucket {
    /** @var Zval The array element's value */
    public $val;

    /** @var int The hashed key - hash value or numeric index */
    public $h;

    /** @var ZendString The array element's key, when the key is a string (null for integer keys) */
    public $key;


    /**
     * @return int|string
     */
    public function originalKey() {
        return ($this->key === null) ? $this->h : $this->key;
    }

    public function next(): ?int {
        return $this->val ? $this->val->u2_next : null;
    }

    public function setNext(int $value): void {
        if ($this->val) {
            $this->val->setNext($value);
        }
    }

    public function unset(): void {
        if ($this->val) {
            $this->val->invalidate();
        }
    }

}
