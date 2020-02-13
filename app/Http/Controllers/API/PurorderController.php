<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Purorders;
use App\Purorderdtls;
use Validator;

class PurorderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purorders = Purorders::join("purorderdtls","purorderdtls.purhdr_id","=","purorders.id")
		            //->join("warehouses","products.warehouse_id","=","warehouses.id")
					//->join("Prodformulars","products.formular_id","=","Prodformulars.id")
					->paginate(5, array("purorders.*","purorderdtls.*"));
        $data = $purorders->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Purchaseorder retrieved successfully.'
        ];

        return response()->json($response, 200);
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
            'pur_date' => 'required',
			'pur_amt' => 'required|integer|not_in:0'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $purorders = Purorders::create($input);
        $data = $purorders->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Product  stored successfully.'
        ];

        return response()->json($response, 200);
    }
	    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storepurordrdtls(Request $request)
    {
		$input = $request->all();
		$purdtldata = $input['purorderdtls'];
		$subject_count=count($purdtldata);
		
	
		for($i=0; $i < $subject_count; $i++){
			$validator = Validator::make($input, [
				'product_id' => 'required',
				'supr_id' => 'required',
				'prod_qnty' => 'required|integer|not_in:0',
				'prod_price' => 'required|integer|not_in:0'
			]);
			

			if ($validator->fails()) {
				$response = [
					'success' => false,
					'data' => 'Validation Error.',
					'message' => $validator->errors()
				];
				return response()->json($response, 404);
			}
			$pur_amt=$purdtldata[$i]['prod_qnty']*$purdtldata[$i]['prod_price'];
			$purorderdtls =Purorderdtls::create([
				"purhdr_id" => $purdtldata[$i]['purhdr_id'],
				"product_id" => $purdtldata[$i]['product_id'],
				"supr_id"    => $purdtldata[$i]['supr_id'],
				"prod_qnty"  => $purdtldata[$i]['prod_qnty'],  // since you are using passport
				"prod_price" => $purdtldata[$i]['prod_price'],
				"prod_amt" => $pur_amt
		    ]);
		}
		$data = $purorderdtls->toArray();
		$response = [
            'success' => true,
            'data' => $data,
			'pur_amt'=>$pur_amt,
			'message' => 'Product  stored successfully.'
        ];
		 return response()->json($response, 200);
    }
	
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		
		$purorders = Purorders::find($id);
        $data = $purorders->toArray();

        if (is_null($purorders)) {
            $response = [
                'success' => false,
                'data' => 'Empty',
                'message' => 'Purchase Order  not found.'
            ];
            return response()->json($response, 404);
        }

		$purorderdtls =  Purorderdtls::where('purorderdtls.purhdr_id','=',$id)
            ->join("products","purorderdtls.product_id","=","products.id")
			->join("suppliers","purorderdtls.supr_id","=","suppliers.id")
			->select("purorderdtls.*","products.prodcut_code","products.prodcut_name","suppliers.supr_name")
			->get();
			
		$datadtl = $purorderdtls->toArray();

        	
			
        $response = [
            'success' => true,
            'data' => $data,
			'datadtl'=>$datadtl,
            'message' => 'Purchase Order  retrieved successfully.'
        ];

        return response()->json($response, 200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purorders $purorders)
    {
        $input = $request->all();
		
		$validator = Validator::make($input, [
            'pur_date' => 'required',
			'pur_amt' => 'required|integer|not_in:0'
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
		$purorders->pur_date  = $input['pur_date'];
		$purorders->pur_amt  = $input['pur_amt'];
		$purorders->save();

        $data = $purorders->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Purchase Order updated successfully.'
        ];

        return response()->json($response, 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatedtls(Request $request, Purorderdtls $purorderdtls)
    {
        $input = $request->all();
		$purdtldata = $input['purorderdtls'];
		$subject_count=count($purdtldata);
		
	
		for($i=0; $i < $subject_count; $i++){
			$validator = Validator::make($input, [
					'product_id' => 'required',
					'supr_id' => 'required',
					'prod_qnty' => 'required|integer|not_in:0',
					'prod_price' => 'required|integer|not_in:0'
				]);
				

			if ($validator->fails()) {
				$response = [
					'success' => false,
					'data' => 'Validation Error.',
					'message' => $validator->errors()
				];
				return response()->json($response, 404);
			}   

			$pur_amt=$purdtldata[$i]['prod_qnty']*$purdtldata[$i]['prod_price'];
				
			$purorderdtls->purhdr_id  = $purdtldata[$i]['purhdr_id'];
			$purorderdtls->product_id  = $purdtldata[$i]['product_id'];
			$purorderdtls->supr_id  = $purdtldata[$i]['supr_id'];
			$purorderdtls->prod_qnty  = $purdtldata[$i]['prod_qnty'];
			$purorderdtls->prod_price  = $purdtldata[$i]['prod_price'];
			$purorderdtls->prod_amt  = $pur_amt;
			$purorderdtls->save();
		}
        $data = $purorderdtls->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Purchase Order updated successfully.'
        ];

        return response()->json($response, 200);

    }	
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purorders $purorders,Purorderdtls $purorderdtls)
    {
        $purorders->delete();
        $data = $purorders->toArray();
		
		$purorderdtls->delete();
        $datadtl = $purorderdtls->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Purchase Order deleted successfully.'
        ];

        return response()->json($response, 200);
    }
}
