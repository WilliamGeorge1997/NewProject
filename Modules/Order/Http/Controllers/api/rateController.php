<?php

namespace Modules\Order\Http\Controllers\api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\Admin;
use Modules\Admin\Service\AdminService;
use Modules\Client\Entities\Client;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Service\CouponService;
use Modules\Notification\Service\NotificationService;
use Modules\Order\DTO\OrderDto;
use Modules\Order\Entities\History;
use Modules\Order\Entities\OrderStatus;
use Modules\Order\Http\Requests\OrderRequest;
use Modules\Order\Http\Requests\RateRequest;
use Modules\Order\Service\OrderService;
use Modules\Order\Service\OrderStatusService;
use Modules\Order\Service\RateService;
use Modules\Order\Transformers\HistoryResource;

class rateController extends Controller
{
    private $rateService;
    public function __construct(RateService $rateService)
    {
        $this->middleware(['auth:client']);
        $this->rateService = $rateService;
    }



    public function store(RateRequest $request)
    {
        $rate = $this->rateService->save($request->toArray());
        return return_msg(true, 'Rate Created Successfully', $rate);
    }

    
}
