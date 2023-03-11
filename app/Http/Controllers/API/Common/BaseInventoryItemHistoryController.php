<?php

namespace App\Http\Controllers\API\Common;

use App\Models\InventoryItemHistory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\InventoryItemHistoryResource;

class BaseInventoryItemHistoryController extends Controller
{
    public function index($invt_id) 
    {

        $hist = InventoryItemHistory::where('inventory_id', '=', $invt_id)->orderBy('created_at', 'desc')->get();
        return response() -> json([
            'status' => 1,
            'message' => 'History of the mentioned item',
            'data' => [
                'hist' => InventoryItemHistoryResource::collection($hist)
            ]
        ], 200); 
    }

    
}
