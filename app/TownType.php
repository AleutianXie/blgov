<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TownType extends Model
{
    protected $table = 'townTypeTable';

    public $timestamps = false;

    protected $primaryKey = 'TownID';

    protected $fillable = [
        'TownID', 'TownName'
    ];
}
