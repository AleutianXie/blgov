<?php
namespace App\Library\Utils;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * Description of Uploader
 *
 * @author
 */
class Uploader
{

    /**
     * 上传图片，返回服务器文件地址。
     *
     * @param Illuminate\Http\UploadedFile $file    //$request对象中的文件
     * @return string
     * @throws UploadValidatorException
     */
    public static function uploadImage(UploadedFile $file)
    {
        $validator = Validator::make(
            ['file'=>$file],
            ['file'=>'required|file|mimes:jpeg,jpg,gif,png,pdf,doc,docx,xls,xlsx,ppt,pptx|max:100000']
        );

        if ($validator->fails()) {
            throw new UploadValidatorException($validator);
        }

        $filename = md5($file->getClientOriginalName()) .'.'. $file->getClientOriginalExtension();

        return Storage::url($file->storeAs('public', $filename));
    }
}
