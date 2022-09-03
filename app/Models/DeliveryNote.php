<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_note_no',
        // 'avg_price',
        // 'sale_price',
        // 'quantity',
        'is_completed',
        // 'remaining_quantity',
        'sale_id',
        // 'sale_detail_id',
        // 'location_id',
        // 'inventory_id',
    ];         

    // public function inventory()
    // {
    //     return $this->belongsTo(Inventory::class)->withTrashed();
    // } 
    
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }  

    public function delivery_note_details()
    {
        return $this->hasMany(DeliveryNoteDetails::class);
    }
    
    // public function location()
    // {
    //     return $this->belongsTo(Location::class)->withTrashed();
    // }     
    
    // public function sale_detail()
    // {
    //     return $this->belongsTo(SaleDetail::class)->withTrashed();
    // }  
    

    public static function boot()
    {
        parent::boot();

                
        static::creating(function (DeliveryNote $note) {
            $note->delivery_note_no = $note->getLatestSaleInvoiceNo();
            $note->is_completed = 0;
        });

    }
    
    private static function getLatestSaleInvoiceNo()
    {
        $data = self::latest()->first();
        return $data ? (int)$data->delivery_note_no + 1 : env('DELIVERY_NOTE_START', 60000);
    }    
}
