<?php

use App\Condition;
use App\Department;
use App\Employee;
use App\Enterprise;
use App\TownType;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class NcoveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 随机生成100个客户，每个客户10个部门，每个部门10个职位
        $faker = Factory::create('zh_CN');

        $departments = [
            '营业部',
            '人事部 ',
            '人力资源部',
            '总务部',
            '财务部',
            '销售部',
            '促销部',
            '国际部',
            '出口部',
            '进口部',
            '公关部',
            '广告部',
            '企划部',
            '产品开发部',
            '研发部',
            '秘书室',
            '采购部',
            '工程部',
            '行政部',
            '市场部',
            '技术部',
            '客服部',
            '总经理室',
            '副总经理室',
            '总经办',
            '生产部',
            '广东业务部',
            '无线事业部',
            '拓展部',
            '物供部',
            '业务拓展部',
            '会计部',
            '管理部',
            '监事会',
            '战略研究部',
            '外销部',
            '财务科',
            '党支部',
            '质检科',
            '厂长室',
            '档案室',
            '生产科'
        ];

        $this->command->info('随机生成100个企业.');
        $this->command->info('给每个企业生成10个部门.');
        $this->command->info('给每个部门生成100个员工...');
        $this->command->info('给每个员工生成14个健康数据...');

        $bar = $this->command->getOutput()->createProgressBar(100);
        for ($s = 0; $s < 100; $s++) {
            $dt = $faker->dateTime('-10 days');
            $startDate = $faker->date('Y-m-d', $dt);
            $employeesNumber = $faker->numberBetween(100, 10000);
            $backEmpNumber = $faker->numberBetween(100, $employeesNumber);
            $town = TownType::all()->random();
            $attributes = [
                'EnterpriseName' => $faker->unique(true)->company,
                'District' => '鄞州区',
                'Address' => $faker->address,
                'StartDate' => $startDate,
                'EnterpriseScale' => $faker->numberBetween(1, 2),
                'EmployeesNumber' => $employeesNumber,
                'BackEmpNumber' => $backEmpNumber,
                'TownID' => $town->TownID
            ];

            $enterprise = Enterprise::create($attributes);

            $departmentNames = $faker->randomElements($departments, 10);

            foreach ($departmentNames as $departmentName) {
                $attributes = [
                    'EnterpriseID' => $enterprise->EnterpriseID,
                    'DepartmentName' => $departmentName,
                    'created_at' => $startDate
                ];
                $department = Department::create($attributes);

                for($i = 0; $i < 100; $i++) {
                    $medicalObservationStartDate = $faker->date('Y-m-d', $startDate);
                    $medicalObservationEndDate = $faker->date("+10 days");
                    $medicalObservationEndDate = $faker->date($startDate, $medicalObservationEndDate);
                    // 返甬日期，设计漏了用此字段代替
                    $outgoingDesc = $faker->dateTimeBetween("-10 days");
                    $attributes = [
                        'EnterpriseID' => $enterprise->EnterpriseID,
                        'DepartmentID' => $department->DepartmentID,
                        'Name' => $faker->unique(true)->name,
                        'PhoneNumber' => $faker->phoneNumber,
                        'Gender' => $faker->numberBetween(0, 1),
                        'Address' => $faker->address,
                        'ContactSituation' => $faker->numberBetween(0, 1),
                        'LastContactDate' => $faker->date('Y-m-d', $startDate),
                        'OwnerHealth' => $faker->numberBetween(0, 4),
                        'IsMedicalObservation' => $faker->numberBetween(0, 1),
                        'MedicalObservationStartDate' => $medicalObservationStartDate,
                        'MedicalObservationEndDate' => $medicalObservationEndDate,
                        'OutgoingSituation' => $faker->numberBetween(0,4),
                        'OutgoingDesc' => $outgoingDesc->format('Y-m-d'),
//                        'MedicalObservationAddress' => $faker->address,
                        'created_at' => $startDate
                    ];
                    $employee = Employee::create($attributes);
                    for ($j = 0; $j < 14; $j++) {
                        $date = Carbon::createFromFormat('Y-m-d', $startDate);
                        $recordingTime = $date->addDays($j);
                        $attributes = [
                            'EmployeeID' => $employee->EmployeeID,
                            'RecordingTime' => $recordingTime,
                            'ObservationDay' => $j + 1,
                            'Temperature' => $faker->randomFloat(2, 37, 40),
                            'MeasuringTime' => $recordingTime,
                            'Symptom' => $faker->numberBetween(0,4)
                        ];
                        Condition::create($attributes);
                    }
                }
            }

            $bar->advance();
        }
        $bar->finish();
        $this->command->comment(PHP_EOL . '生成完成！');
    }
}
