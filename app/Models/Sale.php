<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_invoice_no',
        'total_sale_price',
        'total_tax',
        'total_cost_price',
        'tax_percent',
        'contact_no',
        'shipping_location',
        'type',
        'quotation',
        'user_id',
        'statuses_id',
        'customer_id',
    ];          

    public function user()
    {
        return $this->belongsTo(User::class);
    }       
    
    public function customer()
    {
        return $this->belongsTo(Customer::class)->withTrashed();;
    }       
    
    public function status()
    {
        return $this->belongsTo(Status::class);
    }    

    public function sales()
    {
        return $this->hasMany(SaleDetail::class);
    }
    
    public static function boot()
    {
        parent::boot();

        
        static::creating(function (Sale $sale) {
            $pending_status_id      = Status::where('name', '=', 'Pending')->where('type', '=', 'sales')->pluck('id');            
            $sale->status_id        = $pending_status_id[0];

            if($sale->quotation) {
                $sale->sale_invoice_no = null;

            } else {
                $condition              = $sale->type == 'export' || ($sale->type == 'import' && $sale->tax_percent != '5');
                $sale->sale_invoice_no  = $condition ? $sale->getLatestSaleInvoiceNo() : time() . 's';  
                $sale->proper_invoice   = $condition ? 1 : 0;
            }

        });
    }

    private static function getLatestSaleInvoiceNo()
    {
        $data = self::where('proper_invoice', '=', 1)->latest()->first();
        return $data ? $data->sale_invoice_no + 1 : env('TAX_INVOICE_NO_START', 500);
    }

}
