<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SpatiePermission extends Permission
{

    public function scopeExceptDefaultPermission ( $q ) {
        return $q->whereNotIn( 'group_name', ['Company']);
    }

    public function subPermissions () {
        return $this->hasMany( self::class, 'group_name', 'group_name');
    }

    public function scopeGlobalPermissions ( $q ) {

        return $q->whereRelation( 'roles', auth()->user()->globeRole );
    }
}
