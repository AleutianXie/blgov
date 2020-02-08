<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = "departmentInfoTable";

    protected $fillable = [
        "DepartmentID",
        "EnterpriseID",
        "DepartmentName",
        "DepartmentContacts",
        "PhoneNumber",
        "PreventionDesc",
        "DepartmentDesc"
    ];
}
