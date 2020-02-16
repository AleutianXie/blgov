<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Enterprise;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class EmployeeController extends Controller
{
    public function export(Request $request)
    {
        $user = $request->user();
        $data = [];
        if (!empty($user->enterprise_id) && Employee::enterprise($user->enterprise_id)->count() > 0) {
            $enterprsie = Enterprise::findOrFail($user->enterprise_id);
            $data[] = ["附件2"];
            $data[] = ["企业（单位）返工人员调查总表"];
            $data[] = ["企业（单位）名称（公章）：" . $enterprsie->EnterpriseName];
            $data[] = ['员工姓名', '手机号码', '是否近14天来自湖北（武汉）、温州、台州（温岭、黄岩）疫情严重地区或有相关居住史、旅行史、接触史', '复工后居住地', '上下班交通方式', '近期是否出宁波市', '是否有发热或确诊过（疑似）病例', '分类', '备注'];
            Employee::enterprise($user->enterprise_id)->chunk(100, function ($employees) use (&$data) {
                foreach ($employees as $employee) {
                    $Name = $employee->Name ?? '';
                    $PhoneNumber = $employee->PhoneNumber ?? '';
                    $isLast14Contact = in_array($employee->OutgoingSituation, [1, 2, 3]);
                    if (!$isLast14Contact && $employee->ContactSituation == 1) {
                        $lastContactDate = Carbon::createFromFormat("Y-m-d", $employee->LastContactDate);
                        $isLast14Contact = $lastContactDate->addDays(14)->gt(Carbon::now());
                    }
                    $OutgoingSituation = $isLast14Contact ? '是' : '否';
                    $Address = $employee->Address ?? '';
                    $WorkTraffic_labels = [0 => '公司（单位）班车', 1 => '自驾', 2 => '公共交通', 3 => '步行等其他'];
                    $WorkTraffic = $WorkTraffic_labels[$employee->WorkTraffic] ?? '';
                    $IsLeaveNingbo = $employee->IsLeaveNingbo == 1 ? '是' : '否';
                    $IsFever = $employee->IsFever == 1 ? '是' : '否';
                    $OwnerStatus_labels = [0 => '需要隔离', 1 => '就诊人员', 2 => '正常', 3 => '其它'];
                    $OwnerStatus = $OwnerStatus_labels[$employee->OwnerStatus] ?? '';
                    $Desc = $employee->Desc ?? '';
                    $data[] = [$Name, $PhoneNumber, $OutgoingSituation, $Address, $WorkTraffic, $IsLeaveNingbo, $IsFever, $OwnerStatus, $Desc];
                }
            });
            $spreadsheet = new Spreadsheet();
            // Set document properties
            $spreadsheet->getProperties()->setCreator('宝略科技')
                ->setLastModifiedBy('宝略科技');

            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->getActiveSheet()->fromArray($data);

            $spreadsheet->getActiveSheet()->mergeCells('A1:I1');
            $a1_style = [
                'font' => [
                    'bold' => true,
                    'name' => '黑体',
                    'size' => 16
                ]
            ];
            $spreadsheet->getActiveSheet()->getStyle('A1:I1')->applyFromArray($a1_style);
            $a2_style = [
                'font' => [
                    'name' => '宋体',
                    'size' => 20
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ]
            ];
            $spreadsheet->getActiveSheet()->mergeCells('A2:I2');
            $spreadsheet->getActiveSheet()->getStyle('A2:I2')->applyFromArray($a2_style);
            $a3_style = [
                'font' => [
                    'name' => '楷体',
                    'size' => 16
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                ]
            ];
            $spreadsheet->getActiveSheet()->mergeCells('A3:I3');
            $spreadsheet->getActiveSheet()->getStyle('A3:I3')->applyFromArray($a3_style);
            $a4_style = [
                'font' => [
                    'name' => '仿体',
                    'size' => 11
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_TOP,
                    'wrapText' => true
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_MEDIUM
                    ],
                ],
            ];
            $spreadsheet->getActiveSheet()->getStyle('A4:I' . count($data))->applyFromArray($a4_style);
//        $spreadsheet->getActiveSheet()->getStyle('A4:I' . count($data))->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth("10");
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth("14");
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth("24");
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth("48");
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth("20");
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth("20");
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth("24");
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth("12");
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth("24");
            $filename = '企业（单位）返工人员调查总表_' . $enterprsie->EnterpriseName . '.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
        }
    }

}
