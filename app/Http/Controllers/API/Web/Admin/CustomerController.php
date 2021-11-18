<?php

namespace App\Http\Controllers\API\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Resources\CustomerResource;
use App\Http\Requests\Admin\CustomerFormRequest;
use App\Http\Controllers\API\Common\BaseCustomerController;

class CustomerController extends BaseCustomerController
{

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
