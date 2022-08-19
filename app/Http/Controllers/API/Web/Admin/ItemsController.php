<?php

namespace App\Http\Controllers\API\Web\Admin;

use App\Models\Item;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\Common\BaseItemsController;

class ItemsController extends BaseItemsController
{
    public function changeItemStatus($id)
    {      
        $item = Item::withTrashed()->where('id', '=', $id)->first();
        if($item->deleted_at) {
            $item->restore();
        } else {
            $item->delete();
        }

        return response() -> json([
            'status' => 1,
            'message' => 'Item status has been changed'
        ], 200);    

    }      
}
