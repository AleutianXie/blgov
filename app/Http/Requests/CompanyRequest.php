<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'OrganizationCode'  =>  'required|max:100',
            'TownID'            =>  'required',
            'Address'           =>  'required|max:500',
            'Contacts'          =>  'required|max:50',
            'PhoneNumber'       =>  'required|max:50',
            'EnterpriseScale'   =>  'required',
            'IndustryTableID'   =>  'required',
            'Industry'          =>  'required|max:100',
            'EmployeesNumber'   =>  'required|numeric',
            'BackEmpNumber'     =>  'required|numeric',
            'StartDate'         =>  'nullable|date',
            'PreventionDesc'    =>  'required|max:500',

        ];
    }

    public function messages()
    {
        return [
            'OrganizationCode.required' =>  '统一社会信用代码不能为空!',
            'StartDate.date'            =>  '开工时间错误',
            'Contacts.required'         =>  '联系人不能为空',
            'Address.required'          =>  '企业地址不能为空',
            'PhoneNumber.required'      =>  '手机号码不能为空',
            'Industry.required'         =>  '行业细分不能为空',
            'EmployeesNumber.numeric'   =>  '员工人数必须是数字',
            'EmployeesNumber.required'  =>  '员工人数不能为空',
            'BackEmpNumber.numeric'     =>  '复工人数必须是数字',
            'BackEmpNumber.required'    =>  '复工人数不能为空',
            'PreventionDesc.required'   =>  '复工情况说明不能为空',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->compareEmployAndBackEmpNumber($validator)) {
                $validator->errors()->add('BackEmpNumber', '复工人数不能大于员工人数!');
            }
        });
    }

    private function compareEmployAndBackEmpNumber($validator): bool
    {

        $data = $validator->validated();
        if ($data['BackEmpNumber'] > $data['EmployeesNumber']){
            return true;
        }
        return false;
    }
}
