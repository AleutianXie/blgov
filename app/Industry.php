<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $table = 'industryTable';

    protected $fillable = [
        'IndustryTableID', 'IndustryName', 'MajorIndustry'
    ];
}
