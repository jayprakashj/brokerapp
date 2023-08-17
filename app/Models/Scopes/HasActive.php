<?php

namespace App\Models\Scopes;


trait HasActive {

    static $STATUS_ACTIVE = 1;
    static $STATUS_INACTIVE = 0;

    static $STATUSES = [
        1 => 'Active',
        0 => 'Inactive',
    ];

    /**
     * isActive
     *
     * @param [type] $q
     * @return void
     */
    public function scopeIsActive ( $q, $boolean = 'and' ) {
        return $q->where( 'status', self::$STATUS_ACTIVE, $boolean );
    }

    public function isActive(){
        return $this->status == self::$STATUS_ACTIVE;
    }
}
