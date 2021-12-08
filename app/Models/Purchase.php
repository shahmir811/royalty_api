<?php

namespace App\Models;

use Auth;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_invoice_no',
        'total_amount',
        'local_purchase',
        'purchase_invoice_no',
        'user_id'
    ];      

    public function user()
    {
        return $this->belongsTo(User::class);
    }    
    
    public function purchases()
    {
        return $this->hasMany(PurchaseDetail::class);
    }        
    
    public static function boot()
    {
        parent::boot();

        static::creating(function (Purchase $purchase) {
            $purchase->purchase_invoice_no = time() . 'p';
            $purchase->user_id = Auth::id();
        });
    }

}
