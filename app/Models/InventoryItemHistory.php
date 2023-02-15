<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItemHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'status',
        'quantity',
        'purchased_invoice_no',
        'sale_invoice_no',
        'action_performer',
        'inventory_id',
    ];      
    
    public function inventory()
    {
        return $this->belongsTo(Inventory::class)->withTrashed();
    }   
    
    public static function addNewHistoryRecord($request)
    {
        $record                         = new InventoryItemHistory();
        $record->description            = $request->description;
        $record->status                 = $request->status;
        $record->quantity               = $request->quantity;
        $record->purchased_invoice_no   = $request->purchased_invoice_no;
        $record->sale_invoice_no        = $request->sale_invoice_no;
        $record->action_performer       = Auth::user()->name;
        $record->inventory_id           = $request->inventory_id;
        $record->save();

        return;
    }
}
