
  {{-- CUSTOMER DETAIL --}}
  <div style="padding-top: 0px; display: inline-block; width: 45%; margin-top: 0px; margin-left: 50px; height: 73px; ">
    <p style="margin: 0px; font-size: 13px;">{{ $sale->customer->name }}</p>
    <p style="margin: 0px; font-size: 11px;">Dubai Contact: {{ $sale->customer->mobile_no_dubai }}</p>
    <p style="margin: 0px; font-size: 11px;">Country Contact: {{ $sale->customer->mobile_no_country }}</p>    
    {{-- <p style="margin-left: 60px;">123456</p> --}}
  </div>

  {{-- DELIVERY LOCATION --}}
  <div style="padding-top: 10px; display: inline-block; margin-left: 10px; width: 40%; margin-top: 250px; margin-left: 50px; height: 73px;">
    <p style="margin: 0px; font-size: 11px;">{{ $sale->shipping_location }}</p>
    <p style="margin: 0px; font-size: 11px;">{{ $sale->contact_no }}</p>
    <div style="margin-top: 20px; margin-left: 60px;">
      <p style="margin: 0px; display: inline-block; margin-left: 0px; font-size: 11px; margin-top: 15px;">{{ $sale->sale_invoice_no }}</p>
      <p style="margin: 0px; display: inline-block; margin-left: 145px; font-size: 11px; margin-top: 15px;">{{ $today }}</p>
    </div>
  </div>

  <div style="margin-top: -60px; height: 73px;">

    {{-- CDM & WEIGHT --}}
    <div style="margin-left: 100px; display: inline-block; width: 30%;">
      <p style="margin: 0px; display: inline-block; margin-left: 0px; font-size: 11px; margin-top: 15px;">350.00</p>
    </div>

    {{-- PAYMENT MODE --}}
    <div style="display: inline-block; width: 35%;">
      <p style="margin: 0px; display: inline-block; margin-left: 0px; font-size: 11px; margin-top: 15px;">
        {{ $sale->payment_mode }}
      </p>
    </div>

    {{-- SALESMAN --}}
    <div style="display: inline-block; width: 15%;">
      <p style="margin: 0px; display: inline-block; margin-left: 0px; font-size: 11px; margin-top: 15px;">
        {{ $sale->user->name }}
      </p>
    </div>


  </div>




  {{-- SALES DETAILS TABLE --}}
  <div style="margin-top: -20px; margin-left: 40px; height: 410px;">
    @if ($sale->sales->count())
          @foreach ($sale->sales as $detail)

          @php
            $taxOnItem = ($detail->quantity * $detail->sale_price * $sale->tax_percent) / 100;
          @endphp

            <div>
              <p style="display: inline-block; font-size: 11px; width: 20px; margin-top: 0px; margin-bottom: 0px">
                {{ $loop->index + 1 }}
              </p>
              <p style="display: inline-block; font-size: 11px; width: 380px; margin-top: 0px; margin-bottom: 0px;">
                {{ $detail->inventory->item->name }}
              </p>
              <p style="display: inline-block; font-size: 11px; width: 50px; margin-top: 0px; margin-bottom: 0px;">
                {{ number_format($detail->quantity, 2) }}
              </p>
              <p style="display: inline-block; font-size: 11px; width: 70px; margin-top: 0px; margin-bottom: 0px;">
                {{ number_format($detail->sale_price, 2) }}
              </p>
              <p style="display: inline-block; font-size: 11px; width: 50px; margin-top: 0px; margin-bottom: 0px; margin-left: 5px;">
                {{ number_format($taxOnItem, 2) }}
              </p>
              <p style="display: inline-block; font-size: 11px; width: 50px; margin-top: 0px; margin-bottom: 0px;">
                {{ number_format($detail->total_sale_price, 2) }}
              </p>
            </div>
          @endforeach          
    @endif
  </div>

  {{-- SALES TAX TOTAL --}}
  <div style="margin-top: 25px;margin-left: 570px">
    <p style="font-size: 11px;">{{ number_format($sale->total_tax, 2) }}</p>
  </div>

  {{-- SALES GRAND TOTAL --}}
  <div style="margin-top: -13px; margin-left: 650px">
    <p style="display: inline-block; font-size: 11px;">
      {{ number_format($sale->sales->sum('total_sale_price'), 2) }}
    </p>
  </div>