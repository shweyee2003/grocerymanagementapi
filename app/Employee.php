<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
        protected $fillable = [
        'empe_name', 'nrcno','date_of_birth','phone','address','effective_date','basic_salary','remark','empe_image'
    ];
}
