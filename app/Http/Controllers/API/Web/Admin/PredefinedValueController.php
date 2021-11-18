<?php

namespace App\Http\Controllers\API\Web\Admin;

use App\Models\{PredefinedValue};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UpdateTaxDetailsFormRequest;

class PredefinedValueController extends Controller
{
    public function taxDetails()
    {
        $record = PredefinedValue::first();
        return response() -> json([
            'status' => 1,
            'message' => 'Current tax details',
            'data' => $record
        ], 200);              
    }

    public function updateTaxDetails(UpdateTaxDetailsFormRequest $request)
    {
        $record = PredefinedValue::first();
        $record->percent = $request->percent;
        $record->show_tax = $request->show_tax;
        $record->save();

        return response() -> json([
            'status' => 1,
            'message' => 'Tax records updated',
            'data' => $record
        ], 200);        
    }
}
