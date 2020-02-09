<?php

namespace App\Http\Controllers;

use App\Enterprise;
use App\Report;
use Illuminate\Http\Request;

class EnterpriseController extends Controller
{
    public function detail(Request $request, $id) {
        $enterprise = Enterprise::findOrFail($id);

        return view('enterprise.detail', compact($enterprise));
    }

    /**
     * A enterprise can have one report.
     */
    public function report()
    {
        return $this->hasOne(Report::class);
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
