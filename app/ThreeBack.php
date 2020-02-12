<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThreeBack extends Model
{
    // 三返
    
    protected $table = 'employeeInfoTable';

    public $timestamps = false;

    protected $primaryKey = 'EnterpriseID';
}
