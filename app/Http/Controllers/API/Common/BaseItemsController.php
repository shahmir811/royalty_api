<?php

namespace App\Http\Controllers\API\Common;

use App\Models\Item;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use App\Http\Requests\Admin\ItemFormRequest;

class BaseItemsController extends Controller
{
    public function index()
    {
        $items = Item::orderBy('name', 'asc')->get();
        return response() -> json([
            'status' => 1,
            'message' => 'List of all items',
            'data' => [
                'items' => ItemResource::collection($items)
            ]
        ], 200);               
    }

    /////////////////////////////////////////////////////////////////////////  
    public function store(ItemFormRequest $request)
    {
        $item       = new Item;
        $itemRecord = $this->saveData($request, $item);

        return response() -> json([
            'status' => 1,
            'message' => 'Item record has been stored',
            'data' => [
                'item' => new ItemResource($itemRecord)
            ]
        ], 200);            
    }

    /////////////////////////////////////////////////////////////////////////  
    public function update(ItemFormRequest $request, $id)
    {
        $item       = Item::findOrFail($id);
        $itemRecord = $this->saveData($request, $item);

        return response() -> json([
            'status' => 1,
            'message' => 'Item record has been updated',
            'data' => [
                'item' => new ItemResource($itemRecord)
            ]
        ], 200);       
    }

    /////////////////////////////////////////////////////////////////////////  
    public function delete($id)
    {
        // Remove if it doesn't have purchase detail / sale detail data
        $item = Item::findOrFail($id);
        $haveRecords = $item->getChildrenEntriesCount(); // method has been written in Item model

        if($haveRecords < 0) {
            return response() -> json([
                'status' => 0,
                'message' => 'Item has associated enteries in purchase details / sale details table',
            ], 403);               

        } else {
            $item->delete();
            $item->save();

            return response() -> json([
                'status' => 1,
                'message' => 'Item has been deleted',
            ], 200);                
        }

    }

    /////////////////////////////////////////////////////////////////////////  
    private function saveData(ItemFormRequest $request, Item $item)
    {
        $item->name         = $request->name;
        $item->package      = $request->package;
        $item->cbm          = $request->cbm;
        $item->weight       = $request->weight;
        $item->description  = $request->description;
        $item->save();       
        
        return $item;
    }

    
}
