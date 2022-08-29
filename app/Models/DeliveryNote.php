<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryNote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'delivery_note_no',
        'avg_price',
        'sale_price',
        'quantity',
        'is_completed',
        'remaining_quantity',
        'sale_id',
        'sale_detail_id',
        'location_id',
        'inventory_id',
    ];         

    public function inventory()
    {
        return $this->belongsTo(Inventory::class)->withTrashed();
    } 
    
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }  
    
    public function location()
    {
        return $this->belongsTo(Location::class)->withTrashed();
    }     
    
    public function sale_detail()
    {
        return $this->belongsTo(SaleDetail::class)->withTrashed();
    }         
}
