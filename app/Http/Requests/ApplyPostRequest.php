<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ApplyPostRequest extends FormRequest
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
        if (Route::currentRouteName() == 'enterprise.post') {
            return [
                'town' => 'required|exists:townTypeTable,TownID',
                'file1' => 'required|mimes:jpeg,png,pdf,doc,docx,xlsx,xls',
                'file2' => 'required|mimes:jpeg,png,pdf,doc,docx,xlsx,xls',
                'file3' => 'required|mimes:jpeg,png,pdf,doc,docx,xlsx,xls',
                'file4' => 'mimes:rar,zip',
            ];
        }

//        if (Route::currentRouteName() == 'admin.product.edit') {
//            $id = $this->route('id');
//            return [
//                'name'      => 'required|unique:products,name,' . $id . ',id,deleted_at,NULL',
//                'summary'   => 'required',
//                'cover'     => 'image',
//                //'content'   => 'required',
//                'sort'      => 'required|integer|min:0',
//                'is_top'    => 'required|boolean',
//                'series_id' => 'required|exists:series,id,deleted_at,NULL'
//            ];
//        }
    }

    public function attributes()
    {
        return [
            'town' => '乡镇',
            'file1' => '《企业（单位）复工申请（承诺）表》',
            'file2' => '《企业（单位）返工人员调查总表》',
            'file3' => '《企业（单位）复工防疫方案》',
            'file4' => '附件',
        ];
    }
}
