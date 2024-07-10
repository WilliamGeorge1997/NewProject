<?php

namespace Modules\Common\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SliderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (request()->isMethod('POST')) {
            return [

                'title_ar' => 'required|max:191',
                'title_en' => 'required|max:191',
                'description_ar' => 'required',
                'description_en' => 'required',
                'image' => 'required'
            ];
        } 
        else 
        {
            return [

                'title_ar' => 'required|max:191',
                'title_en' => 'required|max:191',
                'description_ar' => 'required',
                'description_en' => 'required',
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

    public function passedValidation()
    {
        $this->merge([
            'title' => ['en' => $this->title_en, 'ar' => $this->title_ar],
            'description' => ['en' => $this->description_en, 'ar' => $this->description_ar],
        ]);
    }
}
