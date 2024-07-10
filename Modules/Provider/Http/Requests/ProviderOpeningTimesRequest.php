<?php

namespace Modules\Provider\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderOpeningTimesRequest extends FormRequest
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
                    'times'=>'required|array',
                    'times.*.day'=>'required|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday',
                    'times.*.open_at'=>'nullable',
                    'times.*.close_at'=>'nullable',
                    'times.*.is_holiday'=>'required',
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
