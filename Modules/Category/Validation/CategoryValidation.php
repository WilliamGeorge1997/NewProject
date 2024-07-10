<?php


namespace Modules\Category\Validation;


use Modules\Category\Rules\CategoryImageRequired;

trait CategoryValidation
{
    protected function validateStore($data){
        return validator($data,[
            'title_ar'=>'required|max:191',
            'title_en'=>'required|max:191',
            'image' => [
                'required',
                'image',
            ],

            'order'=>'required',
        ]);

    }

    protected function validateUpdate($data){
        return validator($data,[
            'title_ar'=>'required|max:191',
            'title_en'=>'required|max:191',
            'order'=>'required',
        ]);

    }

}
