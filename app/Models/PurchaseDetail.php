<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;

    public function item()
    {
        return $this->belongsTo(Item::class)->withTrashed();
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
