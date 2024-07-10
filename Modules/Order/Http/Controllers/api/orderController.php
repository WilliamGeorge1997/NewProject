<?php

namespace Modules\Order\Http\Controllers\api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Admin;
use Modules\Client\Entities\Client;
use Modules\Common\Helper\FCMService;
use Modules\Coupon\Entities\Coupon;
use Modules\Notification\Service\NotificationService;
use Modules\Order\DTO\OrderDto;
use Modules\Order\Entities\History;
use Modules\Order\Entities\Order;
use Modules\Order\Http\Requests\OrderRequest;
use Modules\Order\Service\OrderService;
use Modules\Order\Service\OrderStatusService;
use Modules\Order\Transformers\HistoryResource;
use Pusher\Pusher;


class orderController extends Controller
{
    private $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->middleware(['auth:client']);
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $orders = $this->orderService->findBy('client_id', Auth::id(), ['orderStatus', 'details.sub_service','provider'], @$request['paginated']);
        dd($orders);
        return return_msg(true, 'My Orders', $orders);
    }

    public function show($id)
    {
        $orders = $this->orderService->findById($id, ['orderStatus', 'details.sub_service','lastHistory']);
        return return_msg(true, trans('response.Order_Details'), $orders);
    }

    public function store(OrderRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = (new OrderDto($request))->dataFromRequest();
            if ($data['coupon'] ?? null) {
                $response = $this->checkCoupon($data['coupon'],Auth::id(),$data['provider_id']);
                if (!is_int($response)) return $response;
                $data['coupon_id'] = $response;
            }
            $order = $this->orderService->save($data);
            $data['order_id'] = $order->id;
            saveHistory($data, Client::class);

            DB::commit();
            return return_msg(true, 'Order Created Successfully',$order);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function addOrderpusher( $order)
    {
        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
        $pusher->trigger('createOrder-notify-channel', 'Modules\\Order\\Events\\CreateOrderNotify', $order);
    }

    private function checkCoupon($code,$client_id,$provider_id)
    {
        $coupon = Coupon::active()->where('code', $code)->first();
        if (!$coupon) return return_msg(false, 'Coupon Not Found', null, 'not_found');
        if ($coupon['counter'] >= $coupon['num_of_uses']) return return_msg(false, 'Coupon Has been ended', null, 'not_acceptable');
        if (!$coupon->providers()->wherePivot('provider_id', $provider_id)->first()) return return_msg(false, 'Coupon Not Available to this provider', null, 'not_acceptable','api');
        if(Order::whereClientId($client_id)->whereCouponId($coupon->id)->count() >= $coupon['client_uses'] ) return return_msg(false,'Coupon is no longer used for this client', null, 'not_acceptable');
        if ($coupon['date_from'] ?? null && $coupon['date_to'] ?? null) {
            if (!($coupon['date_from'] <= Carbon::today()->toDateString() && $coupon['date_to'] >= Carbon::today()->toDateString())) {
                return return_msg(false, 'Coupon Not Available in this date', null, 'not_acceptable');
            }
        }
        if ($coupon['time_from'] ?? null && $coupon['time_to'] ?? null) {
            if (!($coupon['time_from'] <= Carbon::now()->toTimeString() && $coupon['time_to'] >= Carbon::now()->toTimeString())) {
                return return_msg(false, 'Coupon Not Available in this time', null, 'not_acceptable');
            }
        }
        return $coupon['id'];
    }


    public function destroy($id, Request $request)
    {
        $this->orderService->delete($id);
        return response()->json(['data' => 'success'], 200);
    }

    // to cancel order
    public function cancel(Request $request, $id)
    {
        $this->orderService->update($id, ['order_status_id' => 8]);
        $data = [
            'order_status_id' => 8,
            'order_id' => $id,
            'notes' => @$request['notes'],
            'client_id' => Auth::id()
        ];
        saveHistory($data, Client::class);
        return return_msg(true, 'Order Cancelled Sucessfully');
    }

    public function orderHistory($id)
    {
        $histories = (new OrderService())->history($id);
        $histories = HistoryResource::collection($histories);
        return return_msg(true, 'Order History', $histories);
    }

    public function orderTrack($id)
    {
        $status_ids = (new OrderService())->historyStatusIds($id);
        $statuses = (new OrderService())->historyStatus($id);
        $data['order_id'] = $id;
        $data['duration_time'] = (new OrderService())->findById($id)['duration_time'];
        $data['status_ids'] = $status_ids;
        $data['statuses'] = $statuses;
        $data['last_Status_title'] = (new OrderStatusService())->findById($status_ids[count($status_ids) - 1])->getTranslations('title');
        return return_msg(true, 'Order Track', $data);
    }

}
