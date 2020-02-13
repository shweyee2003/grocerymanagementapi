<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Supplier;
use Illuminate\Http\Request;
use Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$suppliers = Supplier::paginate(5);
        $data = $suppliers->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Supplier retrieved successfully.'
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
            'supr_name' => 'required',
			'phone' => 'required',
           
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $supplier = Supplier::create($input);
        $data = $supplier->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Supplier stored successfully.'
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier = Supplier::find($id);
        $data = $supplier->toArray();

        if (is_null($supplier)) {
            $response = [
                'success' => false,
                'data' => 'Empty',
                'message' => 'Supplier not found.'
            ];
            return response()->json($response, 404);
        }


        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Supplier retrieved successfully.'
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'supr_name' => 'required',
			'phone' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }
		
        $supplier->supr_name = $input['supr_name'];
		$supplier->phone = $input['phone'];
        $supplier->address = $input['address'];
		$supplier->email= $input['email'];
		$supplier->remark= $input['remark'];
        $supplier->save();

        $data = $supplier->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Supplier updated successfully.'
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        $data = $supplier->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Supplier deleted successfully.'
        ];

        return response()->json($response, 200);
    }
}
