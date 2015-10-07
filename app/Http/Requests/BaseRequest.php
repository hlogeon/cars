<?php
/**
 * Created by PhpStorm.
 * User: hlogeon
 * Date: 10/7/15
 * Time: 2:40 PM
 */

namespace App\Http\Requests;


class BaseRequest extends Request{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }

}