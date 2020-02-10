<?php

namespace App\Http\Controllers;

use App\Enterprise;
use App\Library\Utils\Uploader;
use App\Report;
use App\Revision;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class EnterpriseController extends Controller
{
    public function detail(Request $request, $id) {
        $enterprise = Enterprise::findOrFail($id);

       // dd($enterprise->report);
        return view('enterprise.detail', compact('enterprise'));
    }

    public function my(Request $request) {
        if($request->user()->enterprise_id) {
            $enterprise = Enterprise::findOrFail($request->user()->enterprise_id);

            // dd($enterprise->report);
            return view('enterprise.my', compact('enterprise'));
        }
        return "Access deny";
    }

    public function apply(Request $request) {
        try {
            DB::beginTransaction();
            $docs = [];
            $town_id = $request->get('town', 700000);
            $user = $request->user();
            if ($request->hasFile('file1')) {
                $path1 = Uploader::uploadImage($request->file('file1'));
                $docs[] = ['name' => '《企业（单位）复工申请（承诺）表》', 'url' => $path1];
            }

            if ($request->hasFile('file2')) {
                $path2 = Uploader::uploadImage($request->file('file2'));
                $docs[] = ['name' => '《企业（单位）返工人员调查总表》', 'url' => $path2];
            }

            if ($request->hasFile('file3')) {
                $path3 = Uploader::uploadImage($request->file('file3'));
                $docs[] = ['name' => '《企业（单位）复工防疫方案》', 'url' => $path3];
            }


            $attribute = [
                'enterprise_id' => $user->enterprise_id,
                'town_id' => $town_id,
                'version' => 1,
                'status' => 1,
                'comment' => 'xxx',
                'docs' => json_encode($docs),
                'report_at' => Carbon::now()
            ];

            $report = Report::where('enterprise_id', $user->enterprise_id)->first();
            if (!empty($report)) {
                $attribute['version'] = $report->version + 1;
                $report->update($attribute);
            } else {
//                dd($attribute);
                $report = Report::create($attribute);
            }

            $attribute['report_id'] = $report->id;
            Arr::forget($attribute, 'enterprise_id');
            Revision::create($attribute);
            DB::commit();
            return redirect()->route('enterprise.detail', $user->enterprsie_id);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
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
