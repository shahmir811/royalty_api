<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }       
    

    public function location()
    {
        return $this->belongsTo(Location::class);
    }       


    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }  
    
    

}
