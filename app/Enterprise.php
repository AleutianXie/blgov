<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TownType;
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

    /**
     * A enterprise can many one report.
     */
    public function employees()
    {
        return $this->hasMany(Employee::class, 'EnterpriseID', 'EnterpriseID');
    }

    /**
     * A enterprise belong to a town.
     */
    public function town()
    {
        return $this->belongsTo(TownType::class, 'TownID', 'TownID');
    }

    /**
     * A enterprise belong to a Industry.
     */
    public function industries()
    {
        return $this->belongsTo(Industry::class, 'IndustryTableID', 'IndustryTableID');
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

    /**
     * just use at gov statistical
     */
    public function users()
    {
        return $this->hasMany(ThreeBack::class, 'EnterpriseID', 'EnterpriseID');
    }
}
