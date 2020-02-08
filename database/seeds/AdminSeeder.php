<?php

use App\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->command->info('插入admin.');
        $admin = [
            "userID" => 500021,
            "Account" => '18829357321',
            "Password" => '',
            "Name" => 'admin',
            "PhoneNumber" => '18829357321',
            "UserType" => 1,
            "Token" =>'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyIwIjoiMTg4MjkzNTczMjEiLCIxIjoxNTgxMDA0Mjc4LCJleHAiOjE1ODEwMTE0Nzh9.CKzsFjh56MdZ4csyFOHCzzlendphuB6y94o4g8F0DwY500021',
            "Status" => 1,
            "IsHire" => 1,
            "HirerName" => '',
            "HirerPhone" => '',
            "CreaterAt" => '2020-02-06 23:51:14'
        ];
        Admin::create($admin);
    }
}
