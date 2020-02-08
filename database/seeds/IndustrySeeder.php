<?php

use App\Industry;
use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $industries = array(
            'IT服务' => array(
                '互联网',
                '游戏',
                '软件',
                '电商',
                '网络游戏',
                '计算机软件',
                '电子',
                '通信',
                '硬件'),
            '房地产' => array(
                '建筑',
                '物业',
                '金融',
                '消费品',
                '汽车',
                '机械',
                '制造',
                '制药',
                '医疗',
                '能源'),
            '服务' => array(
                '化工',
                '环保',
                '服务',
                '外包',
                '中介',
                '广告',
                '传媒',
                '教育',
                '文化',
                '交通',
                '贸易',
                '物流',
                '政府',
                '农林牧渔')
        );

        $this->command->info('插入Industry.');
        foreach ($industries as $major => $value) {
            $this->command->info('插入' . $major . '\n');
            $bar = $this->command->getOutput()->createProgressBar(count($value));
            foreach ($value as $IndustryName) {
                Industry::create(['MajorIndustry' => $major, 'IndustryName' => $IndustryName]);
                $bar->advance();
            }
            $bar->finish();
        }
    }
}
