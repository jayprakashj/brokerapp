<?php

namespace App\Models\Relations;

trait OwnerUserRelation {


    public function ownerUser (){
        return $this->belongsTo( User::class, 'user_id', 'id');
    }

}
