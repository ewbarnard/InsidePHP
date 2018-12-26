<?php

namespace App\ZendEngine3\Hashtable;

abstract class Injectable {
    public $eventTrace = '';

    public function __construct(array $dependencies = null) {
        $this->loadDependencies($dependencies);
    }

    protected function loadDependencies(array $dependencies = null): void {
        if (!\is_array($dependencies)) {
            return;
        }
        $class = static::class;
        foreach ($dependencies as $property => $value) {
            if (\property_exists($class, $property)) {
                $this->$property = $value;
            }
        }
    }

    protected function trace(string $event): void {
        $this->eventTrace .= $event . \PHP_EOL;
    }
}
