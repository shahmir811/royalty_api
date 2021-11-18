<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'name',
        'contact_no'
    ];    

    public function sale_details()
    {
        return $this->hasMany(SaleDetail::class);
    }      
    
    public function purchase_details()
    {
        return $this->hasMany(PurchaseDetail::class);
    }      
    
    
}
