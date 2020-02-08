<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'adminInfoTable';

    protected $hidden = [
        "Password", "Token"
    ];

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
        "CreaterAt"
    ];
}
