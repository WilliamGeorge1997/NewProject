<?php

namespace Modules\Order\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Branch\Entities\Branch;
use Modules\Order\Entities\OrderStatus;
use Modules\Order\Service\OrderMethodService;



class orderStatusController extends Controller
{

    public function index(Request $request)
    {

        $status = OrderStatus::query()->when($request['ids'] ?? null,function ($query) use ($request){
            $query->whereIn('id', $request['ids']);
        })->select('id', 'title')->get();

        return return_msg(true, 'Order Statuses', $status);
    }
}
