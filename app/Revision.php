<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    protected $table = 'report_revision';

    protected $fillable = [
        'report_id', 'version', 'status', 'comment', 'report_at', 'docs'
    ];
}
