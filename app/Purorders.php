<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purorders extends Model
{
    //
	protected $table = 'purorders';
	
	 protected $fillable = ['pur_date','pur_amt'];
	 
	  public function Purorders()
    {
        return $this->hasMany('App\Purorders', 'purhdr_id', 'id');
    }
}
