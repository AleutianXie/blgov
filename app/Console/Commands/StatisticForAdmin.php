<?php

namespace App\Console\Commands;


use Illuminate\Support\Facades\Redis;
use Illuminate\Console\Command;
use App\Report;

class StatisticForAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistic:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update admin statistic data';

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
        $town_id = range(700001, 700021);

        $this->comment("Update admin statistic data : " . date('Y-m-d H:i:s', time()). " ".time());
        
        foreach ($town_id as $id) {
            $json = $this->handleDbData($id);
            Redis::hSet('blgov:statistic:town_ids', $id, $json);
        }
        // $区政府    = [600001,600026]
        $json = $this->handleDbData(null, [600001,600026]);
        Redis::hSet('blgov:statistic:admins', "600001600026", $json);
        // $农业农村局  = [600001,600005]
        $json = $this->handleDbData(null, [600001,600005]);
        Redis::hSet('blgov:statistic:admins', "600001600005", $json);
        // $经信局    = [600006,600006]
        $json = $this->handleDbData(null, [600006,600006]);
        Redis::hSet('blgov:statistic:admins', "600006600006", $json);
        // $住建局    = [600007,600008]
        $json = $this->handleDbData(null, [600007,600008]);
        Redis::hSet('blgov:statistic:admins', "600007600008", $json);
        // $商务局    = [600009,600015]
        $json = $this->handleDbData(null, [600009,600015]);
        Redis::hSet('blgov:statistic:admins', "600009600015", $json);
        // $金融办    = [600016,600016]
        $json = $this->handleDbData(null, [600016,600016]);
        Redis::hSet('blgov:statistic:admins', "600016600016", $json);
        // $文广旅体局  = [600017,600020]
        $json = $this->handleDbData(null, [600017,600020]);
        Redis::hSet('blgov:statistic:admins', "600017600020", $json);
        // $交通局    = [600021,600023]
        $json = $this->handleDbData(null, [600021,600023]);
        Redis::hSet('blgov:statistic:admins', "600021600023", $json);
        // $市场监管局  = [600024,600024]
        $json = $this->handleDbData(null, [600024,600024]);
        Redis::hSet('blgov:statistic:admins', "600024600024", $json);
        // $国资中心   = [600025,600025]
        $json = $this->handleDbData(null, [600025,600025]);
        Redis::hSet('blgov:statistic:admins', "600025600025", $json);
        $this->info("Done at: " . date('Y-m-d H:i:s', time()). " ".time());
        
    }

    private function handleDbData(int $town_id = null, array $industry_id = [])
    {
        $model = Report::with(['enterpry:EnterpriseID,BackEmpNumber,EmployeesNumber']);

        if ($town_id) {
            $model->where('town_id', $town_id);
        }

        if ($industry_id) {
             $model->industryBetween($industry_id[0], $industry_id[1]);
        }

        $data = $model->get()->pluck('enterpry');

        $BackEmpNumber = $data->sum('BackEmpNumber');
        $EmployeesNumber = $data->sum('EmployeesNumber');
        $isNeedMedicalObservation = 0;
        $outgoingDesc = [];
        $contactSituation = [
            'isContactSituation' => 0,
            'notContactSituation' => 0,
        ];
        $wu = 0; //0
        $hubei = 0;//1
        $wenzhou = 0;//2
        $taizhou = 0;//3
        $other = 0;//4

        $users = [];
        foreach ($data->pluck('users') as $key => $value) {
            if ($value) {
                $users = array_merge($users, $value->toArray());   
            }
        }
        foreach ($users as $k => $v) {
            switch ($v['OutgoingSituation']) {
                case 0:
                    $wu += 1;
                    break;
                case 1:
                    $hubei += 1;
                    break;
                case 2:
                    $wenzhou += 1;
                    break;
                case 3:
                    $taizhou += 1;
                    break;
                case 4:
                    $other += 1;
                    break;
            }
            if ($v['IsMedicalObservation']) {
                $isNeedMedicalObservation += 1;
            }

            if ($v['OutgoingDesc']) {
                $outgoingDesc[$v['OutgoingDesc']] = ($outgoingDesc[$v['OutgoingDesc']] ?? 0) + 1;
            }

            if ($v['ContactSituation']) {
                $contactSituation['isContactSituation'] += 1;
            } else {
                $contactSituation['notContactSituation'] += 1;
            }
        }

        $datas = [
            'BackEmpNumber' => $BackEmpNumber,
            'EmployeesNumber' => $EmployeesNumber,
            'isNeedMedicalObservation' => $isNeedMedicalObservation,
            'outgoingDesc' => $outgoingDesc,
            'contactSituation' => $contactSituation,
            'wu' => $wu,
            'hubei' => $hubei,
            'wenzhou' => $wenzhou,
            'taizhou' => $taizhou,
            'other' => $other,
        ];
        return json_encode($datas);
    }
}
