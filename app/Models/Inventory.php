<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'item_id',
        'quantity',
        'purchase_price',
        'avg_price',
        'sale_price',
        'location_id',
    ];         
    
    public function location()
    {
        return $this->belongsTo(Location::class)->withTrashed();
    }     

    public function item()
    {
        return $this->belongsTo(Item::class)->withTrashed();
    }   
    
    public function item_history()
    {
        return $this->hasMany(InventoryItemHistory::class);
    }    

}
