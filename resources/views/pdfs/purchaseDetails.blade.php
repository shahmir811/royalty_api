<h1 style="align-content: center;">Purchase Details</h1>
<h3>Purchase Invoice No: <u>{{ $purchase->purchase_invoice_no }}</u></h3>
<h3>Local Purchase: <u>{{ $purchase->local_purchase ? 'Yes' : 'No' }}</u></h3>
<h3>Total Amount: <u>{{ $purchase->total_amount }}</u></h3>
<h3>Status: <u>{{ $purchase->status->name }}</u></h3>


<table style="border-collapse: collapse; border: 1px solid #cecece; width: 100%;">

  <thead>
    <tr>
      <th  valign="middle" style="border: 1px solid #cecece; padding: 3px">#</th>
      <th  valign="middle" style="border: 1px solid #cecece; padding: 3px">Location</th>
      <th  valign="middle" style="border: 1px solid #cecece; padding: 3px">Item</th>
      <th  valign="middle" style="border: 1px solid #cecece; padding: 3px">Price</th>
      <th  valign="middle" style="border: 1px solid #cecece; padding: 3px">Quantity</th>
      <th  valign="middle" style="border: 1px solid #cecece; padding: 3px">Amount</th>

    </tr>    
  </thead>

  @if ($purchase->purchases)
      
    <tbody>

      @foreach($purchase->purchases as $index => $detail)

      <tr>

      <td  valign="middle" style="border: 1px solid #cecece; padding: 3px">{{ $index + 1 }}</td>
      <td  valign="middle" style="border: 1px solid #cecece; padding: 3px">{{ $detail->location->name }}</td>
      <td  valign="middle" style="border: 1px solid #cecece; padding: 3px">{{ $detail->item->name }}</td>
      <td  valign="middle" style="border: 1px solid #cecece; padding: 3px">{{ $detail->price }}</td>
      <td  valign="middle" style="border: 1px solid #cecece; padding: 3px">{{ $detail->quantity }}</td>
      <td  valign="middle" style="border: 1px solid #cecece; padding: 3px">{{ $detail->price * $detail->quantity }}</td>        

      </tr>

      @endforeach

    </tbody>

  @endif

</table>

