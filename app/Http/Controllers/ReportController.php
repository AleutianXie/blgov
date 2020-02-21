<?php

namespace App\Http\Controllers;

use App\Industry;
use App\Report;
use App\TownType;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ReportController extends Controller
{
    protected $towns;
    protected $industries;

    public function __construct()
    {
        $this->towns = TownType::all()->pluck('TownName', 'TownID');
        $this->industries = Industry::all()->pluck('IndustryName', 'IndustryTableID');
    }

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
                ->addColumn('town', function (Report $report) {
                    return $report->town->TownName ?? '';
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

    public function export(Request $request)
    {
        $user = $request->user();
        $data = [];
        if (!empty($user->is_admin)) {
            $yz_town_id = 700000;
            $model = Report::with('enterprise');
            if (!empty($user->town_id) && $user->town_id != $yz_town_id) {
                $model->where('town_id', $user->town_id);
            }
            if (!empty($user->industry_id_min) && !empty($user->industry_id_max)) {
                $model->industryBetween($user->industry_id_min, $user->industry_id_max);
            }
            $filter = $request->input();
            $this->getModel($model, $filter);
            $count = $model->count();
            if ($count > 0) {
                $data[] = ['单位名称', '所属区', '所属乡镇', '单位地址', '计划开工时间', '联系人', '联系电话', '企业防控情况说明', '企业规模', '职工人数', '已复工人数', '所属大类', '所属行业', '组织机构代码', '申请时间', '审核状态'];
                $model->chunk(100, function ($reports) use (&$data) {
                    foreach ($reports as $report) {
                        $EnterpriseName = $report->enterprise->EnterpriseName ?? '';
                        $District = $report->enterprise->District ?? '';
                        $town = $this->towns[$report->enterprise->TownID] ?? '';
                        $Address = $report->enterprise->Address ?? '';
                        $StartDate = $report->enterprise->StartDate ?? '';
                        $Contacts = $report->enterprise->Contacts ?? '';
                        $PhoneNumber = $report->enterprise->PhoneNumber ?? '';
                        $PreventionDesc = $report->enterprise->PreventionDesc ?? '';
                        $EnterpriseScale = $report->enterprise->EnterpriseScale == 0 ? '规下' : '规上';
                        $EmployeesNumber = $report->enterprise->EmployeesNumber ?? '';
                        $BackEmpNumber = $report->enterprise->BackEmpNumber ?? '';
                        $IndustryTableID = $this->industries[$report->enterprise->IndustryTableID] ?? '';
                        $Industry = $report->enterprise->Industry ?? '';
                        $OrganizationCode = $report->enterprise->OrganizationCode ?? '';
                        $ReportAt = $report->report_at ?? '';
                        $status = '审核中';
                        if ($report->status == 2) {
                            $status = '审核通过';
                        }
                        if ($report->status == 3) {
                            $status = '不通过';
                        }
                        $data[] = [$EnterpriseName, $District, $town, $Address, $StartDate, $Contacts, $PhoneNumber, $PreventionDesc, $EnterpriseScale, $EmployeesNumber, $BackEmpNumber, $IndustryTableID, $Industry, $OrganizationCode, $ReportAt, $status];
                    }
                });
                $spreadsheet = new Spreadsheet();
                // Set document properties
                $spreadsheet->getProperties()->setCreator('宝略科技')
                    ->setLastModifiedBy('宝略科技');

                $spreadsheet->setActiveSheetIndex(0);
                $spreadsheet->getActiveSheet()->fromArray($data);

                $style = [
                    'font' => [
                        'name' => '仿体',
                        'size' => 11
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_MEDIUM
                        ],
                    ],
                ];
                $spreadsheet->getActiveSheet()->getStyle('A1:P' . count($data))->applyFromArray($style);
                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth("30");
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth("36");
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth("12");
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth("14");
                $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth("48");
                $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth("20");
                $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth("20");
                $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth("36");
                $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth("10");
                $filename = '企业申请列表.xlsx';
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="' . $filename . '"');
                header('Cache-Control: max-age=0');

                $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save('php://output');
            }
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
        if (!empty($filter['enterprise'])) {
            $model->whereHas('enterprise', function ($query) use ($filter) {
                return $query->where('EnterpriseName', 'like', '%' . $filter['enterprise'] . '%');
            });
        }
        $model->orderByDesc('report_at');
    }
}
