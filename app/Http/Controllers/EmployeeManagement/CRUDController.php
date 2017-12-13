<?php

namespace App\Http\Controllers\EmployeeManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Employee;
use App\Unit;
use App\Ticket;

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
            'id_unit' => $request['id_unit'],
            'head_unit_id' => $request['head_unit_id'],      
            'room' => $request['room'],               
            'id_company' => $request['id_company'], 
            'id_role' => 2, 
        ]);

        return(redirect('/employee/management'));
        #return Employee::create($request->all());
    }

    // Add new unit
    protected function add_new_unit(Request $request)
    {
        Unit::create([
            'name' => $request['name'],               
            'id_company' => $request['id_company'], 
        ]);

        return(redirect('/employee/company_units'));   
    }

    protected function create_ticket(Request $request)
    {
    	Ticket::create([
    		'employee_init_id' => $request['employee_init_id'],
    		'unit_to_id' => $request['unit_to_id'],
    		'id_executor' => NULL,
    		'id_priority' => $request['id_priority'],
    		'subject' => $request['subject'],
    		'description' => $request['description'],
    		'id_status' => 1,
    		'id_company' => $request['id_company'],
    	]);

    	return(redirect('/employee/outgoing_tickets'));
    }

/*
    protected function appoint_executor_to_ticket(Request $request)
    {
    	'id_executor' => $request['id_executor'];
    	return(redirect('/outgoing_tickets'));
    } */


}
