<?php

namespace App\Http\Controllers\EmployeeManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Employee;
use Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;


class CRUDController extends Controller
{
	public function showManagementForm ()
	{
		return view('employee.manage');
	}


	protected function add_new_employee(Request $request)
    {
        Employee::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'phone_number' => $request['phone_number'],
            
            'priv_add_employee' => $request['priv_add_employee'],
            'priv_edit_employee' => $request['priv_edit_employee'], 
            'priv_delete_employee' => $request['priv_delete_employee'], 
            'head_unit_id' => '',      
            'room' => $request['room'],               
            'id_company' => $request['id_company'], 
            'id_role' => 2, 
        ]);

        return(redirect('/employee/management'));

        #return Employee::create($request->all());
    }
}
