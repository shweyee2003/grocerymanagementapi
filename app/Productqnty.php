<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productqnty extends Model
{
    //
	protected $fillable = ['product_id','pur_date','warehouse_id','prod_qnty','initial_qnty'];
	
	public function Products()
   {
      $this->belongsTo('App\Products','product_id','id');
   }
   
    public function Warehouses()
   {
      $this->belongsTo('App\Warehouse','warehouse_id','id');
   }
}
