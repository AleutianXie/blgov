<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    protected $table = 'enterpriseInfoTable';

    public $timestamps = false;

    protected $primaryKey = 'EnterpriseID';

    protected $hidden = [
        "Password", "Token"
    ];

    protected $fillable = [
        "EnterpriseID",
        "EnterpriseName",
        "District",
        "Address",
        "StartDate",
        "Contacts",
        "PhoneNumber",
        "PreventionDesc",
        "EnterpriseScale",
        "EmployeesNumber",
        "Account",
        "Password",
        "Token",
        "BackEmpNumber",
        "ProductingPlan",
        "TownID",
        "Industry",
        "IndustryTableID",
        "OrganizationCode",
        "GovUnitName"
    ];

    /**
     * A enterprise can have one report.
     */
    public function report()
    {
        return $this->hasOne(Report::class, 'enterprise_id')->orderByDesc('report_at');
    }

    public function scopeReportStatus($query, $status)
    {
        return $query->whereHas('report', function ($query) use ($status) {
            return $query->where('status', $status);
        });
    }

    public function scopeIndustry($query, $industry)
    {
        return $query->where('IndustryTableID', $industry);
    }
}
