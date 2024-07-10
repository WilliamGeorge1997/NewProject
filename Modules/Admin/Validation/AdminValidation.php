<?php


namespace Modules\Admin\Validation;


trait AdminValidation
{
    protected function validateStore($data){
        return validator($data,[
            'name'=>'required|max:191',
            'email'=>'required|unique:admins,email',
            'phone' => 'required',
            'password' => 'required',
        ]);

    }

    protected function validateUpdate($data,$id){
        return validator($data,[
            'name'=>'required|max:191',
            'email'=>'required|unique:admins,email,'.$id,
            'phone' => 'required',
        ]);

    }

}
