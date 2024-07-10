<?php


namespace Modules\Service\Service;

use Illuminate\Support\Facades\File;
use Modules\Common\Helper\UploaderHelper;
use Modules\Service\Entities\SubService;

class SubServiceService
{
    use UploaderHelper;
    function findAll($data = [] , $relation=[]){
        $subservices = SubService::query()->when($data['service_id'] ?? null , function ($q) use($data){
            $q->where('service_id' , $data['service_id']);
        })->
        with($relation)->orderByDesc('id');
        return getCaseCollection($subservices, $data);

    }

    function active(){
        return SubService::active()->get();
    }


    function findById($id){
        return SubService::findOrFail($id);
    }

    function findBy($key, $value,$relation=[])
    {
        return SubService::where($key, $value)->with($relation)->get();
    }



    function save($data){
        if (request()->hasFile('image')){
            $image = request()->file('image');
            $imageName = $this->upload($image, 'service');
            $data['image'] = $imageName;
        }
        return SubService::create($data);
    }

    function update($id,$data){
        $SubService = $this->findById($id);
        if (request()->hasFile('image')){
            File::delete(public_path('uploads/service/'.$this->getImageName('service',$SubService->image)));
            $image = request()->file('image');
            $imageName = $this->upload($image, 'service');
            $data['image'] = $imageName;
        }
        $SubService->update($data);
        return $SubService;
    }

    function activate($id){
        $SubService = $this->findById($id);
        $SubService->is_active = !$SubService->is_active;
        $SubService->save();
    }
    function delete($id)
    {
        $SubService = $this->findById($id);
        $SubService->delete();
    }

}
