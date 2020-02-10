<?php

namespace App\Http\Controllers;

use App\Enterprise;
use App\Industry;
use App\Report;
use Illuminate\Http\Request;

class EnterpriseController extends Controller
{
    public function detail(Request $request, $id) {
        $enterprise = Enterprise::findOrFail($id);

       // dd($enterprise->report);
        return view('enterprise.detail', compact('enterprise'));
    }

    public function index(Request $request)
    {
        return view('enterprise.index');
    }

    public function list(Request $request)
    {
        try {
            if ($request->input('draw', 0) == 0) {
                $request->offsetSet('draw', 1);
            }
            if ($request->input('page', -1) == -1) {
                $request->offsetSet('page', 0);
            }
            $page =  intval($request->input('page', 1));
            if ($request->input('length', 0) == 0) {
                $request->offsetSet('length', 10);
            }
            $length = $request->input('length', 10);
            $request->offsetSet('start', ($page - 1) * $length);
            $model = Enterprise::with('report');
            $filter = $request->input();
            $this->getModel($model, $filter);

            return \datatables()
                ->eloquent($model)
                ->addColumn('version', function (Enterprise $enterprise) {
                    return $enterprise->report->version ?? '';
                })
                ->addColumn('report_at', function (Enterprise $enterprise) {
                    return $enterprise->report->report_at ?? '';
                })
                ->toJson();
        } catch (\Exception $e) {
            return response(["success" => false, "message" => $e->getMessage()]);
        }
    }

    private function getModel(&$model, $filter = [])
    {
        if (!empty($filter['status'])) {
            $model->reportStatus($filter['status']);
        }
        if (!empty($filter['industry'])) {
            $model->industry($filter['industry']);
        }
        $model->with(['report' => function($query) {
            $query->orderByDesc('report_at');
        }]);
    }
}
