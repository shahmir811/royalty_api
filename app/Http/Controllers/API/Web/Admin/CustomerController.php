<?php

namespace App\Http\Controllers\API\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Resources\CustomerResource;
use App\Http\Requests\Admin\CustomerFormRequest;

class CustomerController extends Controller
{

    public function index()
    {
        $customers = Customer::withTrashed()->get();
        return response() -> json([
            'status' => 1,
            'message' => 'List of all customers',
            'data' => [
                'customers' => CustomerResource::collection($customers)
            ]
        ], 200);        
    }

    /////////////////////////////////////////////////////////////////////////  
    public function store(CustomerFormRequest $request)
    {
        $customer                      = new Customer;
        $customer->name                = $request->name;
        $customer->mark                = $request->mark;
        $customer->country             = $request->country;
        $customer->mobile_no_dubai     = $request->mobile_no_dubai;
        $customer->mobile_no_country   = $request->mobile_no_country;
        $customer->cargo_address       = $request->cargo_address;
        $customer->credit_amount       = $request->credit_amount;
        $customer->save();

        return response() -> json([
            'status' => 1,
            'message' => 'New customer created successfully',
            'data' => [
                'customer' => new CustomerResource($customer)
            ]
        ], 200);                

    }

    /////////////////////////////////////////////////////////////////////////  
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return response() -> json([
            'status' => 1,
            'message' => 'Customer details',
            'data' => [
                'customer' => new CustomerResource($customer)
            ]
        ], 200);                

    }

    /////////////////////////////////////////////////////////////////////////  
    public function update(CustomerFormRequest $request, $id)
    {
        $customer                      = Customer::findOrFail($id);
        $customer->name                = $request->name;
        $customer->mark                = $request->mark;
        $customer->country             = $request->country;
        $customer->mobile_no_dubai     = $request->mobile_no_dubai;
        $customer->mobile_no_country   = $request->mobile_no_country;
        $customer->cargo_address       = $request->cargo_address;
        $customer->credit_amount       = $request->credit_amount;
        $customer->save();

        return response() -> json([
            'status' => 1,
            'message' => 'Customer deatils updated successfully',
            'data' => [
                'customer' => new CustomerResource($customer)
            ]
        ], 200);              

    }

    /////////////////////////////////////////////////////////////////////////  
    public function destroy(Customer $customer)
    {
        //
    }

    /////////////////////////////////////////////////////////////////////////  
    public function changeCustomerStatus($id)
    {
        // $customer = Customer::findOrFail($id);
        $customer = Customer::withTrashed()->where('id', '=', $id)->first();
        if($customer->deleted_at) {
            $customer->restore();
        } else {
            $customer->delete();
        }

        return response() -> json([
            'status' => 1,
            'message' => 'Customer status has been changed'
        ], 200);    

    }        
}
