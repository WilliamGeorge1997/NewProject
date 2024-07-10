<?php


namespace Modules\Client\DTO;


class ClientDto
{

    public $name;
    public $phone;
    public $gender;
    public $city_id;
    public $password;
    public $verify_code;
    public $image;
    public $balance;
    public $is_active;

    public function __construct($request)
    {

        $this->name = $request->get('name');
        $this->phone = $request->get('phone');
        $this->gender = $request->get('gender');
        $this->city_id = $request->get('city_id');
        $this->balance = $request->get('balance');
        if ($request->get('password')) $this->password =  bcrypt($request->get('password'));
        if ($request->hasFile('image')) $this->image   = $request->file('image');
        $this->is_active   = isset($request['is_active']) ? 1 :0;
    }

    public function dataFromRequest()
    {
        $data =  json_decode(json_encode($this), true);
        if ($data['password'] == null) unset($data['password']);
        if ($data['balance'] == null) unset($data['balance']);
        if ($data['image'] == null) unset($data['image']);
//         $data['verify_code'] = rand(1000,9999);
        $data['verify_code'] = 9999;
        return $data;
    }

}
