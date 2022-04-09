<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'name',
        'description',
        'package',
        'cbm',
        'weight',
        'category_id'
    ];         

    public function purchaseDetails() {
        return $this->hasMany(PurchaseDetail::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }    

    public function inventories() {
        return $this->hasMany(SaleDetail::class);
    }

    public function getChildrenEntriesCount()
    {
        return $this->purchaseDetails()->count() + $this->inventories()->count();
        //  return $this->purchaseDetails()->count() + $this->inventories()->count() + $this->saleDetails()->count();
    }

}
