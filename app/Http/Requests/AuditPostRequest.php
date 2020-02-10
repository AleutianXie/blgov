<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuditPostRequest extends FormRequest
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
            'comment' => 'required',
            'status' => 'required|integer|min:2|max:3',
        ];
    }

    public function attributes()
    {
        return [
            'comment' => '审批意见',
            'status' => '审批状态',
        ];
    }
}
