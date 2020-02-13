<?php

namespace App\Http\Controllers\API;

use App\ProductUomformula;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class ProductUomformulaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$ProductUomformula = ProductUomformula::paginate(5);
		$ProductUomformula = ProductUomformula::join("producttypes","product_uomformulas.producttype_id","=","producttypes.id")
			->paginate(5, array("product_uomformulas.*","producttypes.ptype_name as ptype_name"));
        $data = $ProductUomformula->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Product UOM retrieved successfully.'
        ];

        return response()->json($response, 200);
    }
	
	public function showproduombyptypeid($id)
	{
			
		$ProductUomformula = ProductUomformula::where('product_uomformulas.producttype_id','=',$id)
            ->join("producttypes","product_uomformulas.producttype_id","=","producttypes.id")
			->paginate(5, array("product_uomformulas.*","producttypes.ptype_name as ptype_name"));
			$data = $ProductUomformula->toArray();

			if (is_null($ProductUomformula)) {
				$response = [
					'success' => false,
					'data' => 'Empty',
					'message' => 'Selected Product UOM not found.'
				];
				return response()->json($response, 404);
			}

			$response = [
				'success' => true,
				'data' => $data,
				'message' => 'Selected Product UOM retrieved successfully.'
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
            'producttype_id' => 'required',
			'UOM' => 'required',
			'qnty_formula' => 'required',
			'equality_UOM' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $productuomformula = ProductUomformula::create($input);
        $data = $productuomformula->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Product formula stored successfully.'
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductUomformula  $productUomformula
     * @return \Illuminate\Http\Response
     */
    /*public function show(ProductUomformula $productUomformula)
    {
        //
    }*/
	
    /**
     * Display the specified resource.
     *
     * @param  \App\Producttype  $producttype
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productuomformula = Productuomformula::find($id);
        $data = $productuomformula->toArray();

        if (is_null($productuomformula)) {
            $response = [
                'success' => false,
                'data' => 'Empty',
                'message' => 'Product UOM Formula not found.'
            ];
            return response()->json($response, 404);
        }


        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Product UOM Formula retrieved successfully.'
        ];

        return response()->json($response, 200);
    }
	

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductUomformula  $productUomformula
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductUomformula $productUomformula)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductUomformula  $productUomformula
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductUomformula $productUomformula)
    {
        $input = $request->all();
		
        /*$validator = Validator::make($request->all(), [
            'producttype_id' => 'required',
			'UOM' => 'required',
			'qnty_formula' => 'required',
			'equality_UOM' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }*/
		
		if(isset($input['producttype_id']) && $input['producttype_id']!=1)
	{
			//echo $input['producttype_id'];
			
			/*if ( $request->isJson() ) {
				$productUomformula->producttype_id = json_decode(trim($request->input('producttype_id')),true);
				$productUomformula->UOM = json_decode(trim($request->input('UOM')),true);
				$productUomformula->qnty_formula  = json_decode(trim($request->input('qnty_formula')),true);
				$productUomformula->equality_UOM = json_decode(trim($request->input('equality_UOM')),true);
			}
			else
			{
				$productUomformula->producttype_id = json_decode(trim($request->input('producttype_id')),true);
				$productUomformula->UOM = json_decode(trim($request->input('UOM')),true);
				$productUomformula->qnty_formula  = json_decode(trim($request->input('qnty_formula')),true);
				$productUomformula->equality_UOM = json_decode(trim($request->input('equality_UOM')),true);
			}*/
			//$productUomformula->producttype_id=json_decode($input['producttype_id']);
			$productUomformula->producttype_id  = $input['producttype_id'];
		}
		if(isset($input['UOM']) && $input['UOM']!=1)
		{
			$productUomformula->UOM = $input['UOM'];
			
			
		}      
		if(isset($input['qnty_formula']) && $input['qnty_formula']!=1)
		{
			$productUomformula->qnty_formula  = $input['qnty_formula'];
			
		}
		if(isset($input['equality_UOM']) && $input['equality_UOM']!=1)
		{
			$productUomformula->equality_UOM = $input['equality_UOM'];
			
		}  		
		
		$productUomformula->save();

        $data = $productUomformula->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Product UOM updated successfully.'
        ];

        return response()->json($response, 200);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductUomformula  $productUomformula
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductUomformula $productUomformula)
    {
        $productUomformula->delete();
        $data = $productUomformula->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Product UOM deleted successfully.'
        ];

        return response()->json($response, 200);
    }
}
