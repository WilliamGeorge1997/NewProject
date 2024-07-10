<?php


namespace Modules\Client\Validation;


trait ClientValidation
{
    protected function validateStoreClient($data)
    {
        return validator($data, [
            'name' => 'required|max:191',
            'phone' => 'required|unique:clients,phone',
            'password' => 'required|min:6|max:191',
        ]);
    }

    protected function validateUpdateClient($data, $id)
    {
        return validator($data, [
            'name' => 'required|max:191',
            'phone' => 'required|unique:clients,phone,' . $id,
        ]);
    }

    protected function validateLogin($data)
    {
        return validator($data, [
            'phone' => 'required|exists:clients,phone',
            'password' => 'required',
            'lang' => 'sometimes|in:ar,en'
        ]);
    }

    protected function validateVerify($data)
    {
        return validator($data, [
            'phone' => 'required|exists:clients,phone',
            'otp' => 'required',
        ]);
    }

    protected function validateForgetPassword($data)
    {
        return validator($data, [
            'phone' => 'required|exists:clients,phone',
        ]);
    }
}
