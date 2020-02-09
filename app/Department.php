<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = "departmentInfoTable";

    public $timestamps = false;

    protected $primaryKey = 'DepartmentID';

    protected $fillable = [
        "DepartmentID",
        "EnterpriseID",
        "DepartmentName",
        "DepartmentContacts",
        "PhoneNumber",
        "PreventionDesc",
        "DepartmentDesc",
        "created_at"
    ];
}
