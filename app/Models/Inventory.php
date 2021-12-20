<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'item_name',
        'quantity',
        'description',
        'package',
        'cbm',
        'weight',
        'purchase_price',
        'avg_price',
        'sale_price',
        'location_id',
    ];     

    public function purchase_details()
    {
        return $this->hasMany(PurchaseDetail::class);
    }      
    
    public function location()
    {
        return $this->belongsTo(Location::class)->withTrashed();
    }     
    
    public static function boot()
    {
        parent::boot();

        static::creating(function (Inventory $invt) {
            $invt->avg_price = 0;
        });
    }    

}
