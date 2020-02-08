<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    protected $table = 'enterpriseInfoTable';

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
        "Industry"
    ];
}
