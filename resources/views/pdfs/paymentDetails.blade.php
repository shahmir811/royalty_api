<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Receipt Voucher</title>
  </head>
  <body style="background: #fff; font-family: Arial, Helvetica, sans-serif; font-size: 14px">
    <div style="width:650px ; margin: 0 auto; padding: 20px; background: #fff;">
        <div class="voucher-logo">
          <img src="{{ public_path('header-01.png') }}" style="width: 100%">
        </div>
        <div style="text-align: center; font-size: 22px; font-weight: bold; padding-top: 25px; padding-bottom: 15px;">Receipt Voucher</div>

        <table style="border-collapse: collapse; border: 1px solid #cecece; width: 100%;">

          <tr>
            <td  valign="middle" style="border: 1px solid #cecece; padding: 3px">Receipt ID</td>
            <td colspan="3"  style="border: 1px solid #cecece;"><input style="display: block; width: 93%; padding: 0.375rem 0.75rem; font-size: 1rem; line-height: 1.5; color: #495057; background-color: #fff; background-clip: padding-box; border: 1px solid #ced4da; border-radius: 0.25rem; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; box-sizing: border-box;" type="text" placeholder="Default input" value="{{ $payment->id }}"></td>
          </tr>


          <tr>
            <td valign="middle" style="border: 1px solid #cecece; padding: 3px">Received By</td>
            <td colspan="3"  style="border: 1px solid #cecece; padding: 3px"><input style="display: block; width: 94%; padding: 0.375rem 0.75rem; font-size: 1rem; line-height: 1.5; color: #495057; background-color: #fff; background-clip: padding-box; border: 1px solid #ced4da; border-radius: 0.25rem; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; box-sizing: border-box;" type="text" placeholder="Name" value="{{ $payment->user->name }}"></td>
          </tr>
          <tr>
            <td valign="middle" style="border: 1px solid #cecece; padding: 3px">Paid By</td>
            <td colspan="3"  style="border: 1px solid #cecece; padding: 3px"><input style="display: block; width: 94%; padding: 0.375rem 0.75rem; font-size: 1rem; line-height: 1.5; color: #495057; background-color: #fff; background-clip: padding-box; border: 1px solid #ced4da; border-radius: 0.25rem; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; box-sizing: border-box;" type="text" placeholder="Name" value="{{ $payment->paid_by }}"></td>
          </tr>    
          <tr>
            <td valign="middle" style="border: 1px solid #cecece; padding: 3px">Reason</td>
            <td colspan="3"  style="border: 1px solid #cecece; padding: 3px"><input style="display: block; width: 94%; padding: 0.375rem 0.75rem; font-size: 1rem; line-height: 1.5; color: #495057; background-color: #fff; background-clip: padding-box; border: 1px solid #ced4da; border-radius: 0.25rem; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; box-sizing: border-box;" type="text" placeholder="Name" value="{{ $payment->reason }}"></td>
          </tr>                    
          <tr>
            <td valign="middle"  style="border: 1px solid #cecece; padding: 3px">Amount</td>
            <td style="border: 1px solid #cecece; padding: 3px"><input style="display: block; width: 80%; padding: 0.375rem 0.75rem; font-size: 1rem; line-height: 1.5; color: #495057; background-color: #fff; background-clip: padding-box; border: 1px solid #ced4da; border-radius: 0.25rem; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; box-sizing: border-box;" type="text" placeholder="Amount" value="{{ $payment->amount }}"></td>

            <td valign="middle"  style="border: 1px solid #cecece; padding: 3px">Remaining</td>
            <td style="border: 1px solid #cecece; padding: 3px"><input style="display: block; width: 80%; padding: 0.375rem 0.75rem; font-size: 1rem; line-height: 1.5; color: #495057; background-color: #fff; background-clip: padding-box; border: 1px solid #ced4da; border-radius: 0.25rem; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; box-sizing: border-box; " type="text" placeholder="Remaining Amount" value="{{ $credit->due_amount }}"></td>
          </tr>

          <tr>
            <td valign="middle"  style="border: 1px solid #cecece; padding: 3px;">Date</td>
            <td colspan="3"><input style="display: block; width: 92%; padding: 0.375rem 0.95rem; font-size: 1rem; line-height: 1.5; color: #495057; background-color: #eee; background-clip: padding-box; border: 1px solid #92979b; border-radius: 0.25rem; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; box-sizing: border-box;" type="text" placeholder="dd/mm/yyyy" value="{{ date("d M Y", strtotime($payment->created_at)) }}" readonly></td>
    
          </tr>          

        </table>

        <div style="height: 50px; font-size: 18px; font-weight: bold; padding-top: 20px;">
          Signature and Stamp
        </div>
        <div style="height: 90px; border: 1px solid #cecece;">
          
        </div>

    </div>

   </body>
</html>