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
        'user_id',
        'status_id'
    ];      

    public function user()
    {
        return $this->belongsTo(User::class);
    }    
    
    public function status()
    {
        return $this->belongsTo(Status::class);
    }    
     
    public function purchases()
    {
        return $this->hasMany(PurchaseDetail::class);
    }        
    
    public static function boot()
    {
        parent::boot();

        
        static::creating(function (Purchase $purchase) {
            
            $pending_status_id = Status::where('name', '=', 'Pending')->where('type', '=', 'purchase')->pluck('id');

            $purchase->purchase_invoice_no = time() . 'p';
            $purchase->user_id = Auth::id();
            $purchase->status_id = $pending_status_id[0];
        });
    }

}
