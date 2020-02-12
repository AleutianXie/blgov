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
            'OrganizationCode'  => 'required|max:100',
            'TownID'            => 'required',
            'Address'           => 'nullable|max:500',
            'Contacts'          => 'required|max:50',
            'PhoneNumber'       => 'nullable|max:50',
            'EnterpriseScale'   => 'required',
            'IndustryTableID'   => 'required',
            'Industry'          => 'nullable|max:100',
            'EmployeesNumber'   => 'nullable',
            'BackEmpNumber'     => 'nullable',
            'StartDate'         => 'nullable|date',
            'PreventionDesc'    => 'nullable',

        ];
    }

    public function messages()
    {
        return [
            'OrganizationCode.required' => '组织机构代码不能为空!',
            'StartDate.date'            => '开工时间错误',
            'Contacts.required'         => '联系人不能为空',
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
