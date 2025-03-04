<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function computeRevenue(Request $request)
    {
        $from = Carbon::parse($request->from, 'UTC')->startOfDay();
        $to = Carbon::parse($request->to, 'UTC')->next('day');
        $visits = Visit::whereNotNull($request->column)->whereBetween('visit_date', [$from, $to]);
        return [
            'visits_count' => $visits->count(),
            'total_billed' => floatval($visits->sum($request->column)),
        ];
    }
}
