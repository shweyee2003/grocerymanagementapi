<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;
use Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $customers = Customer::all();
		$customers = Customer::paginate(5);
        $data = $customers->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Customer retrieved successfully.'
        ];

        return response()->json($response, 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'first_name' => 'required',
			'cust_saletype' => 'required',
            'address' => 'required',
			'cust_type' => 'required',
			
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $customer = Customer::create($input);
        $data = $customer->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Customer stored successfully.'
        ];

        return response()->json($response, 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        $data = $customer->toArray();

        if (is_null($customer)) {
            $response = [
                'success' => false,
                'data' => 'Empty',
                'message' => 'Customer not found.'
            ];
            return response()->json($response, 404);
        }


        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Customer retrieved successfully.'
        ];

        return response()->json($response, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'first_name' => 'required',
			'last_name' => 'required',
			'address' => 'required',
			'cust_type' => 'required',
			'cust_saletype' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }
		
        $customer->first_name = $input['first_name'];
		$customer->last_name = $input['last_name'];
        $customer->address = $input['address'];
		$customer->cust_type = $input['cust_type'];
		$customer->cust_saletype = $input['cust_saletype'];
		$customer->phone= $input['phone'];
		$customer->email= $input['email'];
		$customer->remark= $input['remark'];
		$customer->effective_date= $input['effective_date'];
        $customer->save();

        $data = $customer->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Customer updated successfully.'
        ];

        return response()->json($response, 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        $data = $customer->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Customer deleted successfully.'
        ];

        return response()->json($response, 200);
    }
}
