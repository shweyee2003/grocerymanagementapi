<?php

namespace App\Http\Controllers\API;

use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $customers = Customer::all();
		$employees = Employee::paginate(5);
        $data = $employees->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Employee retrieved successfully.'
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
            'empe_name' => 'required',
			'basic_salary' => 'required',
            'effective_date' => 'required',
			'phone' => 'required',
			'address' => 'required',
			
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $employee = Employee::create($input);
        $data = $employee->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Employee stored successfully.'
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        $data = $employee->toArray();

        if (is_null($employee)) {
            $response = [
                'success' => false,
                'data' => 'Empty',
                'message' => 'Employee not found.'
            ];
            return response()->json($response, 404);
        }


        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Employee retrieved successfully.'
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'empe_name' => 'required',
			'basic_salary' => 'required',
            'effective_date' => 'required',
			'phone' => 'required',
			'address' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }
		
        $employee->empe_name = $input['empe_name'];
		$employee->nrcno = $input['nrcno'];
        $employee->date_of_birth = $input['date_of_birth'];
		$employee->phone = $input['phone'];
		$employee->address = $input['address'];
		$employee->basic_salary= $input['basic_salary'];
		$employee->empe_image= $input['empe_image'];
		$employee->effective_date= $input['effective_date'];
		$employee->remark= $input['remark'];
        $employee->save();

        $data = $employee->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Employee updated successfully.'
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        $data = $employee->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Employee deleted successfully.'
        ];

        return response()->json($response, 200);
    }
}
