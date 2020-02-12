<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function list(Request $request)
    {
        try {
            $user = $request->user();
            $yz_town_id = 700000;
            if (!$user->is_admin) {
                return "Access deny";
            }
//            if ($request->input('draw', 0) == 0) {
//                $request->offsetSet('draw', 1);
//            }
//            if ($request->input('page', -1) == -1) {
//                $request->offsetSet('page', 0);
//            }
 //           $page =  intval($request->input('page', 1));
//            if ($request->input('length', 0) == 0) {
//                $request->offsetSet('length', 10);
//            }
            // $length = $request->input('length', 10);
            // $request->offsetSet('start', ($page - 1) * $length);
            $model = Report::with('enterprise');
            if (!empty($user->town_id) && $user->town_id != $yz_town_id) {
                $model->where('town_id', $user->town_id);
            }
            if (!empty($user->industry_id_min) && !empty($user->industry_id_max)) {
                $model->industryBetween($user->industry_id_min, $user->industry_id_max);
            }
            $filter = $request->input();
            $this->getModel($model, $filter);

            return \datatables()
                ->eloquent($model)
                ->addColumn('EnterpriseName', function (Report $report) {
                    return $report->enterprise->EnterpriseName ?? '';
                })
                ->addColumn('EnterpriseID', function (Report $report) {
                    return $report->enterprise->EnterpriseID ?? '0';
                })
                ->addColumn('Industry', function (Report $report) {
                    return $report->enterprise->Industry ?? '';
                })
                ->editColumn('version', function (Report $report) {
                    return $report->version ?? '';
                })
                ->editColumn('report_at', function (Report $report) {
                    return $report->report_at ?? '';
                })
                ->editColumn('status', function (Report $report) {
                    $ret = [1 => '审核中', 2 => '审核通过', 3 => '不通过'];
                    return $ret[$report->status];
                })
                ->toJson();
        } catch (\Exception $e) {
            return response(["success" => false, "message" => $e->getMessage()]);
        }
    }

    private function getModel(&$model, $filter = [])
    {
        if (!empty($filter['status'])) {
            $model->where('status', $filter['status']);
        }
        if (!empty($filter['town'])) {
            $model->where('town_id', $filter['town']);
        }
        if (!empty($filter['industry'])) {
            $model->industry($filter['industry']);
        }
        $model->orderByDesc('report_at');
    }
}
