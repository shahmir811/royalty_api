<?php

namespace App\Http\Controllers\API\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Http\Controllers\API\Common\BaseLocationController;


class LocationController extends BaseLocationController
{
    public function changeLocationStatus($id)
    {
        $location = Location::withTrashed()->where('id', '=', $id)->first();
        if($location->deleted_at) {
            $location->restore();
        } else {
            $location->delete();
        }

        return response() -> json([
            'status' => 1,
            'message' => 'Location status has been changed'
        ], 200);    

    }     
}
