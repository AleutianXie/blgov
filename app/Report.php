<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'report';

    protected $fillable = [
        'enterprise_id', 'town_id', 'version', 'status', 'comment', 'report_at', 'docs'
    ];

    public function revisions()
    {
        return $this->hasMany(Revision::class, 'report_id')->orderByDesc('version');
    }

    public function enterprise()
    {
        return $this->hasOne(Enterprise::class, 'EnterpriseID', 'enterprise_id');
    }
}
