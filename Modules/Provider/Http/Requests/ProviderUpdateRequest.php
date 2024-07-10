<?php

namespace Modules\Provider\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ProviderUpdateRequest extends FormRequest
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

            if(isset($this->work_on_home) ){
                $this->merge([
                    'work_on_home' => 1,
                ]);
            }else{
                $this->merge([
                    'work_on_home' => 0,
                ]);
            }

            if(isset($this->work_on_salon) ){
                $this->merge([
                    'work_on_salon' => 1,
                ]);
            }else{
                $this->merge([
                    'work_on_salon' => 0,
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
                    'description_ar'=>'required',
                    'description_en'=>'required',
                    'phone' => 'required|unique:providers,phone,'.auth('provider')->id(),
                    'about_ar'=>'required',
                    'about_en'=>'required',
                    'website'=>'required|url',
                    'address'=>'required|string',
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
        'description' => ['en' => $this->description_en,'ar' => $this->description_ar],
            'about' => ['en' => $this->about_en,'ar' => $this->about_ar],

        ]);

    }
}
