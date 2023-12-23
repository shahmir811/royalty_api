
{{-- CUSTOMER DETAIL --}}
<div style="padding-top: 10px; display: inline-block; width: 45%; margin-top: 270px; margin-left: 50px; height: 125px;position:relative;top:-20px;left:-60px;font-size: 14px;font-weight:600 !important;font-family: 'Arial', Helvetica, sans-serif;">
  <p style="margin: 0px; font-size: 13px;">{{ $sale->customer->name }}</p>
  {{-- <p style="margin: 0px; font-size: 14px;">Dubai Contact: {{ $sale->customer->mobile_no_dubai }}</p> --}}
  {{-- <p style="margin: 0px; font-size: 14px;">Country Contact: {{ $sale->customer->mobile_no_country }}</p>  --}}

  <div style="position:relative;top:6px;margin: -3px; font-size: 14px;">
    <p style="position:relative;left:45px;display: inline-block;">{{$sale->sale_invoice_no}}</p>
  </div>

</div>

{{-- DELIVERY LOCATION --}}
<div style="padding-top: 10px; display: inline-block; margin-left: 10px; width: 40%; margin-top: 270px; margin-left: 50px; height: 125px;position:relative;top:-20px;font-size: 14px;font-weight:600 !important;font-family: 'Arial', Helvetica, sans-serif;">
  <p style="margin: 0px; font-size: 14px;">{{ $note->shipping_location }}</p>
  <p style="margin: 0px; font-size: 14px;">{{ $note->contact_no }}</p>
  <div style="margin-top: 20px; margin-left: 60px;position:relative;top:13px">
    <p style="margin: 0px; display: inline-block; margin-left: 0px; font-size: 14px;">{{ $note->delivery_note_no }}</p>
    <p style="margin: 0px; display: inline-block; margin-left: 135px; font-size: 14px;position:relative;top:-17px;left:14px">{{ $today }}</p>
  </div>
</div>

@php
  $total_packages = 0;
@endphp  

{{-- SALES DETAILS TABLE --}}
<div style="margin-top: -100px; margin-left: 40px; height: 437px;position:relative;top:2px;font-size: 14px;font-weight:600 !important;font-family: 'Arial', Helvetica, sans-serif;">
  @if ($note->delivery_note_details->count())


        @foreach ($note->delivery_note_details as $detail)

        @php
          // $package = $detail->quantity * $detail->inventory->item->package;
          $total_packages += $detail->packages;
        @endphp

          <div >
            <p style="display: inline-block; font-size: 14px; width: 20px; margin-top: 0px; margin-bottom: 0px;position:relative;left:-60px;">
              {{ number_format((int)$detail->quantity / (int)$detail->inventory->item->package, 2)  }}
            </p>
            <p style="display: inline-block; font-size: 14px; width: 480px; margin-top: 0px; margin-bottom: 0px;position:relative;left:-17px;">
              {{ $detail->inventory->item->name }}
            </p>

            <p style="display: inline-block; font-size: 14px; width: 80px; margin-top: 0px; margin-bottom: 0px;position:relative;left:-35px;">
              {{ $detail->inventory->item->package }}
            </p>

            <p style="display: inline-block; font-size: 14px; width: 50px; margin-top: 0px; margin-bottom: 0px;position:relative;left:-10px;">
              {{ number_format($detail->quantity, 2) }}
            </p>

          </div>
        @endforeach 
        
        
  @endif
</div>

{{-- TOTAL CARTON --}}
<div style="margin-left: 170px; height: 70px;position:relative;top:18px;left:-13px;font-size: 14px;font-weight:600 !important;font-family: 'Arial', Helvetica, sans-serif;">
  <p>{{ $note->convertNumber($total_packages) }}</p>
</div>

  @php
    $totalCBM = number_format(0, 2);
    $totalWeight = number_format(0, 2);
  @endphp  

  @if ($note->delivery_note_details->count())

    @foreach ($note->delivery_note_details as $detail)
      
      @php
        $singleItemTotalCBM = $detail->quantity * ($detail->inventory->item->cbm);
        $singleItemTotalWeight = $detail->quantity * ($detail->inventory->item->weight);
        
        $totalCBM += $singleItemTotalCBM;
        $totalWeight += $singleItemTotalWeight;
      
      @endphp 

    @endforeach


  @endif

{{-- CREATED BY AND CBM WEIGHT --}}
<div style="margin-left: 350px;position:relative;top:12px;left:-13px;font-size: 14px;font-weight:600 !important;font-family: 'Arial', Helvetica, sans-serif;">
  <p style="font-size: 14px; width: 100px;">{{ auth()->user()->name }}</p>
  <p style="font-size: 14px; width: 50px;">{{ $totalCBM }} &  {{ $totalWeight }}</p>
</div>