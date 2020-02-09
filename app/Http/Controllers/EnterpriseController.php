<?php

namespace App\Http\Controllers;

use App\Enterprise;
use App\Report;
use Illuminate\Http\Request;

class EnterpriseController extends Controller
{
    public function detail(Request $request, $id) {
        $enterprise = Enterprise::findOrFail($id);

        dd($enterprise->report);
        return view('enterprise.detail', compact($enterprise));
    }


}
