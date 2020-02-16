<?php

namespace App\Http\Controllers;

use App\Enterprise;
use App\Http\Requests\ApplyPostRequest;
use App\Http\Requests\AuditPostRequest;
use App\Industry;
use App\Library\Utils\Uploader;
use App\Report;
use App\Revision;
use App\TownType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class EnterpriseController extends Controller
{
    public function detail(Request $request, $id) {
        $enterprise = Enterprise::with('report')->findOrFail($id);
        $towns = TownType::all()->pluck('TownName', 'TownID');
        return view('enterprise.detail', compact('enterprise', 'towns'));
    }

    public function my(Request $request) {
        if($request->user()->enterprise_id) {
            $enterprise = Enterprise::with('report')->findOrFail($request->user()->enterprise_id);
            $towns = TownType::all()->pluck('TownName', 'TownID');
            return view('enterprise.my', compact('enterprise', 'towns'));
        }
        return "Access deny";
    }

    public function apply(ApplyPostRequest $request) {
        try {
            DB::beginTransaction();
            $docs = [];
            $town_id = $request->get('town', 700000);
            $user = $request->user();
            if ($request->hasFile('file1')) {
                $path1 = Uploader::uploadImage($request->file('file1'), $user->enterprise_id);
                $docs[] = ['name' => '《企业（单位）复工申请（承诺）表》', 'url' => $path1];
            }

            if ($request->hasFile('file2')) {
                $path2 = Uploader::uploadImage($request->file('file2'), $user->enterprise_id);
                $docs[] = ['name' => '《企业（单位）返工人员调查总表》', 'url' => $path2];
            }

            if ($request->hasFile('file3')) {
                $path3 = Uploader::uploadImage($request->file('file3'), $user->enterprise_id);
                $docs[] = ['name' => '《企业（单位）复工防疫方案》', 'url' => $path3];
            }

            if ($request->hasFile('file4')) {
                $path4 = Uploader::uploadImage($request->file('file4'), $user->enterprise_id);
                $docs[] = ['name' => '附件', 'url' => $path4];
            }


            $attribute = [
                'enterprise_id' => $user->enterprise_id,
                'town_id' => $town_id,
                'version' => 1,
                'status' => 1,
                'comment' => '',
                'docs' => json_encode($docs),
                'report_at' => Carbon::now()
            ];

            $report = Report::where('enterprise_id', $user->enterprise_id)->first();
            if (!empty($report)) {
                $attribute['version'] = $report->version + 1;
                $report->update($attribute);
            } else {
                $report = Report::create($attribute);
            }

            $attribute['report_id'] = $report->id;
            Arr::forget($attribute, 'enterprise_id');
            Revision::create($attribute);
            DB::commit();
            return redirect()->route('enterprise.detail', $user->enterprise_id);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function audit(AuditPostRequest $request, $id) {
        try {
            $yz_town_id = 700000;
            $user = $request->user();
            $report = Report::where('enterprise_id', $id)->first();
            if (empty($report)){
                return redirect()->back()->with('error', '企业尚未申报');
            }
            if (!$user->is_admin || empty($user->town_id) || ($user->town_id != $yz_town_id && $user->town_id != $report->town_id)) {
                return redirect()->back()->with('error', '没有权限');
            }

            DB::beginTransaction();

            $attribute = [
                'status' => $request->get('status'),
                'comment' => $request->get('comment', '')
            ];

            $revision = Revision::where('report_id', $report->id)->where('version', $report->version)->first();
            if (!empty($revision)) {
                $revision->update($attribute);
            }
            $report->update($attribute);
            DB::commit();
            return redirect()->route('enterprise.index');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function revisions(Request $request) {
        if($request->user()->enterprise_id) {
            $enterprise = Enterprise::with('report')->findOrFail($request->user()->enterprise_id);
            $revisions = $enterprise->report->revisions ?? [];
            $towns = TownType::all()->pluck('TownName', 'TownID');
            return view('enterprise.process', compact('enterprise', 'revisions', 'towns'));
        }
        return "Access deny";
    }

    public function index(Request $request)
    {
        if ($request->user()->is_admin) {
            $model = Industry::query();
            if (!empty($request->user()->industry_id_min) && !empty($request->user()->industry_id_max)) {
                $model->whereBetween('IndustryTableID', [$request->user()->industry_id_min, $request->user()->industry_id_max]);
            }
            $industries = $model->pluck('IndustryName', 'IndustryTableID');
            $towns = TownType::all()->pluck('TownName', 'TownID');
            return view('enterprise.index', compact('industries', 'towns'));
        }
        return "Access deny";
    }

    public function list(Request $request)
    {
        try {
            $user = $request->user();
            $yz_town_id = 700000;
            if (!$user->is_admin) {
                return "Access deny";
            }
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
            $model = Enterprise::whereHas('report');
            if (!empty($user->town_id) && $user->town_id != $yz_town_id) {
                $model->with(['report' => function($query) use ($user) {
                    return $query->where('town_id', $user->town_id);
                }]);
            }
            if (!empty($user->industry_id_min) && !empty($user->industry_id_max)) {
                $model->whereBettween('IndustryTableID', $user->industry_id_min, $user->industry_id_max);
            }
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
