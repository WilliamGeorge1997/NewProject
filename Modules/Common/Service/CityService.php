<?php


namespace Modules\Common\Service;


use Modules\Country\Entities\City;

class CityService
{
    function findAll($relation=[]){
        return City::with($relation)->get();

    }

    function active(){
        return City::active()->get();
    }


    function findById($id){
        return City::findOrFail($id);
    }

    function findBy($key, $value)
    {
        return City::where($key, $value)->get();
    }

    function save($data){
        return City::create($data);
    }

    function update($id,$data){
        $City = $this->findById($id);
        $City->update($data);
        return $City;
    }

    function activate($id){
        $City = $this->findById($id);
        $City->is_active = !$City->is_active;
        $City->save();
    }
    function delete($id)
    {
        $City = $this->findById($id);
        $City->delete();
    }


}
