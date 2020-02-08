<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $table = 'industryTable';

    public $timestamps = false;

    protected $primaryKey = 'IndustryTableID';

    protected $fillable = [
        'IndustryTableID', 'IndustryName', 'MajorIndustry'
    ];
}
