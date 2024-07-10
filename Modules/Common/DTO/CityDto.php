<?php


namespace Modules\Common\DTO;


class CityDto
{

    public $title;
    public $is_active;

    public function __construct($request)
    {

        $this->title = ['en' => $request->get('title_en'),'ar' => $request->get('title_ar')];
        $this->is_active   = isset($request['is_active']) ? 1 :0;
    }

    public function dataFromRequest()
    {
        $data =  json_decode(json_encode($this), true);
        return $data;
    }

}
