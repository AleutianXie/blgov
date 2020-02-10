<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    protected $table = 'report_revision';

    protected $fillable = [
        'report_id', 'town_id', 'version', 'status', 'comment', 'docs'
    ];
}
