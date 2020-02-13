<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
	protected $fillable = [
        'formular_id','prodtype_id','product_code','product_name','from_product','remark','min_qnty','prod_image'
    ];
	
   public function producttypes()
   {
      $this->belongsTo('App\Producttype','prodtype_id','id');
   }
   
   	public function Prodformular()
   {
       $this->belongsTo('App\Prodformular','formular_id','id');
   }
   
    public function Products()
   {
      $this->hasMany('App\Products','product_id','id');
   }
}
