<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_amount_paid',
        'due_amount',
        'customer_id',
        'sale_id',
    ];     

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }        

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }        


}
