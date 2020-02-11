<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $townTypes = array(
            700001 => '瞻岐镇', // VPDMeGpu
            700002 => '咸祥镇', // cLF3oOam
            700003 => '东吴镇', // bLu4hpaF
            700004 => '塘溪镇', // KUDEIpYo
            700005 => '五乡镇', // xhSZ8WR3
            700006 => '邱隘镇', // CpQ7qnME
            700007 => '云龙镇', // OiUE1jG8
            700008 => '横溪镇', // 3aXiNcyM
            700009 => '姜山镇', // gTwQMfqU
            700010 => '潘火街道', // Y4e5UKq7
            700011 => '福明街道', // ALohZt1V
            700012 => '东柳街道', // nIekGVo8
            700013 => '中河街道', // BD8WqjTk
            700014 => '东郊街道', // NemrHI7L
            700015 => '下应街道', // rgcnPqVt
            700016 => '明楼街道', // LGwXJ6sq
            700017 => '百丈街道', // qUaC9x1P
            700018 => '东胜街道', // 6FlH2sIu
            700019 => '白鹤街道', // iewd3R2U
            700020 => '首南街道', // s6LEdWCB
            700021 => '钟公庙街道'); // YcQER0Ib
        $passwords = array(
            '瞻岐镇' => 'VPDMeGpu',
            '咸祥镇' => 'cLF3oOam',
            '东吴镇' => 'bLu4hpaF',
            '塘溪镇' => 'KUDEIpYo',
            '五乡镇' => 'xhSZ8WR3',
            '邱隘镇' => 'CpQ7qnME',
            '云龙镇' => 'OiUE1jG8',
            '横溪镇' => '3aXiNcyM',
            '姜山镇' => 'gTwQMfqU',
            '潘火街道' => 'Y4e5UKq7',
            '福明街道' => 'ALohZt1V',
            '东柳街道' => 'nIekGVo8',
            '中河街道' => 'BD8WqjTk',
            '东郊街道' => 'NemrHI7L',
            '下应街道' => 'rgcnPqVt',
            '明楼街道' => 'LGwXJ6sq',
            '百丈街道' => 'qUaC9x1P',
            '东胜街道' => '6FlH2sIu',
            '白鹤街道' => 'iewd3R2U',
            '首南街道' => 's6LEdWCB',
            '钟公庙街道' => 'YcQER0Ib');
        $this->command->info('生成乡镇用户.');
        $bar = $this->command->getOutput()->createProgressBar(count($townTypes));
        foreach ($townTypes as $id => $name) {
            $user = [
                'name' => $name,
                'town_id' => $id,
                'password' => bcrypt($passwords[$name]),
                'is_admin' => 1,
            ];

            User::create($user);
            $bar->advance();
        }
        $bar->finish();

        $admins = [
            [
                'name' => '区政府',
                'industry_id_min' => 600001,
                'industry_id_max' => 600026,
                'password' => bcrypt('KoMbEhQm'),
                'is_admin' => 1
            ],
            [
                'name' => '区发改局',
                'industry_id_min' => 600001,
                'industry_id_max' => 600026,
                'password' => bcrypt('r8SzTLZv'),
                'is_admin' => 1
            ],
            [
                'name' => '农业农村局',
                'industry_id_min' => 600001,
                'industry_id_max' => 600005,
                'password' => bcrypt('L2hW9Tqx'),
                'is_admin' => 1
            ],
            [
                'name' => '经信局',
                'industry_id_min' => 600006,
                'industry_id_max' => 600006,
                'password' => bcrypt('L2hW9Tqx'),
                'is_admin' => 1
            ],
            [
                'name' => '住建局',
                'industry_id_min' => 600007,
                'industry_id_max' => 600008,
                'password' => bcrypt('L2hW9Tqx'),
                'is_admin' => 1
            ],
            [
                'name' => '商务局',
                'industry_id_min' => 600009,
                'industry_id_max' => 600015,
                'password' => bcrypt('VBPws5pf'),
                'is_admin' => 1
            ],
            [
                'name' => '金融办',
                'industry_id_min' => 600016,
                'industry_id_max' => 600016,
                'password' => bcrypt('G5lmQNWk'),
                'is_admin' => 1
            ],
            [
                'name' => '文广旅体局',
                'industry_id_min' => 600017,
                'industry_id_max' => 600020,
                'password' => bcrypt('oD1ESC2n'),
                'is_admin' => 1
            ],
            [
                'name' => '交通局',
                'industry_id_min' => 600021,
                'industry_id_max' => 600023,
                'password' => bcrypt('3C2p7s0Y'),
                'is_admin' => 1
            ],
            [
                'name' => '市场监管局',
                'industry_id_min' => 600024,
                'industry_id_max' => 600024,
                'password' => bcrypt('LY0h81sy'),
                'is_admin' => 1
            ],
            [
                'name' => '国资中心',
                'industry_id_min' => 600025,
                'industry_id_max' => 600025,
                'password' => bcrypt('au2oh6NH'),
                'is_admin' => 1
            ],
        ];

        $this->command->info('生成管局用户.');
        $bar = $this->command->getOutput()->createProgressBar(count($admins));
        foreach ($admins as $admin) {
            $user = [
                'name' => $name,
                'town_id' => $id,
                'password' => bcrypt($passwords[$name]),
                'is_admin' => 1,
            ];

            User::create($admin);
            $bar->advance();
        }
        $bar->finish();
    }
}
