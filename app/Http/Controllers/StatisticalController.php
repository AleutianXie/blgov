<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;

class StatisticalController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $statusGroup = Report::where('town_id',$user->town_id)
            ->groupBy('status')
            ->selectRaw('status, count(status)')
            ->pluck('count','status')
            ->toJson();

        return view('statistical', compact('statusGroup'));
    }

    /**
     * statistical data
     */
    public function statisticalData(Request $request)
    {
        $user = $request->user();

        $data = Report::with(['enterpry:EnterpriseID,BackEmpNumber,EmployeesNumber'])
            ->where('town_id',$user->town_id)
            ->select('id','enterprise_id', 'town_id')
            ->get();

        return $data; 
    }

}
