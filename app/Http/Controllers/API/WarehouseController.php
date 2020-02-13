<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Warehouse;
use Validator;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouses = Warehouse::paginate(5);
        $data = $warehouses->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Warehouses retrieved successfully.'
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
            'warehouse_name' => 'required',
			'location' => 'required',
			'available_qnty' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $warehouse = Warehouse::create($input);
        $data = $warehouse->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Warehouse stored successfully.'
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
        $warehouse = Warehouse::find($id);
        $data = $warehouse->toArray();

        if (is_null($warehouse)) {
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
            'message' => 'Warehouse retrieved successfully.'
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
   public function update(Request $request, Warehouse $warehouse)
	//public function update(Request $request,$id)
    {
       $input = $request->all();
		//$input = Warehouse::find($id);
        $validator = Validator::make($input, [
            'warehouse_name' => 'required',
			'location' => 'required',
			'available_qnty' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }
		
        $warehouse->warehouse_name  = $request->warehouse_name;
		$warehouse->location  = $request->location;
		$warehouse->available_qnty=$request->available_qnty;
		$warehouse->save();

        $data = $warehouse->toArray();

        $response = [
            'success' => true,
            'data' => $data,
			'message' => 'Warehouse updated successfully.'
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Warehouse $warehouse)
    {
        $warehouse->delete();
        $data = $warehouse->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Warehouse deleted successfully.'
        ];

        return response()->json($response, 200);

    }
}
