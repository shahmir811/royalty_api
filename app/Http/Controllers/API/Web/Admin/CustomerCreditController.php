<?php

namespace App\Http\Controllers\API\Web\Admin;

use App\Models\{Sale, Credit, Payment};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\{CustomerSaleResource};
use App\Http\Controllers\API\Common\BaseCustomerCreditController;

class CustomerCreditController extends BaseCustomerCreditController
{
    public function removeCustomerCreditRecord($credit_id)
    {
        $credit = Credit::findOrFail($credit_id);
        $customer_id = $credit->customer_id;

        $credit->payments->each->delete();
        $credit->delete();

        return response() -> json([
            'status'    => 1,
            'message'   => 'Credit records have been deleted',
            'data' => [
                'sales' => $this->customerSalesList($customer_id)
            ]
        ], 200);        
    }

    private function customerSalesList($customer_id)
    {
        $records = [];
        $sales = Sale::where('customer_id', '=', $customer_id)->whereNotNull('sale_invoice_no')->pluck('id')->toArray();

        for ($i=0; $i < sizeof($sales); $i++) { 
            $credit = Credit::where('sale_id', '=', $sales[$i])->exists();

            if(!$credit) {
                $data = Sale::findOrFail($sales[$i]);
                array_push($records, new CustomerSaleResource($data));
            }
        }

        return $records;
     
    }    
}
