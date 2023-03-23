<?php

namespace App\Http\Controllers\API\Common;

use App\Models\{Move, MoveDetail};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\MoveResource;

class BaseMoveController extends Controller
{
    public function index() 
    {
        $moves = Move::orderBy('created_at', 'desc')->get();
        return response() -> json([
            'status' => 1,
            'message' => 'List of all movements',
            'data' => [
                'moves' => MoveResource::collection($moves)
            ]
        ], 200);         
    }
}
