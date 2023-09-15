<?php

namespace App\Models\Relations;

use App\Models\User;

trait OwnerUserRelation {


    public function ownerUser (){
        return $this->belongsTo( User::class, 'user_id', 'id');
    }

}
