<?php

namespace App\Http\Controllers;

use App\Enterprise;
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
                ->addColumn('Address', function (Report $report) {
                    return $report->enterprise->Address ?? '';
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
                $data[] = ['单位名称', '统一社会信用代码', '所属区', '所属乡镇', '单位地址', '计划开工时间', '联系人', '联系电话', '企业防控情况说明', '企业规模', '职工人数', '已复工人数', '所属大类', '所属行业', '审核状态', '申请时间'];
                $model->chunk(100, function ($reports) use (&$data) {
                    foreach ($reports as $report) {
                        $EnterpriseName = $report->enterprise->EnterpriseName ?? '';
                        $OrganizationCode = $report->enterprise->OrganizationCode ?? '';
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
                        $status = '审核中';
                        if ($report->status == 2) {
                            $status = '审核通过';
                        }
                        if ($report->status == 3) {
                            $status = '不通过';
                        }
                        $ReportAt = $report->report_at ?? '';
                        $data[] = [$EnterpriseName, $OrganizationCode, $District, $town, $Address, $StartDate, $Contacts, $PhoneNumber, $PreventionDesc, $EnterpriseScale, $EmployeesNumber, $BackEmpNumber, $IndustryTableID, $Industry, $status, $ReportAt];
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
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth("36");
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth("36");
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth("12");
                $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth("14");
                $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth("48");
                $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth("20");
                $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth("36");
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
        if (!empty($filter['address'])) {
            $model->whereHas('enterprise', function ($query) use ($filter) {
                $filter['address'] = str_replace('；',';',$filter['address']);
                $arr = explode(";",$filter['address']);
                foreach ($arr as $key=>$value){
                    if($key == 0){
                        $query->where('Address', 'like', '%' . $value . '%');
                    }else{
                        $query->orwhere('Address', 'like', '%' . $value . '%');
                    }

                }
                return $query;
            });
        }
        $model->orderByDesc('report_at');
    }


    public function exportlist(Request $request)
    {
        $user = $request->user();
        $data = [];
        if (!empty($user->is_admin)) {
            $model = Enterprise::with('report');
            $town_id = $user->town_id;

            $filter = $request->input();

            $ind = $filter['industry'];
            if (!$town_id){
                //局
                if ($ind && is_numeric($ind) && $ind < 2000000000){
                    //其他
                    if ($ind == 600026){
                        $model->whereRaw('("enterpriseInfoTable"."IndustryTableID" = 600026 or "enterpriseInfoTable"."IndustryTableID" is null)');
                    } else {
                        $model->where('enterpriseInfoTable.IndustryTableID', $ind);
                    }
                } else {
                    $model->whereRaw('("enterpriseInfoTable"."IndustryTableID" between '.$user->industry_id_min.' and '.$user->industry_id_max.' or "enterpriseInfoTable"."IndustryTableID" is null)');
                }
            } else {
                //乡镇
                $model->where('enterpriseInfoTable.TownID', $town_id);
                if ($ind && is_numeric($ind) && $ind < 2000000000){
                    if ($ind == 600026){
                        $model->whereRaw('("enterpriseInfoTable"."IndustryTableID" = '.$ind.' or "enterpriseInfoTable"."IndustryTableID" is null)');
                    } else {
                        $model->where('enterpriseInfoTable.IndustryTableID', $ind);
                    }
                } elseif($ind == 0) {
                    // $enterprises->orWhereRaw('"enterpriseInfoTable"."IndustryTableID" is null');
                }
            }

            $this->getModellist($model, $filter);
            $count = $model->count();
            if ($count > 0) {
                $data[] = ['单位名称', '统一社会信用代码', '所属区', '所属乡镇', '单位地址', '计划开工时间', '联系人', '联系电话', '企业防控情况说明', '企业规模', '职工人数', '已复工人数', '所属大类', '所属行业', '审核状态', '申请时间'];
                $model->chunk(100, function ($enterprises) use (&$data) {
                    foreach ($enterprises as $enterprise) {
                        $EnterpriseName = $enterprise->EnterpriseName ?? '';
                        $OrganizationCode = $enterprise->OrganizationCode ?? '';
                        $District = $enterprise->District ?? '';
                        $town = $this->towns[$enterprise->TownID] ?? '';
                        $Address = $enterprise->Address ?? '';
                        $StartDate = $enterprise->StartDate ?? '';
                        $Contacts = $enterprise->Contacts ?? '';
                        $PhoneNumber = $enterprise->PhoneNumber ?? '';
                        $PreventionDesc = $enterprise->PreventionDesc ?? '';
                        $EnterpriseScale = $enterprise->EnterpriseScale == 0 ? '规下' : '规上';
                        $EmployeesNumber = $enterprise->EmployeesNumber ?? '';
                        $BackEmpNumber = $enterprise->BackEmpNumber ?? '';
                        $IndustryTableID = $this->industries[$enterprise->IndustryTableID] ?? '';
                        $Industry = $enterprise->Industry ?? '';
                        $status = '未申报';
                        if (!empty($enterprise->report->status) && $enterprise->report->status == 1) {
                            $status = '审核中';
                        }
                        if (!empty($enterprise->report->status) && $enterprise->report->status == 2) {
                            $status = '审核通过';
                        }
                        if (!empty($enterprise->report->status) && $enterprise->report->status == 3) {
                            $status = '未通过';
                        }
                        $ReportAt = $enterprise->report->report_at ?? '';
                        $data[] = [$EnterpriseName, $OrganizationCode, $District, $town, $Address, $StartDate, $Contacts, $PhoneNumber, $PreventionDesc, $EnterpriseScale, $EmployeesNumber, $BackEmpNumber, $IndustryTableID, $Industry, $status, $ReportAt];
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
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth("36");
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth("36");
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth("12");
                $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth("14");
                $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth("48");
                $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth("20");
                $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth("10");
                $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth("36");
                $filename = '企业申请列表.xlsx';
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="' . $filename . '"');
                header('Cache-Control: max-age=0');

                $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save('php://output');
            }
        }
    }


    private function getModellist(&$model, $filter = [])
    {
        if (!empty($filter['status'])) {
            $model->whereHas('report', function ($query) use ($filter) {
                return $query->where('status', $filter['status']);
            });
        }
        if (!empty($filter['town'])) {
            $model->where('TownID', $filter['town']);
        }
        if (!empty($filter['industry'])) {
            $model->industry($filter['industry']);
        }
        if (!empty($filter['enterprise'])) {
            $model->where('EnterpriseName', 'like', '%' . $filter['enterprise'] . '%');
        }
        if (!empty($filter['address'])) {

            $filter['address'] = str_replace('；',';',$filter['address']);
            $arr = explode(";",$filter['address']);
            foreach ($arr as $key=>$value){
                if($key == 0){
                    $model->where('Address', 'like', '%' . $value . '%');
                }else{
                    $model->orwhere('Address', 'like', '%' . $value . '%');
                }

            }
            //$model->where('Address', 'like', '%' . $filter['address'] . '%');
        }
        $model->orderByDesc('created_at');
    }

}
