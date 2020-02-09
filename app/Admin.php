<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'adminInfoTable';

    protected $hidden = [
        "Password", "Token"
    ];

    public $timestamps = false;

    protected $primaryKey = 'userID';

    protected $fillable = [
        "userID",
        "Account",
        "Password",
        "Name",
        "PhoneNumber",
        "UserType",
        "Token",
        "Status",
        "IsHire",
        "HirerName",
        "HirerPhone",
        "CreaterAt",
        "TownID"
    ];
}
