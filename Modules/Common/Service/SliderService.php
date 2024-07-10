<?php


namespace Modules\Common\Service;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Common\Entities\Slider;
use Modules\Common\Helper\UploaderHelper;

class SliderService
{
    use UploaderHelper;
    function findAll()
    {
        return Slider::all();
    }

    function active()
    {
        return Slider::active()->get();
    }

    function findById($id)
    {
        return Slider::findOrFail($id);
    }

    function findBy($key, $value)
    {
        return Slider::where($key, $value)->get();
    }

    function save($data)
    {
        if (request()->hasFile('image')) {
            $image = request()->file('image');
            $imageName = $this->upload($image, 'slider');
            $data['image'] = $imageName;
        }
        return Slider::create($data);
    }

    function update($id, $data)
    {
        $Slider = $this->findById($id);
        if (request()->hasFile('image')) {
            File::delete(public_path('uploads/slider/' . $this->getImageName('slider', $Slider->image)));
            $image = request()->file('image');
            $imageName = $this->upload($image, 'slider');
            $data['image'] = $imageName;
        }
        $Slider->update($data);
        return $Slider;
    }

    function activate($id)
    {
        $Slider = $this->findById($id);
        $Slider->is_active = !$Slider->is_active;
        $Slider->save();
    }
    function delete($id)
    {
        $Slider = $this->findById($id);
        File::delete(public_path('uploads/slider/' . $this->getImageName('slider', $Slider->image)));
        $Slider->delete();
    }

   
}
