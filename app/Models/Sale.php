<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helper\Seed;

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
        'make_delivery_note',
        'cancelled_by',
        'user_id',
        'statuses_id',
        'customer_id',
        'payment_mode',
        'quotation_invoice_no'
    ];          

    public function user()
    {
        return $this->belongsTo(User::class);
    }       
    
    public function customer()
    {
        return $this->belongsTo(Customer::class)->withTrashed();
    }       
    
    public function status()
    {
        return $this->belongsTo(Status::class);
    }    

    public function sales()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function delivery_notes() 
    {
        return $this->hasMany(DeliveryNote::class);
    }
    
    public static function boot()
    {
        parent::boot();

        
        static::creating(function (Sale $sale) {
            $pending_status_id      = Status::where('name', '=', 'Pending')->where('type', '=', 'sales')->pluck('id');            
            $sale->status_id        = $pending_status_id[0];
            $condition              = $sale->type == 'export' || ($sale->type == 'local' && $sale->tax_percent == 5);
            $sale->proper_invoice   = $condition ? 1 : 0;

            if($sale->quotation) {
                $sale->sale_invoice_no = null;
                $sale->quotation_invoice_no = $sale->getQuotationInvoiceNo();
            
            } else {
                if($sale->proper_invoice) {
                    $sale->sale_invoice_no = $sale->getSaleSeries('T');
    
                } else {
                    $sale->sale_invoice_no = $sale->getSaleSeries('N');
                }
            } 


        });
    }

    private function getQuotationInvoiceNo() 
    {
        $data = self::whereNotNull('quotation_invoice_no')
                        ->orderBy('created_at', 'desc')
                        ->first();

        if ($data) {
            $recordParts = explode('-', $data->quotation_invoice_no);
            $oldRecordNo = (int)$recordParts[1];
            $newRecordNo = $oldRecordNo + 1;

            // Format the new record number with leading zero if necessary
            $formattedNewRecordNo = str_pad($newRecordNo, 2, '0', STR_PAD_LEFT);
            return 'Q-' . $formattedNewRecordNo;
        } else {
            return 'Q-01';
        }
    }

    public function getSaleSeries($type) 
    {
        $properInvoice = ($type == 'T') ? 1 : 0;
        $prefix = ($type == 'T') ? 'T' : 'N';

        $data = self::where('proper_invoice', '=', $properInvoice)
                    ->whereNotNull('sale_invoice_no')
                    ->orderBy('created_at', 'desc')
                    ->first();

        if ($data) {
            $recordParts = explode('-', $data->sale_invoice_no);
            $oldRecordNo = (int)$recordParts[1];
            $newRecordNo = $oldRecordNo + 1;

            // Format the new record number with leading zero if necessary
            $formattedNewRecordNo = str_pad($newRecordNo, 2, '0', STR_PAD_LEFT);
            return $prefix . '-' . $formattedNewRecordNo;
        } else {
            return $prefix . '-01';
        }
    }

    private static function getLatestSaleInvoiceNo()
    {
        $data = self::where('proper_invoice', '=', 1)->whereNotNull('sale_invoice_no')->latest()->first();
        return $data ? $data->sale_invoice_no + 1 : env('TAX_INVOICE_NO_START', 1);
    }

    public function convertNumber($num = false)
    {
        $num = str_replace(array(',', ''), '' , trim($num));
        if(! $num) {
            return false;
        }
        $num = (int) $num;
        $words = array();
        $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ( $hundreds == 1 ? '' : '' ) . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ( $tens < 20 ) {
                $tens = ($tens ? ' and ' . $list1[$tens] . ' ' : '' );
            } elseif ($tens >= 20) {
                $tens = (int)($tens / 10);
                $tens = ' and ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        $words = implode(' ',  $words);
        $words = preg_replace('/^\s\b(and)/', '', $words );
        $words = trim($words);
        $words = ucfirst($words);
        $words = $words . ".";
        return $words;
    }        

}
