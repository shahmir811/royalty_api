<?php

namespace App\Http\Controllers\API\Common;

use PDF;
use Auth;
use App\Models\{Customer, Credit, Payment, Sale};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\{CreditPaymentRequest, CustomerCreditFormRequest};
use App\Http\Resources\{CustomerResource, CustomerCreditResource, CreditPaymentResource, CustomerSaleResource};

class BaseCustomerCreditController extends Controller
{
    public function getAllCustomersCreditList()
    {
        $customers = Customer::withTrashed()->orderBy('name', 'asc')->get();

        return response() -> json([
            'status'    => 1,
            'message'   => 'List of all customers credit',
            'data'      => [
                'customers' => CustomerResource::collection($customers)
            ]
        ], 200);
    }

    public function getCustomerCreditDetails($customer_id)
    {
        $customer   = Customer::findOrFail($customer_id);
        $credits    = Credit::where('customer_id', '=', $customer_id)->orderBy('created_at', 'desc')->get();

        return response() -> json([
            'status'        => 1,
            'message'       => 'Credit details',
            'customer_id'   => $customer_id,
            'customer_name' => $customer->name,
            'data' => [
                'credits' => CustomerCreditResource::collection($credits),
                'sales'   => $this->customerSalesList($customer_id), // returns sales with 0 credit record.
            ]
        ], 200);        
    }

    public function getCreditPaymentDetails($credit_id)
    {
        $credit   = Credit::findOrFail($credit_id);
        $payments = Payment::where('credit_id', '=', $credit_id)->orderBy('created_at', 'desc')->get();

        return response() -> json([
            'status'        => 1,
            'message'       => 'Payment details',
            'credit_id'     => $credit_id,
            'customer_id'   => $credit->customer_id,
            'customer_name' => $credit->customer->name,
            'total'         => $credit->total_amount_paid,
            'due_amount'    => $credit->due_amount,
            'data' => [
                'payments' => CreditPaymentResource::collection($payments)
            ]
        ], 200);                
    }

    public function addPayment(CreditPaymentRequest $request, $credit_id)
    {
        $payment            = new Payment;
        $payment->amount    = $request->amount;
        $payment->user_id   = Auth::id();
        $payment->credit_id = $credit_id;
        $payment->save();

        $credit              = Credit::findOrFail($credit_id);
        $credit->due_amount -= $request->amount;
        $credit->save(); 


        return response() -> json([
            'status'        => 1,
            'message'       => 'Credit details',
            'due_amount'    => $credit->due_amount,
            'data' => [
                'payment' => new CreditPaymentResource($payment)
            ]
        ], 200);             

    }    

    public function printPaymentDetails($credit_id)
    {
        $credit  = Credit::findOrFail($credit_id);
        $sum     = $credit->payments->sum('amount');
        $payment = Payment::where('credit_id', '=', $credit_id)->orderBy('created_at', 'desc')->first();
        
        $pdf = PDF::loadView('pdfs.paymentDetails', compact('credit', 'payment', 'sum'));
        $pdf->setPaper('a4' , 'portrait');
        return $pdf->output();  
    }

    public function addNewCustomerCredit(CustomerCreditFormRequest $request, $customer_id)
    {
        $credit                     = new Credit;
        $credit->customer_id        = $customer_id;
        $credit->sale_id            = $request->sale_id;
        $credit->due_amount         = $request->due_amount;
        $credit->total_amount_paid  = $request->total_amount_paid;
        $credit->save();

        return response() -> json([
            'status'        => 1,
            'message'       => 'New customer credit record is added',
            'data' => [
                'credit' => new CustomerCreditResource($credit),
                'sales'  => $this->customerSalesList($customer_id), // returns sales with 0 credit record.
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
