<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyUserPivot extends Model
{
    use HasFactory;

    protected $table = 'company_user_pivot';

    public $timestamps = false;
}
