<?php

namespace App\Http\Controllers\API\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Http\Controllers\API\Common\BaseInventoryController;

class InventoryController extends BaseInventoryController
{
    /////////////////////////////////////////////////////////////////////////  
    public function changeInventoryItemStatus($id)
    {
        $item = Inventory::withTrashed()->where('id', '=', $id)->first();
        if($item->deleted_at) {
            $item->restore();
        } else {
            $item->delete();
        }

        return response() -> json([
            'status' => 1,
            'message' => 'Inventory item status has been changed'
        ], 200);    

    }       
}
