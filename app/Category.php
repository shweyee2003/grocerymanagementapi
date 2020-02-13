<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
	protected $fillable = [
        'category_name'
    ];
	
	//return $this->hasMany('App\Producttype');
	public function producttypes()
   {
       return $this->hasMany('App\Producttype','category_id','id');
	   
   }
}
