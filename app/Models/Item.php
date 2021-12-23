<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'package',
        'cbm',
        'weight',
    ];         

    public function purchaseDetails() {
        return $this->hasMany(PurchaseDetail::class);
    }

    // public function saleDetails() {
    //     return $this->hasMany(SaleDetail::class);
    // }

    public function inventories() {
        return $this->hasMany(SaleDetail::class);
    }

    public function getChildrenEntriesCount()
    {
        return $this->purchaseDetails()->count() + $this->inventories()->count();
        //  return $this->purchaseDetails()->count() + $this->inventories()->count() + $this->saleDetails()->count();
    }

}
