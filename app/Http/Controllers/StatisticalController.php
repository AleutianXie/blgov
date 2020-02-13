<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\Enterprise;

class StatisticalController extends Controller
{
    public function index(Request $request)
    {
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
        return view('statistic.reported', compact('statusGroup'));

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

    public function register(Request $request)
    {
        $user = $request->user();
        $town_id = $user->town_id;
        $urls = [
            'summary'   => config('app.api_url.summary'),
            'medical'   => config('app.api_url.medical'),
            'touch'     => config('app.api_url.touch'),
            'back'      => config('app.api_url.back'),
        ];
        return view('statistic.registed', compact('town_id', 'urls')); 
    }

}
