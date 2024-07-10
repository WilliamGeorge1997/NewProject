<?php

namespace Modules\Order\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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

                    'details' => 'required|array',
                    'details.*.quantity' => 'required',
                    'details.*.sub_service_id' => 'required|exists:sub_services,id',
                ];
            }
        else{
            return [
                'cancel' => 'nullable',
                'next' => 'nullable',
                'order_id' => 'required',
                'order_status_id' => 'required',

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
