<?php


namespace Modules\Common\DTO;


class SliderDto
{

    public $title;
    public $description;
    public $image;
    public $is_active;

    public function __construct($request)
    {

        $this->title = ['en' => $request->get('title_en'),'ar' => $request->get('title_ar')];
        $this->description = ['en' => $request->get('description_en'),'ar' => $request->get('description_ar')];
        if ($request->hasFile('image')) $this->image   = $request->file('image');
        $this->is_active   = isset($request['is_active']) ? 1 :0;
    }

    public function dataFromRequest()
    {
        $data =  json_decode(json_encode($this), true);
        if ($data['image'] == null) unset($data['image']);
        return $data;
    }

}
