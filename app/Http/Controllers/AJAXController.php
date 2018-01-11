<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;

class AJAXController extends Controller
{
  public function index()
  {
    $items = Ticket::all();
    return view('employee.tickets.view_all_incoming_inner_tickets', compact('items')); // pass items to view
  }
}
