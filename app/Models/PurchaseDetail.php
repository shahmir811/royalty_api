<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }       
    
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }       
    
    public function location()
    {
        return $this->belongsTo(Location::class)->withTrashed();
    }         
}
