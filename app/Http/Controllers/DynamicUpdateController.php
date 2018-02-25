<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Employee;
use App\Unit;
use App\Ticket;
use App\IndividualTicket;
use App\LegalTicket;
use App\Company;

use DB;
use Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

class DynamicUpdateController extends Controller
{
    public function testfunction(Request $request)
    {
    	/* return 'Test 100';
   		if(Request::ajax()){
		return 'Test 100';
		}; */


        /* if ($request->isMethod('get')){    
            return response()->json(['response' => 'This is post method']); 
        } */

        $result = "kek kek";
        
        echo json_encode($result);
        //return json(['response' => 'This is get method']);
    }
}
