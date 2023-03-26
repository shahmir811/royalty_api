<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoveDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'inventory_id',
        'move_id',
    ];        

    public function move()
    {
        return $this->belongsTo(Moves::class);
    }
    
    public function inventory()
    {
        return $this->belongsTo(Inventory::class)->withTrashed();
    }   
    

}
