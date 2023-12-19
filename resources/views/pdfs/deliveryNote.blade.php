
  {{-- CUSTOMER DETAIL --}}
  <div style="padding-top: 10px; display: inline-block; width: 45%; margin-top: 270px; margin-left: 50px; height: 125px;">
    <p style="margin: 0px; font-size: 13px;">{{ $sale->customer->name }}</p>
    <p style="margin: 0px; font-size: 11px;">Dubai Contact: {{ $sale->customer->mobile_no_dubai }}</p>
    <p style="margin: 0px; font-size: 11px;">Country Contact: {{ $sale->customer->mobile_no_country }}</p>    
    <p style="margin-left: 60px;">{{$sale->sale_invoice_no}}</p>
  </div>

  {{-- DELIVERY LOCATION --}}
  <div style="padding-top: 10px; display: inline-block; margin-left: 10px; width: 40%; margin-top: 270px; margin-left: 50px; height: 125px;">
    <p style="margin: 0px; font-size: 11px;">{{ $note->shipping_location }}</p>
    <p style="margin: 0px; font-size: 11px;">{{ $note->contact_no }}</p>
    <div style="margin-top: 20px; margin-left: 60px;">
      <p style="margin: 0px; display: inline-block; margin-left: 0px; font-size: 11px;">{{ $note->delivery_note_no }}</p>
      <p style="margin: 0px; display: inline-block; margin-left: 135px; font-size: 11px;">{{ $today }}</p>
    </div>
  </div>

  @php
    $total_packages = 0;
  @endphp  

  {{-- SALES DETAILS TABLE --}}
  <div style="margin-top: -100px; margin-left: 40px; height: 437px;">
    @if ($note->delivery_note_details->count())


          @foreach ($note->delivery_note_details as $detail)

          @php
            // $package = $detail->quantity * $detail->inventory->item->package;
            $total_packages += $detail->packages;
          @endphp

            <div >
              <p style="display: inline-block; font-size: 11px; width: 20px; margin-top: 0px; margin-bottom: 0px;">
                {{ $loop->index + 1 }}
              </p>
              <p style="display: inline-block; font-size: 11px; width: 480px; margin-top: 0px; margin-bottom: 0px;">
                {{ $detail->inventory->item->name }}
              </p>

              <p style="display: inline-block; font-size: 11px; width: 80px; margin-top: 0px; margin-bottom: 0px;">
                {{ number_format($detail->packages, 2) }}
              </p>

              <p style="display: inline-block; font-size: 11px; width: 50px; margin-top: 0px; margin-bottom: 0px;">
                {{ number_format($detail->quantity, 2) }}
              </p>

            </div>
          @endforeach 
          
          
    @endif
  </div>

  {{-- TOTAL CARTON --}}
  <div style="margin-left: 170px; height: 70px;">
    <p>{{ $note->convertNumber($total_packages) }}</p>
  </div>

  {{-- CREATED BY AND CBM WEIGHT --}}
  <div style="margin-left: 350px">
    <p style="font-size: 11px; width: 100px;">{{ auth()->user()->name }}</p>
    <p style="font-size: 11px; width: 50px;">335.00</p>
  </div>