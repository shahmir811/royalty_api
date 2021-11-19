<?php

namespace App\Http\Controllers\API\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Http\Resources\InventoryResource;
use App\Http\Requests\Admin\InventoryFormRequest;

class BaseInventoryController extends Controller
{
    public function index()
    {        
        $inventories = Inventory::withTrashed()->get();
        return response() -> json([
            'status' => 1,
            'message' => 'List of all inventories',
            'data' => [
                'inventories' => InventoryResource::collection($inventories)
            ]
        ], 200);
    }

    /////////////////////////////////////////////////////////////////////////      
    public function store(InventoryFormRequest $request)
    {
        $item = new Inventory;
        $this->saveDate($item, $request);

        return response() -> json([
            'status' => 1,
            'message' => 'Item is stored in inventory',
            'data' => [
                'item' => new InventoryResource($item)
            ]
        ], 201);               
    }

    /////////////////////////////////////////////////////////////////////////      
    public function show($id)
    {
        $item = Inventory::findOrFail($id);
        return response() -> json([
            'status' => 1,
            'message' => 'Item details',
            'data' => [
                'item' => new InventoryResource($item)
            ]
        ], 200);           
    }    

    /////////////////////////////////////////////////////////////////////////  
    public function update(InventoryFormRequest $request, $id)
    {
        $item = Inventory::findOrFail($id);
        $this->saveDate($item, $request);

        return response() -> json([
            'status' => 1,
            'message' => 'Item details are updated',
            'data' => [
                'item' => new InventoryResource($item)
            ]
        ], 201);    
    }

    /////////////////////////////////////////////////////////////////////////  
    private function saveDate(Inventory $item, Request $request)    
    {
        $item->item_name        = $request->item_name;
        $item->quantity         = $request->quantity;
        $item->description      = $request->description;
        $item->package          = $request->package;
        $item->cbm              = $request->cbm;
        $item->weight           = $request->weight;
        $item->purchase_price   = $request->purchase_price;
        $item->sale_price       = $request->sale_price;
        $item->location_id      = $request->location_id;
        $item->save();
    }
    
}
