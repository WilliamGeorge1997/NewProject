<?php


namespace Modules\Order\Service;


use Modules\Common\Helper\UploaderHelper;
use Modules\Order\Entities\OrderRequest;

class OrderRequestService
{
    use UploaderHelper;

    function findAll($relation = [],$data = [])
    {
        $orders = OrderRequest::query()->orderBy('id','desc')->with($relation);
        return getCaseCollection($orders, $data);
    }

    function findById($id, $relation = [])
    {
        return OrderRequest::with($relation)->findOrFail($id);
    }

    function findBy($key, $value, $relation = [], $paginate = null)
    {
        if ($paginate ?? null) {
            return OrderRequest::latest()->with($relation)->where($key, $value)->when(request('status') ?? null, function ($q) {
                return $q->where('status', request('status'));
            })->paginate($paginate);
        }
        return OrderRequest::latest()->with($relation)->where($key, $value)->when(request('status') ?? null, function ($q) {
            return $q->where('status', request('status'));
        })->get();
    }

    function save($data)
    {
        if (request()->hasFile('image')){
            $image = request()->file('image');
            $imageName = $this->upload($image, 'order_request');
            $data['image'] = $imageName;
        }
        $order = OrderRequest::create($data);
        return $order;
    }

    function update($id, $data)
    {
        $Order = $this->findById($id);
        $Order->update($data);
        return $Order;
    }


}
