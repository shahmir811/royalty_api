<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_note_no',
        'sale_id',
        'contact_no',
        'shipping_location'
    ];         

    // public function inventory()
    // {
    //     return $this->belongsTo(Inventory::class)->withTrashed();
    // } 
    
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }  

    public function delivery_note_details()
    {
        return $this->hasMany(DeliveryNoteDetails::class);
    }
    
    // public function location()
    // {
    //     return $this->belongsTo(Location::class)->withTrashed();
    // }     
    
    // public function sale_detail()
    // {
    //     return $this->belongsTo(SaleDetail::class)->withTrashed();
    // }  
    

    public static function boot()
    {
        parent::boot();

                
        static::creating(function (DeliveryNote $note) {
            $note->delivery_note_no = $note->getLatestSaleInvoiceNo();
            // $note->is_completed = 0;
        });

    }
    
    private static function getLatestSaleInvoiceNo()
    {
        $data = self::latest()->first();

        if ($data) {
            $deliveryNoteParts = explode('-', $data->delivery_note_no);
            $oldDeliveryNoteNo = (int)$deliveryNoteParts[1];
            $newDeliveryNoteNo = $oldDeliveryNoteNo + 1;

            // Format the new delivery note number with leading zero if needed
            $formattedNewDeliveryNoteNo = str_pad($newDeliveryNoteNo, 2, '0', STR_PAD_LEFT);
            return 'D-' . $formattedNewDeliveryNoteNo;
        } else {
            return 'D-01';
        }
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
