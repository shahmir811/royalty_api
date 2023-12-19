
  {{-- CUSTOMER DETAIL --}}
  <div style="padding-top: 0px; display: inline-block; width: 45%; margin-top: 0px;margin-left:-10px; height: 73px;position:relative;top:-10px;left:-10px ">
    <p style="margin: 0px; font-size: 15px;font-weight:600;font-family: 'Courier New', Courier, monospace;">{{ $sale->customer->name }}</p>
    <p style="margin: 0px; font-size: 15px;font-weight:600;font-family: 'Courier New', Courier, monospace;">Dubai Contact: {{ $sale->customer->mobile_no_dubai }}</p>
    <p style="margin: 0px; font-size: 15px;font-weight:600;font-family: 'Courier New', Courier, monospace;">Country Contact: {{ $sale->customer->mobile_no_country }}</p>    
    {{-- <p style="margin-left: 60px;">123456</p> --}}
  </div>

  {{-- DELIVERY LOCATION --}}
  <div style="padding-top: 10px; display: inline-block; margin-left: 10px; width: 40%; margin-top: 250px; margin-left: 110px; height: 73px;position:relative;top:-10px;left:-10px">
    <p style="margin: 0px; font-size: 15px;font-weight:600;font-family: 'Courier New', Courier, monospace;">{{ $sale->shipping_location }}</p>
    <p style="margin: 0px; font-size: 15px;font-weight:600;font-family: 'Courier New', Courier, monospace;">{{ $sale->contact_no }}</p>
    <div style="margin-top: 20px; margin-left: 60px; position:relative;top:10px;left:10px">
      <p style="margin: 0px; display: inline-block; margin-left: 0px; font-size: 15px;font-weight:600;font-family: 'Courier New', Courier, monospace;position:relative;top:-2px ">{{ $sale->sale_invoice_no }}</p>
      <p style="margin: 0px; display: inline-block; margin-left: 145px; font-size: 15px;font-weight:600;font-family: 'Courier New', Courier, monospace;position:relative;left:15px;top:-20px">{{ $today }}</p>
    </div>
  </div>

  {{-- CALCULATING TOTAL CBM --}}

  @php
    $totalCBM = number_format(0, 2);
    $totalWeight = number_format(0, 2);
  @endphp  

  @if ($sale->sales->count())

    @foreach ($sale->sales as $detail)
      
      @php
        $singleItemTotalCBM = $detail->quantity * ($detail->inventory->item->cbm);
        $singleItemTotalWeight = $detail->quantity * ($detail->inventory->item->weight);
        
        $totalCBM += $singleItemTotalCBM;
        $totalWeight += $singleItemTotalWeight;
      
      @endphp 

    @endforeach


  @endif


    
  <div style="margin-top: -60px; height: 73px;">

    {{-- CDM & WEIGHT --}}
    <div style="margin-left: 100px; display: inline-block; width: 30%;">
      <p style="margin: 0px; display: inline-block; margin-left: -15px; font-size: 15px;font-weight:600;font-family: 'Courier New', Courier, monospace; margin-top: 15px;position:relative;top:-16px">
        {{ $totalCBM }} &  {{ $totalWeight }}
      </p>
    </div>

    {{-- PAYMENT MODE --}}
    <div style="display: inline-block; width: 35%;">
      <p style="margin: 0px; display: inline-block; margin-left: 10px; font-size: 15px;font-weight:600;font-family: 'Courier New', Courier, monospace; margin-top: 17px; position:relative;top:-16px">
        {{ $sale->payment_mode }}
      </p>
    </div>

    {{-- SALESMAN --}}
    <div style="display: inline-block; width: 15%;">
      <p style="margin: 0px; display: inline-block; margin-left: 0px; font-size: 15px;font-weight:600;font-family: 'Courier New', Courier, monospace; margin-top: 20px;position:relative;top:-16px">
        {{ $sale->user->name }}
      </p>
    </div>


  </div>




  {{-- SALES DETAILS TABLE --}}
  <div style="margin-top: -25px; margin-left: 40px; height: 410px; position:relative;top:10px;">
    @if ($sale->sales->count())
          @foreach ($sale->sales as $detail)

          @php
            $taxOnItem = ($detail->quantity * $detail->sale_price * $sale->tax_percent) / 100;
          @endphp

            <div>
              <p style="display: inline-block; font-size: 15px;font-weight:600;font-family: 'Courier New', Courier, monospace; width: 20px; margin-top: 0px; margin-bottom: 0px;position:relative;left:-57px">
                {{ $loop->index + 1 }}
              </p>
              <p style="display: inline-block; font-size: 15px;font-weight:600;font-family: 'Courier New', Courier, monospace; width: 380px; margin-top: 0px; margin-bottom: 0px;position:relative;left:-22px">
                {{ $detail->inventory->item->name }}
              </p>
              <p style="display: inline-block; font-size: 15px;font-weight:600;font-family: 'Courier New', Courier, monospace; width: 50px; margin-top: 0px; margin-bottom: 0px;position:relative;left:-52px">
                {{ number_format($detail->quantity, 2) }}
              </p>
              <p style="display: inline-block; font-size: 15px;font-weight:600;font-family: 'Courier New', Courier, monospace; width: 70px; margin-top: 0px; margin-bottom: 0px;position:relative;left:-34px">
                {{ number_format($detail->sale_price, 2) }}
              </p>
              <p style="display: inline-block; font-size: 15px;font-weight:600;font-family: 'Courier New', Courier, monospace; width: 50px; margin-top: 0px; margin-bottom: 0px;position:relative;left:-29px">
                {{ number_format($taxOnItem, 2) }}
              </p>
              <p style="display: inline-block; font-size: 15px;font-weight:600;font-family: 'Courier New', Courier, monospace; width: 50px; margin-top: 0px; margin-bottom: 0px;position:relative;left:-11px">
                {{ number_format($detail->total_sale_price, 2) }}
              </p>
            </div>
          @endforeach          
    @endif
  </div>

  {{-- SALES TAX TOTAL --}}
  <div style="margin-top: 20px;margin-left: 570px;position:relative;left:-23px;">
    <p style="font-size: 15px;">{{ number_format($sale->total_tax, 2) }}</p>
  </div>


  <div style="margin-left: 100px; margin-top: -5px; height: 20px;">

    {{-- SALES GRAND TOTAL - IN WORDS --}}
    <div style="display: inline-block; width: 90%;">
      <p style="display: inline-block; font-size: 15px;position:relative;top:-12px;left:-51px;top:8px">
        {{ $sale->convertNumber($sale->sales->sum('total_sale_price')) }}
      </p>
    </div>
    
    {{-- SALES GRAND TOTAL --}}
    <div style="display: inline-block; width: 5%;">
      <p style="display: inline-block; font-size: 15px;position:relative;top:-9px;left:-20px;top:8px">
        {{ number_format($sale->sales->sum('total_sale_price'), 2) }}
      </p>
    </div>    

  </div>

