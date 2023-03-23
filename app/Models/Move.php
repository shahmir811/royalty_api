<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Move extends Model
{
    use HasFactory;

    protected $fillable = [
        'move_invoice_no',
        'from_location_id',
        'to_location_id',
        'user_id'
    ];        

    public function move_details()
    {
        return $this->hasMany(MoveDetail::class);
    }   

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }    
    
    public function from_location()
    {
        return $this->belongsTo(Location::class, 'from_location_id')->withTrashed();
    }
    
    public function to_location()
    {
        return $this->belongsTo(Location::class, 'to_location_id')->withTrashed();
    }        
}
