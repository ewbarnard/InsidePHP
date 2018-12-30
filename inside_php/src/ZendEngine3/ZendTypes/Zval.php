<?php

namespace App\ZendEngine3\ZendTypes;
/**
 * Class Zval
 *
 * @package App\ZendEngine3\ZendTypes
 *
 * Zend/zend_types.h line 87
 */
class Zval extends ZvalStruct {

    public function __construct() {
        $this->u1_v_type = ZendTypes::IS_UNDEF;
        $this->value = new ZendValue();
    }

    public static function COPY_VALUE(Zval $destination, Zval $source): void {
        $destination->value = $source->value;
        $destination->u1_v_type = $source->u1_v_type;
        $destination->u2_next = $source->u2_next;
    }

    public function invalidate(): void {
        $this->u1_v_type = ZendTypes::IS_UNDEF;
        $this->u2_next = null;
    }

    /**
     * @param int|null $value
     */
    public function setNext($value): void {
        $this->u2_next = $value;
    }

}
