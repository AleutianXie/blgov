<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enterprise;
use App\TownType;
use App\Industry;
use App\Http\Requests\CompanyRequest;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        if($request->user()->enterprise_id) {
            $company = Enterprise::with(['town','industries:IndustryTableID,IndustryName'])
                ->findOrFail($request->user()->enterprise_id);
            return view('company.index', compact('company'));
        }
        return "Access deny";
    }


    public function edit(Request $request)
    {
        if($request->user()->enterprise_id) {
            $company = Enterprise::findOrFail($request->user()->enterprise_id);
            $towns = TownType::all()->pluck('TownName', 'TownID');
            $industries = Industry::select('IndustryTableID', 'IndustryName')->get();
            return view('company.edit', compact('company', 'towns', 'industries'));
        }
        return "Access deny";
    }

    public function update(CompanyRequest $request)
    {
        $data =  $request->validated();
        $company = Enterprise::findOrFail($request->user()->enterprise_id);
        if (!$company->update($data)){
            return back()->withErrors(['fail'=>'更新失败'])->withInput();
        }
        return redirect(route('company'));
    }
}
