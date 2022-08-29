<?php

namespace App\Http\Controllers\API\Common;

use App\Models\DeliveryNote;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DeliveryNoteResource;

class BaseDeliveryNote extends Controller
{
    public function allDeliveryNotes() 
    {        
        $notes = DeliveryNote::withTrashed()->orderBy('created_at', 'desc')->get();
        return response() -> json([
            'status' => 1,
            'message' => 'List of all delivery notes',
            'data' => [
                'notes' => DeliveryNoteResource::collection($notes)
            ]
        ], 200); 
    }
}
