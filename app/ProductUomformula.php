<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductUomformula extends Model
{
    protected $fillable = [
        'producttype_id','UOM','qnty_formula','equality_UOM'
    ];
	
	public function Producttypes()
	{
       $this->belongsTo('App\Producttype','producttype_id','id');
	}
}
