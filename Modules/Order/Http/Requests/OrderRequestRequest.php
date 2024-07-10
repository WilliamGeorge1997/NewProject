<?php

namespace Modules\Order\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequestRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (Request::isMethod('post'))
            {
                return [
                    'description' => 'required_without:image|string',
                    'image' => 'required_without:description|image|mimes:jpeg,png,jpg,gif|max:2048',
                   'address_id' => 'required|exists:addresses,id',
                ];
            }
        else{
            return [

            ];

        }

    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
