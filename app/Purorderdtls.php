<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purorderdtls extends Model
{
    //
	//protected $table = 'purorderdtls';
	
	protected $fillable = ['purhdr_id','product_id','supr_id','prod_qnty','prod_price','prod_amt'];
	
	public function Purorders()
   {
      $this->belongsTo('App\Purorders','purhdr_id','id');
   }
   
   	public function Products()
   {
      $this->belongsTo('App\Products','product_id','id');
   }
   
    public function Supplier()
   {
      $this->belongsTo('App\Suppliers','supr_id','id');
   }
}
