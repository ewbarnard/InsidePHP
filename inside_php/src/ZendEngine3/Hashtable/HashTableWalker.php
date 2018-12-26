<?php

namespace App\ZendEngine3\Hashtable;

class HashTableWalker extends Injectable {
    /** @var HashTable */
    protected $hashtable;
    /** @var Key */
    protected $key;

    /** @var int */
    private $fullHash;
    /** @var int */
    private $maskedHash;
    /** @var Bucket|null */
    private $priorBucket;
    /** @var int|string */
    private $currentKey;
    /** @var Bucket */
    private $bucket;
    /** @var int|string */
    private $bucketKey;
    /** @var int|null */
    private $bucketNext;

    /** @var int */
    private $collisionChainHead;

    /**
     * @param int $fullHash
     * @param int $maskedHash
     * @return bool
     * @throws \Exception
     */
    public function unsetExistingKey(int $fullHash, int $maskedHash): bool {
        $this->fullHash = $fullHash;
        $this->maskedHash = $maskedHash;
        $this->priorBucket = null;
        $this->currentKey = $this->key->currentKey();
        $this->trace(__FUNCTION__.": hash $fullHash, $maskedHash, key {$this->currentKey}");

        $this->findCollisionChainHead();
        if ($this->isInvalidSlot($this->collisionChainHead)) {
            return false; // No match
        }

        $this->setBucketInfo($this->collisionChainHead);
        $found = $this->walkCollisionChain();
        if ($found) {
            $this->removeFromCollisionChain();
        }
        return $found;
    }

    private function findCollisionChainHead(): void {
        $this->collisionChainHead = $this->hashtable->arHash[$this->maskedHash];
    }

    private function isInvalidSlot(int $slot): bool {
        return ($slot === HashTable::HT_INVALID_IDX);
    }

    /**
     * @param int $slot
     * @throws \Exception
     */
    private function setBucketInfo(int $slot): void {
        $this->bucket = $this->hashtable->arData[$slot];
        if (!$this->bucket) {
            throw new \Exception("Invalid bucket at slot $slot");
        }
        $this->bucketKey = $this->bucket->originalKey();
        $this->bucketNext = $this->bucket->next();
    }

    /**
     * @throws \Exception
     */
    private function walkCollisionChain(): bool {
        while ($this->bucketKey !== $this->currentKey) {
            if ($this->bucketNext === null) {
                return false; // No match
            }

            $this->priorBucket = $this->bucket;
            $this->setBucketInfo($this->bucketNext);
        }
        return true;
    }

    /**
     * We have an existing item with this PHP-array key. Unset it.
     * We know its position as a result of walking the collision chain.
     */
    private function removeFromCollisionChain(): void {
        if ($this->atChainHead()) {
            // Hash map points to this slot
            if ($this->atChainEnd()) {
                // No collisions, just the one item
                $this->unsetLoneItem();
            } else {
                // At head of multi-zval collision chain
                $this->unsetChainHead();
            }
        } else {
            // We are somewhere down the zval collision chain, which
            // means there is a prior zval pointing to us
            if ($this->atChainEnd()) {
                // At chain end; chop it off
                $this->truncateChain();
            } else {
                // In chain middle; link my previous to my next
                $this->spliceChain();
            }
        }

        // Invalidate the item itself (invalidate the zval)
        $this->bucket->unset();
    }

    private function atChainHead(): bool {
        return !$this->priorBucket;
    }

    private function atChainEnd(): bool {
        return !$this->bucketNext;
    }

    /**
     * We are unsetting a lone zval. The hash table points to it directly,
     * rather than being part of a chain from zval to zval. Just unset the
     * hash table pointer; we'll invalidate the zval in the calling method.
     */
    private function unsetLoneItem(): void {
        $this->hashtable->arHash[$this->maskedHash] = HashTable::HT_INVALID_IDX;
    }

    /**
     * The hash table points to this zval, but it is the head of a chain
     * from this zval to the next. Update the hash table to point to the
     * next zval. We'll invalidate this zval in the calling method.
     */
    private function unsetChainHead(): void {
        $this->hashtable->arHash[$this->maskedHash] = $this->bucketNext;
    }

    /**
     * This zval is the last (and not the first) in the collision chain.
     * Set the prior item's "next" pointer to null, thus ending the chain.
     * We'll invalidate this zval in the calling method.
     */
    private function truncateChain(): void {
        $this->priorBucket->unNext();
    }

    /**
     * Remove the current zval from the chain by linking the prior zval
     * to this zval's next. We'll invalidate this zval in the calling method.
     */
    private function spliceChain(): void {
        $this->priorBucket->setNext($this->bucketNext);
    }
}
