<?php

namespace Modules\Service\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ServiceRequest extends FormRequest
{

    protected function prepareForValidation()
        {
            if(isset($this->is_active) ){
                $this->merge([
                    'is_active' => 1,
                    ]);
            }else{
                $this->merge([
                    'is_active' => 0,
                    ]);
            }
        }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
             return [
                    'title_ar'=>'required|max:191',
                    'title_en'=>'required|max:191',
                    'category_id'=>'required|exists:categories,id',
                    'order'=>'required',
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

    public function passedValidation()
    {
        $this->merge([
        'title' => ['en' => $this->title_en,'ar' => $this->title_ar],
        ]);

    }
}
