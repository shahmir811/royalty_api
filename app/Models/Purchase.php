<?php

namespace App\Models;

use Auth;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helper\Seed;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_invoice_no',
        'total_amount',
        'local_purchase',
        'user_id',
        'status_id'
    ];      

    public function user()
    {
        return $this->belongsTo(User::class);
    }    
    
    public function status()
    {
        return $this->belongsTo(Status::class);
    }    
     
    public function purchases()
    {
        return $this->hasMany(PurchaseDetail::class);
    }        
    
    public static function boot()
    {
        parent::boot();

        
        static::creating(function (Purchase $purchase) {
            
            $pending_status_id = Status::where('name', '=', 'Pending')->where('type', '=', 'purchase')->pluck('id');
            $purchase->status_id = $pending_status_id[0];

            if (!Seed::isRunning()) {
                // do something only when the seeder is not running
                // $purchase->purchase_invoice_no = time() . 'p';
                $purchase->purchase_invoice_no = $purchase->getPurchaseInvoiceNo();
                $purchase->user_id = Auth::id();
            }

        });
    }

    private function getPurchaseInvoiceNo()
    {
        $data = self::latest()->first();

        if ($data) {
            $recordParts = explode('-', $data->purchase_invoice_no);
            $oldRecordNo = (int)$recordParts[1];
            $newRecordNo = $oldRecordNo + 1;

            // Format the new record number with leading zero if necessary
            $formattedNewRecordNo = str_pad($newRecordNo, 2, '0', STR_PAD_LEFT);
            return 'P-' . $formattedNewRecordNo;
        } else {
            return 'P-01';
        }
    }

}
