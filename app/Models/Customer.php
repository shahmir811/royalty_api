<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'mark',
        'country',
        'mobile_no_dubai',
        'mobile_no_country',
        'cargo_address',
        'trn',
    ]; 

    public function credits()
    {
        return $this->hasMany(Credit::class);
    }       

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
    

}
