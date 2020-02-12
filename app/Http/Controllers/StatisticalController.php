<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\Enterprise;

class StatisticalController extends Controller
{
    public function index(Request $request)
    {
        // $user = $request->user();

        // if ($user->town_id) {
        //     $statusGroup =  Report::where('town_id',$user->town_id);
        // } else {
        //     $statusGroup =  Report::whereBetween('town_id',[$user->industry_id_min, $user->industry_id_max]);
        // }

        // $statusGroup = $statusGroup->groupBy('status')
        //     ->selectRaw('status, count(status)')
        //     ->pluck('count','status')
        //     ->toJson();

        // return $user;
        // return view('statistical', compact('statusGroup'));
        
        $user = $request->user();
        
        if (!$user->town_id){
            //局
            $enterprise_ids = Enterprise::whereBetween('IndustryTableID',[$user->industry_id_min, $user->industry_id_max])
                ->select('EnterpriseID')
                ->get()
                ->pluck('EnterpriseID');
            $statusGroup =  Report::whereIn('enterprise_id',$enterprise_ids)
                ->groupBy('status')
                ->selectRaw('status, count(status)')
                ->pluck('count','status')
                ->toJson();
            
        } else {
            //乡镇
            $statusGroup = Report::where('town_id',$user->town_id)
                ->groupBy('status')
                ->selectRaw('status, count(status)')
                ->pluck('count','status')
                ->toJson();
        }
        return view('statistical', compact('statusGroup'));

    }

    /**
     * statistical data
     */
    public function statisticalData(Request $request)
    {
        $user = $request->user();
        if (!$user->town_id){
            $enterprises = Enterprise::with('users:EmployeeID,EnterpriseID,OutgoingSituation,IsMedicalObservation,OutgoingDesc,ContactSituation')
                ->whereBetween('IndustryTableID',[$user->industry_id_min, $user->industry_id_max])
                ->select('EnterpriseID','BackEmpNumber','EmployeesNumber')
                ->get();
            
        } else {
            $enterprise_ids = Report::where('town_id',$user->town_id)
                ->select('enterprise_id')
                ->get()
                ->pluck('enterprise_id');

            $enterprises = Enterprise::with('users:EmployeeID,EnterpriseID,OutgoingSituation,IsMedicalObservation,OutgoingDesc,ContactSituation')
            ->whereIn('EnterpriseID',$enterprise_ids)
            ->select('EnterpriseID','BackEmpNumber','EmployeesNumber')
            ->get();
        }

        return $enterprises;
    }

}
