<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PredefinedValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'percent',
        'show_tax'
    ];  
    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];    
}
