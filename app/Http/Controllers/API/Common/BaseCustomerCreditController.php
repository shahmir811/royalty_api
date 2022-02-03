<?php

namespace App\Http\Controllers\API\Common;

use PDF;
use Auth;
use App\Models\{Customer, Credit, Payment};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreditPaymentRequest;
use App\Http\Resources\{CustomerResource, CustomerCreditResource, CreditPaymentResource};

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
                'credits' => CustomerCreditResource::collection($credits)
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
        $payment = Payment::where('credit_id', '=', $credit_id)->orderBy('created_at', 'desc')->first();
        
        $pdf = PDF::loadView('pdfs.paymentDetails', compact('credit', 'payment'));
        $pdf->setPaper('a4' , 'portrait');
        return $pdf->output();  
    }



}
