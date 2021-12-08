<?php

namespace App\Http\Controllers\API\Web\Employee;


use App\Models\{PredefinedValue};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PredefinedValueController extends Controller
{
    public function taxDetails()
    {
        $record = PredefinedValue::first();
        return response() -> json([
            'status' => 1,
            'message' => 'Current tax details',
            'data' => [
                'tax' => $record
            ]
        ], 200);              
    }    
}
