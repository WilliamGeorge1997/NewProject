<?php

namespace Modules\Provider\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderServicesRequest extends FormRequest
{
    protected function prepareForValidation()
        {
                $this->merge([
                    'provider_id' => auth('provider')->id(),
                ]);
        }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

             return [
                    'services'=>'required|array',
                    'services.*.id'=>'required|exists:sub_services,id',
                    'services.*.price'=>'required',
//                    'services.*.price_to'=>'required',
                    'services.*.duration'=>'required',
                ];

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
