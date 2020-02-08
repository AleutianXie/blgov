<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    protected $table = 'conditionInfoTable';

    public $timestamps = false;

    protected $primaryKey = 'ConditionID';

    protected $fillable = [
        "ConditionID",
        "EmployeeID",
        "RecordingTime",
        "ObservationDay",
        "Temperature",
        "MeasuringTime",
        "Symptom",
        "SymptomDesc"
    ];
}
