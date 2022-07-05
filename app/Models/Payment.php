<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'credit_id',
        'user_id',
        'paid_by',
        'reason',
    ];  

    public function user()
    {
        return $this->belongsTo(User::class);
    }       
    
    public function credit()
    {
        return $this->belongsTo(Credit::class);
    }
    
    public static function boot()
    {
        parent::boot();

        static::creating(function (Payment $payment) {
            $payment->transaction_id = time() . 't';      
        });
    }    
    
    
}
