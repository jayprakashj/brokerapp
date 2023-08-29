<?php

namespace App\Models\Relations;

use App\Models\User;

trait CreatedUpdatedUserRelation {

    public function createdUser (){
        return $this->belongsTo( User::class, 'created_by', 'id');
    }

    public function updatedUser (){
        return $this->belongsTo( User::class, 'updated_by', 'id');
    }

}
