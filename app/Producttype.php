<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producttype extends Model
{
    //
	protected $fillable = [
        'category_id','ptype_name'
    ];
	
	public function Categories()
   {
       $this->belongsTo('App\Category','category_id','id');
   }

}
