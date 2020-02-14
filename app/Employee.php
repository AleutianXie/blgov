<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employeeInfoTable';

    public $timestamps = false;

    protected $primaryKey = 'EmployeeID';

    protected $hidden = [
        "Password", "Token"
    ];

    protected $fillable = [
        "EmployeeID",
        "EnterpriseID",
        "DepartmentID",
        "Name",
        "PhoneNumber",
        "Gender",
        "Province",
        "City",
        "District",
        "Street",
        "Address",
        "OutgoingDesc",
        "ContactSituation",
        "LastContactDate",
        "ContactDesc",
        "OwnerHealth",
        "OwnerHealthDesc",
        "RelativesHealth",
        "RelativesHealthDesc",
        "OtherPpersonnelHealth",
        "OtherPpersonnelHealthDesc",
        "IsMedicalObservation",
        "MedicalObservationDesc",
        "MedicalObservationStartDate",
        "MedicalObservationEndDate",
        "MedicalObservationAddress",
        "Account",
        "Password",
        "Token",
        "IsHire",
        "HirerName",
        "HirerPhone",
        "created_at",
        "OutgoingSituation",
        "OwnerStatus",
        "IdCardNumber",
        "DeparturePlace",
        "ReturnTraffic",
        "WorkTraffic",
        "IsLeaveNingbo",
        "IsFever",
        "Desc",
        "ReturnNingBoDate"
    ];

    public function scopeEnterprise($query, $enterprise)
    {
        return $query->where('EnterpriseID', $enterprise);
    }
}
