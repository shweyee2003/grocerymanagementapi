<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Producttype;
use Validator;

class ProducttypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //  $Producttypes = Producttype::paginate(5);
		$Producttypes = Producttype::join("categories","producttypes.category_id","=","categories.id")
			->paginate(5, array("producttypes.*","categories.category_name as category_name"));
        $data = $Producttypes->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Product Type retrieved successfully.'
        ];

        return response()->json($response, 200);

    }

	public function showproducttype()
    {
      //  $Producttypes = Producttype::paginate(5);
		$Producttypes = Producttype::join("categories","producttypes.category_id","=","categories.id")
			->select("producttypes.*","categories.category_name as category_name")
			->get();
        $data = $Producttypes->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Product Type retrieved successfully.'
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
            'category_id' => 'required',
			'ptype_name' => 'required'
			
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $producttype = Producttype::create($input);
        $data = $producttype->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Product Type stored successfully.'
        ];

        return response()->json($response, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Producttype  $producttype
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producttype = Producttype::find($id);
        $data = $producttype->toArray();

        if (is_null($producttype)) {
            $response = [
                'success' => false,
                'data' => 'Empty',
                'message' => 'Product Type not found.'
            ];
            return response()->json($response, 404);
        }


        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Product Type retrieved successfully.'
        ];

        return response()->json($response, 200);
    }
	
	public function showprodtypebyid($id)
	{
			
		$producttype = Producttype::where('producttypes.category_id','=',$id)
            ->join("categories","producttypes.category_id","=","categories.id")
			->paginate(5, array("producttypes.*","categories.category_name as category_name"));
			$data = $producttype->toArray();

			if (is_null($producttype)) {
				$response = [
					'success' => false,
					'data' => 'Empty',
					'message' => 'Selected Product Type not found.'
				];
				return response()->json($response, 404);
			}

			$response = [
				'success' => true,
				'data' => $data,
				'message' => 'Selected Product Type retrieved successfully.'
			];

			return response()->json($response, 200);
	}
	
	public function showptypebycatid($id)
	{
			
		$producttype = Producttype::where('producttypes.category_id','=',$id)
            ->join("categories","producttypes.category_id","=","categories.id")
			->select("producttypes.*","categories.category_name as category_name")
			->get();
			$data = $producttype->toArray();

			if (is_null($producttype)) {
				$response = [
					'success' => false,
					'data' => 'Empty',
					'message' => 'Selected Product Type not found.'
				];
				return response()->json($response, 404);
			}

			$response = [
				'success' => true,
				'data' => $data,
				'message' => 'Selected Product Type retrieved successfully.'
			];

			return response()->json($response, 200);
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Producttype  $producttype
     * @return \Illuminate\Http\Response
     */
    public function edit(Producttype $producttype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Producttype  $producttype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producttype $producttype)
    {
        $input = $request->all();
		
        /*$validator = Validator::make($input, [
            'category_id ' => 'required',
			'ptype_name' => 'required'
			
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }*/
		if(isset($input['category_id']) && $input['category_id']!=1)
		{
			$producttype->category_id  = $input['category_id'];
		}
		if(isset($input['ptype_name']) && $input['ptype_name']!=1)
		{
			$producttype->ptype_name = $input['ptype_name'];
		}        
		
		$producttype->save();

        $data = $producttype->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Product Type updated successfully.'
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Producttype  $producttype
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producttype $producttype)
    {
        $producttype->delete();
        $data = $producttype->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Product Type deleted successfully.'
        ];

        return response()->json($response, 200);
    }
}
