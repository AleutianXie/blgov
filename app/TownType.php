<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TownType extends Model
{
    protected $table = 'townTypeTable';

    protected $fillable = [
        'TownID', 'TownName'
    ];
}
