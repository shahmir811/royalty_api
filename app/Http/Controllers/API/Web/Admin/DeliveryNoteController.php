<?php

namespace App\Http\Controllers\API\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{DeliveryNote};
use App\Http\Controllers\API\Common\BaseDeliveryNote;

class DeliveryNoteController extends BaseDeliveryNote
{
    public function deleteDeliveryNote($id) 
    {
  
        $note = DeliveryNote::findOrFail($id);
        $note->delivery_note_details->each->delete();
        $note->delete();

        return response() -> json([
            'status' => 1,
            'message' => 'Record has been deleted succesfully',
            
        ], 200);                
    }
}
