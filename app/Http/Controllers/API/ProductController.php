<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$Products = Product::join("producttypes","products.prodtype_id","=","producttypes.id")
		            //->join("warehouses","products.warehouse_id","=","warehouses.id")
					//->join("Prodformulars","products.formular_id","=","Prodformulars.id")
					->paginate(5, array("products.*","producttypes.ptype_name as ptype_name"));
        $data = $Products->toArray();

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
            'prodtype_id' => 'required',
			'product_code' => 'required',
			'product_name' => 'required',
			'from_product' => 'required',
			'min_qnty' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $product = Product::create($input);
        $data = $product->toArray();

        $response = [
            'success' => true,
            'data' => $data,
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
		$product =  Product::where('products.id','=',$id)
            ->join("producttypes","products.prodtype_id","=","producttypes.id")
			->select("products.*","products.id as prod_id","producttypes.category_id")
			->get();
			/*$product = Product::find($id);*/
        $data = $product->toArray();

        if (is_null($product)) {
            $response = [
                'success' => false,
                'data' => 'Empty',
                'message' => 'Product  not found.'
            ];
            return response()->json($response, 404);
        }


        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Product  retrieved successfully.'
        ];

        return response()->json($response, 200);
    }
	
	public function showprodbyid($id)
	{
			
		$product = Product::where('products.prodtype_id','=',$id)
            ->join("producttypes","products.prodtype_id","=","producttypes.id")
			->join("categories","producttypes.category_id","=","categories.id")
			->paginate(5, array("products.*","producttypes.ptype_name as producttype_name","categories.category_name as category_name"));
			
			
			$data = $product->toArray();

			if (is_null($product)) {
				$response = [
					'success' => false,
					'data' => 'Empty',
					'message' => 'Selected Product not found.'
				];
				return response()->json($response, 404);
			}

			$response = [
				'success' => true,
				'data' => $data,
				'message' => 'Selected Product  retrieved successfully.'
			];

			return response()->json($response, 200);
	}	

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function update(Request $request, $id)
	public function update(Request $request, Product $product)
    {
        $input = $request->all();
		
        $validator = Validator::make($input, [
            'prodtype_id' => 'required',
			'product_code' => 'required',
			'product_name' => 'required',
			'from_product' => 'required',
			'remark' => 'required',
			'min_qnty' => 'required'			
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
		$product->prodtype_id  = $input['prodtype_id'];
		$product->product_code  = $input['product_code'];
		$product->product_name  = $input['product_name'];
		$product->from_product  = $input['from_product'];
		$product->remark  = $input['remark'];
		$product->min_qnty  = $input['min_qnty'];
		$product->save();

        $data = $product->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Product updated successfully.'
        ];

        return response()->json($response, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function destroy($id)
	public function destroy(Product $product)
    {
        $product->delete();
        $data = $product->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Product deleted successfully.'
        ];

        return response()->json($response, 200);
    }
}
