<?php

namespace Modules\Common\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CityRequest extends FormRequest
{
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
