<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Productqnty;
use Validator;

class ProductqntyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productqnty = Productqnty::join("products","productqnties.product_id","=","products.id")
		            ->join("warehouses","productqnties.warehouse_id","=","warehouses.id")
					//->join("products","products.formular_id","=","Prodformulars.id")
					->paginate(5, array("productqnties.*","products.product_code","products.product_name","warehouses.warehouse_name"));
        $data = $productqnty->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Product retrieved successfully.'
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'product_id' => 'required',
			'pur_date' => 'required',
			'warehouse_id' => 'required',
			'prod_qnty' => 'required|integer|not_in:0',
			'initial_qnty' => 'required|integer|not_in:0'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => $input,//'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

       // $Productqnty = Productqnty::create($input);
		$Productqnty =Productqnty::create([
				"product_id" => $request->product_id,
				"pur_date" => $request->pur_date,
				"warehouse_id"    => $request->warehouse_id,
				"prod_qnty"  => $request->prod_qnty,  // since you are using passport
				"initial_qnty" => $request->initial_qnty
		 ]);
        $data = $Productqnty->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Productqnty stored successfully.'
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Productqnty  $productqnty
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$productqnty =  Productqnty::where('productqnties.product_id','=',$id)
					->join("products","productqnties.product_id ","=","products.id")
		            ->join("warehouses","productqnties.warehouse_id","=","warehouses.id")
					->select("productqnties.*","products.product_code","products.product_name","warehouses.warehouse_name")
					->get();
			/*$product = Product::find($id);*/
        $data = $productqnty->toArray();

        if (is_null($productqnty)) {
            $response = [
                'success' => false,
                'data' => 'Empty',
                'message' => 'Warehouse not found.'
            ];
            return response()->json($response, 404);
        }


        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Product Qnty retrieved successfully.'
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Productqnty  $productqnty
     * @return \Illuminate\Http\Response
     */
    public function edit(Productqnty $productqnty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Productqnty  $productqnty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Productqnty $productqnty)
	//public function update($id)
    {
        $input = $request->all();
		
		$validator = Validator::make($input, [
            'product_id' => 'required',
			'pur_date' => 'required',
			'fwarehouse_id' => 'required',
			'prod_qnty' => 'required|integer|not_in:0',
			'initial_qnty' => 'required|integer|not_in:0'
        ]);
        

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }
		/*if(isset($input['category_id']) && $input['category_id']!=1)
		{
			$producttype->category_id  = $input['category_id'];
		}
		if(isset($input['ptype_name']) && $input['ptype_name']!=1)
		{
			$producttype->ptype_name = $input['ptype_name'];
		} */
		if ($request->Trasaction_type=="T")
		{
			$obj=Productqnty::where('product_id','=',$request->product_id)
						->where('warehouse_id','=',$request->warehouse_id)
						->where('initial_qnty','=',$request->initial_qnty)
						->where('pur_date','=',$request->pur_date)
						->get();
			$tsubject_count=count($obj);
		
			if($tsubject_count==0)
			{
				 $this->store($request);
			}
			else{
				for($i=0; $i < $tsubject_count; $i++){	
				
					$prodqnty=$obj[$i]['prod_qnty']+$request->prod_qnty;				
					$updateqnty=Productqnty::where('product_id','=',$request->product_id)
									->where('warehouse_id','=',$request->warehouse_id)
									->where('initial_qnty','=',$request->initial_qnty)
									->where('pur_date','=',$request->pur_date)
									->update(['prod_qnty'=>$prodqnty]);			
				}	
			}
			
		}
		
		$obj=Productqnty::where('product_id','=',$request->product_id)
						->where('warehouse_id','=',$request->fwarehouse_id)
						->where('initial_qnty','=',$request->initial_qnty)
						->where('pur_date','=',$request->pur_date)
						->get();
						//->update(['prod_qnty'=>'value'])
		$subject_count=count($obj);
		
	
		for($i=0; $i < $subject_count; $i++){	
			
			$prodqnty=$obj[$i]['prod_qnty']-$request->prod_qnty;				
			$updateqnty=Productqnty::where('product_id','=',$request->product_id)
							->where('warehouse_id','=',$request->fwarehouse_id)
							->where('initial_qnty','=',$request->initial_qnty)
							->where('pur_date','=',$request->pur_date)
							->update(['prod_qnty'=>$prodqnty]);
		}				
		//$purorders->pur_date  = $input['pur_date'];
		//$purorders->pur_amt  = $input['pur_amt'];
		//$purorders->save();

        //$data = $purorders->toArray();*/

        $response = [
            'success' => true,
            'data' => $obj,
			'request' => $updateqnty,
			'Productqnty' => $input,
            'message' => 'Product Qnty updated successfully.'
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Productqnty  $productqnty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Productqnty $productqnty)
    {
        //
    }
}
