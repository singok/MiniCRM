<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Company::select('id', 'name')->get();
        return view('employee.employee-list',['dataInfo' => $company]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'company' => 'required',
            'email' => 'required | unique:employees',
            'phone' => 'required | unique:employees'
        ]);

        // insert fresh employee data
        if (empty($request->employeeid)) {
            $info = Employee::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'company' => $request->company,
                'email' => $request->email,
                'phone' => $request->phone
            ]);

            if ($info) {
                return response()->json([
                    'success' => 'Employee Details Inserted Successfully.'
                ]);
            }
        }

        // update employee data
        else {
            $info = Employee::where('id', $request->employeeid)->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'company' => $request->company,
                'email' => $request->email,
                'phone' => $request->phone
            ]);

            if ($info) {
                return response()->json([
                    'success' => 'Employee Details Updated Successfully.'
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $employees = Employee::with('companies')->get();
        $value = "";
        if ($employees) {
            foreach($employees as $emp) {
                $value .= "<tr>
                <td>".$emp->firstname." ".$emp->lastname."</td>
                <td>".$emp->companies->name."</td>
                <td>".$emp->email."</td>
                <td>".$emp->phone."</td>
                <td>
                    <a href='#' data-id='".$emp->id."' class='editEmployee'><i class='fa-solid fa-pen fa-lg mr-1'
                            style='color:blue'></i></a>
                    <a href='#' data-id='".$emp->id."' class='removeEmployee'><i
                            class='fa-solid fa-delete-left fa-lg ml-1' style='color:red'></i></a>
                </td></tr>";
            }

            echo $value;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $employee = Employee::with('companies')->where('id', $request->id)->first();
        if ($employee) {
            return response()->json([
                'employeeid' => $employee->id,
                'employeefname' => $employee->firstname,
                'employeelname' => $employee->lastname,
                'employeeemail' => $employee->email,
                'employeephone' => $employee->phone,
                'employeecompany' => $employee->company
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $info = Employee::where('id', $request->id)->delete();
        if ($info) {
            return response()->json([
                'success' => 'Employee Details Deleted Successfully'
            ]);
        }
    }
}
