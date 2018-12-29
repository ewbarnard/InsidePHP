<?php

namespace App\ZendEngine3\ZendTypes;

/**
 * Class ZvalStruct
 *
 * @package App\ZendEngine3\ZendTypes
 *
 * Zend/zend_types.h line 182
 */
class ZvalStruct {
    /** @var \App\ZendEngine3\ZendTypes\ZendValue Value */
    public $value;
    /** @var int Active type */
    public $u1_v_type;
    /** @var int */
    public $u1_v_type_flags;
    /** @var int Call info for EX(This) */
    public $u1_v_u_call_info;
    /** @var int Not further specified */
    public $u1_v_u_extra;
    /** @var int */
    public $u1_type_info;
    /** @var int Hash collision chain as arData index */
    public $u2_next;
    /** @var int Cache slot (for RECV_INIT) */
    public $u2_cache_slot;
    /** @var int Opline number (for FAST CALL) */
    public $u2_opline_num;
    /** @var int Line number (for ast nodes) */
    public $u2_lineno;
    /** @var int Arguments number for EX(This) */
    public $u2_num_args;
    /** @var int Foreach position */
    public $u2_fe_pos;
    /** @var int Foreach iterator index */
    public $u2_fe_iter_idx;
    /** @var int Class constant access flags */
    public $u2_access_flags;
    /** @var int Single property guard */
    public $u2_property_guard;
    /** @var int Constant flags */
    public $u2_constant_flags;
    /** @var int Not further specified */
    public $u2_extra;
}
