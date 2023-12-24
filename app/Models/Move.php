<?php

namespace App\Models;

use Auth;
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
    
    public static function boot()
    {
        parent::boot();

        
        static::creating(function (Move $move) {
            
            $move->move_invoice_no =  $move->getMoveInvoiceNumber();
            $move->user_id = Auth::id();
            
        });
    }    

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

    private function getMoveInvoiceNumber()
    {
        $latestMove = Move::latest()->first();

        if($latestMove) {
            $oldRecordNo = (int)$latestMove->move_invoice_no;
            $newRecordNo = $oldRecordNo + 1;
            return $newRecordNo;

        } else {
            // TODO: Add the starting value of 6501 to .env file
            return '6501';
        }

    }
}
