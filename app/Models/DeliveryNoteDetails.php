<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryNoteDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'delivery_note_id',
        'location_id',
        'inventory_id',
        'sale_id'
    ];    
    
    public function location()
    {
        return $this->belongsTo(Location::class)->withTrashed();
    }    
    
    public function inventory()
    {
        return $this->belongsTo(Inventory::class)->withTrashed();
    }   
    
    public function delivery_note()
    {
        return $this->belongsTo(DeliveryNote::class);
    }  




}
