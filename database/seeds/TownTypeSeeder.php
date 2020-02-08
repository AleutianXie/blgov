<?php

use App\TownType;
use Illuminate\Database\Seeder;

class TownTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $townTypes = array(
            700001 => '瞻岐镇',
            700002 => '咸祥镇',
            700003 => '东吴镇',
            700004 => '塘溪镇',
            700005 => '五乡镇',
            700006 => '邱隘镇',
            700007 => '云龙镇',
            700008 => '横溪镇',
            700009 => '姜山镇',
            700010 => '潘火街道',
            700011 => '福明街道',
            700012 => '东柳街道',
            700013 => '中河街道',
            700014 => '东郊街道',
            700015 => '下应街道',
            700016 => '明楼街道',
            700017 => '百丈街道',
            700018 => '东胜街道',
            700019 => '白鹤街道',
            700020 => '首南街道',
            700021 => '钟公庙街道');

        $this->command->info('插入townType.');
        $bar = $this->command->getOutput()->createProgressBar(count($townTypes));
        foreach ($townTypes as $id => $name) {
            TownType::create(['TownID' => $id, 'TownName' => $name]);
            $bar->advance();
        }
        $bar->finish();
    }
}
