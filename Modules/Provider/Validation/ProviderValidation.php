<?php


namespace Modules\Provider\Validation;


trait ProviderValidation
{
    protected function validateStoreProvider($data)
    {
        return validator($data, [
            'name' => 'required|max:191',
            'phone' => 'required|unique:providers,phone',
            'password' => 'required|min:6|max:191',
        ]);
    }

    protected function validateUpdateProvider($data, $id)
    {
        validator($data, [
            'name' => 'required|max:191',
            'phone' => 'required|unique:providers,phone,' . $id,
        ]);
    }

    protected function validateLogin($data)
    {
        return validator($data, [
            'phone' => 'required|exists:providers,phone',
            'password' => 'required',
        ]);
    }

    protected function validateVerify($data)
    {
        return validator($data, [
            'phone' => 'required|exists:providers,phone',
            'otp' => 'required',
        ]);
    }

    protected function validateForgetPassword($data)
    {
        return validator($data, [
            'phone' => 'required|exists:providers,phone',
        ]);
    }
}
