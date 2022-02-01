<?php

namespace App\Http\Controllers\API\Web\Admin;

use DB;
use Carbon\Carbon;
use App\Models\Sale;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\Common\BaseSaleController;

class SaleController extends BaseSaleController
{
    public function weeklySale()
    {
        $records = Sale::query()
                    ->select('created_at', DB::raw('SUM(total_sale_price - total_avg_price) as margin'), DB::raw('DAYNAME(created_at) as DayName'),  DB::raw('DAY(created_at) as Date'))
                    ->groupBy('created_at')
                    ->orderBy('created_at', 'asc')
                    ->get();

        return response() -> json([
            'status' => 1,
            'message' => 'Weekly sales data',
            'data' => [
                'records' => $records,
            ]
        ], 200);    

    }

    public function getSalesRecord(Request $request)
    {
        $days       = $request->days;
        $lastDays   = Carbon::now()->subDays($days);

        $records    = Sale::query()
                        ->select('created_at', DB::raw('SUM(total_sale_price - total_avg_price) as margin'), DB::raw('DATE(created_at) as date_at'), DB::raw('DAYNAME(created_at) as DayName'),  DB::raw('DAY(created_at) as Date'))
                        ->where('created_at', '>', $lastDays)
                        ->where('sale_invoice_no', '<>', '')
                        ->groupBy('created_at')
                        ->orderBy('created_at', 'asc')
                        ->get();        

        return response() -> json([
            'status' => 1,
            'message' => 'Sales Data',
            'data' => [
                'records' => $records,
                'days' => $days,
                'lastDays' => $lastDays
            ]
        ], 200);    

    }

    public function getSalesBetweenDates(Request $request)
    {
        $start      = $request->start;
        $end        = $request->end;

        $records    = Sale::query()
                        ->select('created_at', DB::raw('SUM(total_sale_price - total_avg_price) as margin'), DB::raw('DATE(created_at) as date_at'), DB::raw('DAYNAME(created_at) as DayName'),  DB::raw('DAY(created_at) as Date'))
                        ->whereBetween('created_at', [$start, $end])
                        ->where('sale_invoice_no', '<>', '')
                        ->groupBy('created_at')
                        ->orderBy('created_at', 'asc')
                        ->get();        


        return response() -> json([
            'status' => 1,
            'message' => 'Sales Data',
            'data' => [
                'start_date' => $request->start,
                'end_date' => $request->end,
                'records' => $records,
            ]
        ], 200);   
    }

    public function getYearlySales(Request $request)
    {
        $year = $request->year;
        $start      = $year . '-01-01';
        $end        = $year . '-12-31';

        $records    = Sale::query()
                        ->select(DB::raw('SUM(total_sale_price - total_avg_price) as margin'), DB::raw('MONTHNAME(created_at) AS Month')) 
                        ->whereBetween('created_at', [$start, $end])
                        ->where('sale_invoice_no', '<>', '')
                        ->groupBy('Month')
                        ->orderBy('Month', 'desc')
                        ->get();

        return response() -> json([
            'status' => 1,
            'message' => 'Yearly Sales Data',
            'data' => [
                'records' => $records,
            ]
        ], 200);           

    }
}
