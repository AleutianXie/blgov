<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;

class Gov extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gov:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update gov data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $yz_townID = 700000;
        $this->comment("Update gov data start at: " . date('Y-m-d H:i:s', time()));
        // 企业数
        $enterprise_count = DB::table('enterpriseInfoTable')
            ->select('TownID', DB::raw('count(*) as total'))
            ->groupBy('TownID')->pluck('total', 'TownID')
            ->toArray();
        $enterprise_count = Arr::add($enterprise_count, $yz_townID, array_sum(array_values($enterprise_count)));
        foreach ($enterprise_count as $id => $count) {
            Redis::hSet('blgov:summary:enterprise:count', $id, $count);
        }
        // 企业员工数
        $employee_count = DB::table('enterpriseInfoTable')
            ->select('TownID', DB::raw('sum("EmployeesNumber") as total'))
            ->groupBy('TownID')->pluck('total', 'TownID')
            ->toArray();
        $employee_count = Arr::add($employee_count, $yz_townID, array_sum(array_values($employee_count)));
        foreach ($employee_count as $id => $count) {
            Redis::hSet('blgov:summary:employee:count', $id, $count);
        }
        // 在甬员工数、非在甬员工数
        $employee_back_count = DB::table('enterpriseInfoTable')
            ->select('TownID', DB::raw('sum("BackEmpNumber") as total'))
            ->groupBy('TownID')
            ->pluck('total', 'TownID')
            ->toArray();
        $employee_back_count = Arr::add($employee_back_count, $yz_townID, array_sum(array_values($employee_back_count)));
        foreach ($employee_back_count as $id => $count) {
            Redis::hSet('blgov:summary:employee_back:count', $id, $count);
            Redis::hSet('blgov:summary:employee_not_back:count', $id, $employee_count[$id] - $count);
        }
        // 员工性别男
        $employee_gender_count = DB::table('employeeInfoTable')
            ->join('enterpriseInfoTable', 'employeeInfoTable.EnterpriseID', '=', 'enterpriseInfoTable.EnterpriseID')
            ->select('TownID', 'Gender', DB::raw('count(*) as total'))
            ->groupBy('TownID')
            ->groupBy('Gender')
            ->orderBy('TownID', 'asc')
            ->orderBy('Gender', 'asc')
            ->get()
            ->toArray();
        $gender_total = [0 => 0, 1 => 0];
        foreach ($employee_gender_count as $item) {
            $gender_total[$item->Gender] += $item->total;
            Redis::hSet('blgov:summary:employee_gender:count:' . $item->TownID, $item->Gender, $item->total);
        }
        foreach ($gender_total as $gender => $total) {
            Redis::hSet('blgov:summary:employee_gender:count:' . $yz_townID, $gender, $total);
        }

        // 假期外出情况
        $employee_outing_count = DB::table('employeeInfoTable')
            ->join('enterpriseInfoTable', 'employeeInfoTable.EnterpriseID', '=', 'enterpriseInfoTable.EnterpriseID')
            ->select('TownID', 'OutgoingSituation', DB::raw('count(*) as total'))
            ->groupBy('TownID')
            ->groupBy('OutgoingSituation')
            ->orderBy('TownID', 'asc')
            ->orderBy('OutgoingSituation', 'asc')
            ->get()
            ->toArray();
        $outing_total = [0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0];
        foreach ($employee_outing_count as $item) {
            $outing_total[$item->OutgoingSituation] += $item->total;
            Redis::hSet('blgov:summary:employee_outing:count:' . $item->TownID, $item->OutgoingSituation, $item->total);
        }
        foreach ($outing_total as $key => $total) {
            Redis::hSet('blgov:summary:employee_outing:count:' . $yz_townID, $key, $total);
        }

        // 返甬时间
        $employee_back_date_count = DB::table('employeeInfoTable')
            ->join('enterpriseInfoTable', 'employeeInfoTable.EnterpriseID', '=', 'enterpriseInfoTable.EnterpriseID')
            ->select('TownID', 'OutgoingDesc', DB::raw('count(*) as total'))
            ->groupBy('TownID')
            ->groupBy('OutgoingDesc')
            ->orderBy('TownID', 'asc')
            ->orderBy('OutgoingDesc', 'asc')
            ->having('OutgoingDesc', '<>', '')
            ->get()
            ->toArray();
        $back_total = [0];
        foreach ($employee_back_date_count as $item) {
            if (!isset($back_total[$item->OutgoingDesc])) {
                $back_total[$item->OutgoingDesc] = 0;
            }
            $back_total[$item->OutgoingDesc] += $item->total;
            Redis::del('blgov:summary:employee_back_date:count:' . $item->TownID);
            Redis::hMSet('blgov:summary:employee_back_date:count:' . $item->TownID, [$item->OutgoingDesc => $item->total]);
        }

        Redis::del('blgov:summary:employee_back_date:count:' . $yz_townID);
        Redis::hMSet('blgov:summary:employee_back_date:count:' . $yz_townID, $back_total);

        // 接触情况
        $employee_contact_situation_count = DB::table('employeeInfoTable')
            ->join('enterpriseInfoTable', 'employeeInfoTable.EnterpriseID', '=', 'enterpriseInfoTable.EnterpriseID')
            ->select('TownID', 'ContactSituation', DB::raw('count(*) as total'))
            ->groupBy('TownID')
            ->groupBy('ContactSituation')
            ->orderBy('TownID', 'asc')
            ->orderBy('ContactSituation', 'asc')
            ->get()
            ->toArray();
        $contact_situation_total = [0, 0];
        foreach ($employee_contact_situation_count as $item) {
            $contact_situation_total[$item->ContactSituation] += $item->total;
            Redis::hSet('blgov:summary:employee_contact_situation:count:' . $item->TownID, $item->ContactSituation, $item->total);
        }
        foreach ($contact_situation_total as $contactSituation => $total) {
            Redis::hSet('blgov:summary:employee_contact_situation:count:' . $yz_townID, $contactSituation, $total);
        }

        // 医院观察
        $employee_is_medical_count = DB::table('employeeInfoTable')
            ->join('enterpriseInfoTable', 'employeeInfoTable.EnterpriseID', '=', 'enterpriseInfoTable.EnterpriseID')
            ->select('TownID', 'IsMedicalObservation', DB::raw('count(*) as total'))
            ->groupBy('TownID')
            ->groupBy('IsMedicalObservation')
            ->having('IsMedicalObservation', 1)
            ->get()
            ->toArray();

        $is_medical_total = 0;
        foreach ($employee_is_medical_count as $item) {
            $is_medical_total += $item->total;
            Redis::hSet('blgov:summary:employee_is_medical:count', $item->TownID, $item->total);
        }
        Redis::hSet('blgov:summary:employee_is_medical:count', $yz_townID, $is_medical_total);

        // 发热情况，不显示正常情况
        $employee_owner_health_count = DB::table('employeeInfoTable')
            ->join('enterpriseInfoTable', 'employeeInfoTable.EnterpriseID', '=', 'enterpriseInfoTable.EnterpriseID')
            ->select('TownID', 'OwnerHealth', DB::raw('count(*) as total'))
            ->groupBy('TownID')
            ->groupBy('OwnerHealth')
//            ->having('OwnerHealth', '<>', 0)
//            ->having('OwnerHealth', '<>', 3)
            ->orderBy('TownID', 'asc')
            ->orderBy('OwnerHealth', 'asc')
            ->get()
            ->toArray();

        $owner_health_total = [0];
        foreach ($employee_owner_health_count as $item) {
            if (!isset($owner_health_total[$item->OwnerHealth])) {
                $owner_health_total[$item->OwnerHealth] = 0;
            }
            $owner_health_total[$item->OwnerHealth] += $item->total;
            Redis::hSet('blgov:summary:employee_owner_health:count:' . $item->TownID, $item->OwnerHealth, $item->total);
        }
        foreach ($owner_health_total as $key => $total) {
            Redis::hSet('blgov:summary:employee_owner_health:count:' . $yz_townID, $key, $total);
        }

        $this->info("Done at: " . date('Y-m-d H:i:s', time()));
    }
}
