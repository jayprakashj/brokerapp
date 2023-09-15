<?php

namespace App\Models\Relations;

use App\Models\Company;

trait CompanyRelation {

    public function company (){
        return $this->belongsTo( Company::class, 'company_id', 'id');
    }

    public function currentDefaultCompany (){
        return $this->company()->filterCurrentDefaultCompany();
    }

}
