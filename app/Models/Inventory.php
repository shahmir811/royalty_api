<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    public function purchase_details()
    {
        return $this->hasMany(PurchaseDetail::class);
    }      
    
    public function location()
    {
        return $this->belongsTo(Location::class);
    }          

}
