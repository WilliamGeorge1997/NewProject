<?php


namespace Modules\Coupon\DTO;


class CouponDto
{

    public $code;
    public $num_of_uses;
    public $is_active;
    public $type;
    public $value;
    public $limit;
    public $client_uses;
    public $date_from;
    public $date_to;
    public $time_from;
    public $time_to;
    public $providers;
    public $discount_on;

    public function __construct($request)
    {

        if ($request->get('code'))$this->code = $request->get('code');
        if ($request->get('num_of_uses'))$this->num_of_uses = $request->get('num_of_uses');
        if ($request->get('client_uses'))$this->client_uses = $request->get('client_uses');
        if ($request->get('type'))$this->type = $request->get('type');
        if ($request->get('discount_on'))$this->discount_on = $request->get('discount_on');
        if ($request->get('value'))$this->value = $request->get('value');
        if ($request->get('limit'))$this->limit = $request->get('limit');
        if ($request->get('date_from'))$this->date_from = $request->get('date_from');
        if ($request->get('date_to'))$this->date_to = $request->get('date_to');
        if ($request->get('time_from'))$this->time_from = $request->get('time_from');
        if ($request->get('time_to'))$this->time_to = $request->get('time_to');
        if ($request->get('providers'))$this->providers = $request->get('providers');
        $this->is_active   = isset($request['is_active']) ? 1 :0;
    }

    public function dataFromRequest()
    {
        $data =  json_decode(json_encode($this), true);
       $data = array_filter($data);
        $data['is_active']   = isset($data['is_active']) ? 1 :0;
        return $data;
    }

}
