<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enterprise;
use App\TownType;
use App\Industry;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        if($request->user()->enterprise_id) {
            $company = Enterprise::with(['town','industry:IndustryTableID,IndustryName'])->findOrFail($request->user()->enterprise_id);
            return view('company.index', compact('company'));
        }
        return "Access deny";
    }


    public function editOrUpdate(Request $request)
    {
        if ($request->isMethod('GET')){
            if($request->user()->enterprise_id) {
                $company = Enterprise::findOrFail($request->user()->enterprise_id);
                $towns = TownType::all()->pluck('TownName', 'TownID');
                $industries = Industry::select('IndustryTableID', 'IndustryName')->get();
                return view('company.edit', compact('company', 'towns', 'industries'));
            }
            return "Access deny";
        } else if ($request->isMethod('PUT')){
            $data = $request->except('_token', '_method', 's');
            $EmployeesNumber = $data['EmployeesNumber'];
            $BackEmpNumber = $data['BackEmpNumber'];
            $Contacts = $data['Contacts'];
            $OrganizationCode = $data['OrganizationCode'];
            if (!$OrganizationCode){
                return back()->withErrors(['OrganizationCode'=>'组织机构代码不能为空'])->withInput();
            }
            if ($BackEmpNumber > $EmployeesNumber){
                return back()->withErrors(['EmployeesNumber'=>'复工人数不能大于员工人数','BackEmpNumber'=>'复工人数不能大于员工人数'])->withInput();
            }
            
            if ($StartDate = $data['StartDate']){
                if (date('Y-m-d',strtotime($StartDate)) != $StartDate){
                    return back()->withErrors(['StartDate'=>'开工时间错误'])->withInput();
                }
            }
            if (!$Contacts){
                return back()->withErrors(['Contacts'=>'联系人不能为空'])->withInput();
            }
            
            $company = Enterprise::findOrFail($request->user()->enterprise_id);
            if (!$company->update($data)){
                return back()->withErrors(['fail'=>'更新失败'])->withInput();
            }
            return redirect(route('company'));
        }
    }
}
