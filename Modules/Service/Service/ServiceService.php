<?php


namespace Modules\Service\Service;

use Modules\Service\Entities\Service;

class ServiceService
{
    function findAll($data = [], $relation = [])
    {
        $services = Service::query()->when($data['category_id'] ?? null, function ($q) use ($data) {
            $q->where('category_id', $data['category_id']);
        })->
            with($relation)->orderByDesc('id');
        return getCaseCollection($services, $data);

    }

    function active()
    {
        return Service::active()->get();
    }


    function findById($id)
    {
        return Service::findOrFail($id);
    }

    function findBy($key, $value, $relation = [])
    {
        return Service::where($key, $value)->with($relation)->get();
    }



    function save($data)
    {
        return Service::create($data);
    }

    function update($id, $data)
    {
        $Service = $this->findById($id);
        $Service->update($data);
        return $Service;
    }

    function activate($id)
    {
        $Service = $this->findById($id);
        $Service->is_active = !$Service->is_active;
        $Service->save();
    }
    function delete($id)
    {
        $Service = $this->findById($id);
        $Service->delete();
    }

}
