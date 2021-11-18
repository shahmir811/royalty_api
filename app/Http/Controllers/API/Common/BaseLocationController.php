<?php

namespace App\Http\Controllers\API\Common;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Resources\LocationResource;
use App\Http\Requests\Admin\LocationFormRequest;


class BaseLocationController extends Controller
{
    
    public function index()
    {
        $locations = Location::withTrashed()->get();
        return response() -> json([
            'status' => 1,
            'message' => 'List of all locations',
            'data' => [
                'locations' => LocationResource::collection($locations)
            ]
        ], 200);        
    }

    /////////////////////////////////////////////////////////////////////////  
    public function store(LocationFormRequest $request)
    {
        $location = new Location;
        $this->saveData($location, $request);

        return response() -> json([
            'status' => 1,
            'message' => 'New location created successfully',
            'data' => [
                'location' => new LocationResource($location)
            ]
        ], 200);             
    }

    /////////////////////////////////////////////////////////////////////////  
    public function show($id)
    {
        $location = Location::findOrFail($id);
        return response() -> json([
            'status' => 1,
            'message' => 'New location created successfully',
            'data' => [
                'location' => new LocationResource($location)
            ]
        ], 200);            
    }

    /////////////////////////////////////////////////////////////////////////  
    public function update(LocationFormRequest $request, $id)
    {
        $location = Location::findOrFail($id);
        $this->saveData($location, $request);

        return response() -> json([
            'status' => 1,
            'message' => 'Location details updated successfully',
            'data' => [
                'location' => new LocationResource($location)
            ]
        ], 200);   
    }

    /////////////////////////////////////////////////////////////////////////  
    private function saveData(Location $location, Request $request)
    {
        $location->name = $request->name;
        $location->contact_no = $request->contact_no;
        $location->save();

        return;
    }    

}
