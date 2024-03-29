<?php

namespace App\Http\Controllers\API\Common;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Resources\{CustomerResource, SaleResource, CustomerCreditResource};
use App\Http\Requests\Admin\CustomerFormRequest;

class BaseCustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('name', 'asc')->get();
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
        $customer = new Customer;
        $this->saveData($customer, $request);

        return response() -> json([
            'status' => 1,
            'message' => 'New customer created successfully',
            'data' => [
                'customer' => new CustomerResource($customer)
            ]
        ], 201);                

    }

    /////////////////////////////////////////////////////////////////////////  
    public function show($id)
    {
        $customer = Customer::withTrashed()->findOrFail($id);
        return response() -> json([
            'status' => 1,
            'message' => 'Customer details',
            'data' => [
                'customer' => new CustomerResource($customer),
                'credit' => CustomerCreditResource::collection($customer->credits),
                'sales' => SaleResource::collection($customer->sales),
            ]
        ], 200);                

    }

    /////////////////////////////////////////////////////////////////////////  
    public function update(CustomerFormRequest $request, $id)
    {
        $customer = Customer::withTrashed()->findOrFail($id);
        $this->saveData($customer, $request);

        return response() -> json([
            'status' => 1,
            'message' => 'Customer deatils updated successfully',
            'data' => [
                'customer' => new CustomerResource($customer),
            ]
        ], 200);              

    }

     /////////////////////////////////////////////////////////////////////////  
    private function saveData(Customer $customer, Request $request)
    {
        $customer->name                = $request->name;
        $customer->mark                = $request->mark;
        $customer->trn                 = $request->trn;
        $customer->country             = $request->country;
        $customer->mobile_no_dubai     = $request->mobile_no_dubai;
        $customer->mobile_no_country   = $request->mobile_no_country;
        $customer->cargo_address       = $request->cargo_address;
        // $customer->credit_amount       = $request->credit_amount;
        $customer->save();
        
        return;
    }

}
