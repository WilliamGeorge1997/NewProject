<?php


namespace Modules\Client\Service;


use Modules\Client\Entities\Car;

class CarService
{
    function findAll(){
        return Car::all();
    }

    function findById($id){
        return Car::findOrFail($id);
    }

    function findBy($key, $value)
    {
        return Car::where($key, $value)->get();
    }

    function save($data){
        return Car::create($data);
    }

    function delete($id)
    {
        $Car = $this->findById($id);
        $Car->delete();
    }

}
