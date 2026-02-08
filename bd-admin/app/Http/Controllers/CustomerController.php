<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller{
  
    public function index(){
        $customers = Customer::orderBy('id', 'desc')->paginate(10);
        return view('customer.index', compact('customers'));
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return response()->json(['success' => true]);
    }
}