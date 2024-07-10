<?php


namespace Modules\Order\Service;


use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Branch\Entities\Branch;
use Modules\Branch\Entities\DeliveryCharge;
use Modules\Branch\Service\BranchService;
use Modules\Client\Entities\Client;
use Modules\Client\Service\ClientService;
use Modules\Client\Service\PointService;
use Modules\Common\Helper\FCMService;
use Modules\Country\Entities\SubZone;
use Modules\Country\Entities\Zone;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Service\CouponService;
use Modules\Notification\Service\NotificationService;
use Modules\Order\Entities\History;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderDetails;
use Modules\Order\Entities\orderDetailsAttribute;
use Modules\Order\Entities\OrderMethod;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductAttribute;
use Modules\Product\Entities\ProductAttributeValue;
use Modules\Product\Service\ProductService;
use Modules\Service\Entities\SubService;

class OrderService
{

    function findAll($relation = [],$data = [])
    {
        $orders = Order::query()->when($data['branch_id'] ?? null, function ($q) use ($data) {
            $q->where('branch_id', $data['branch_id']);
        })->when($data['order_status_id'] ?? null, function ($q) use ($data) {
            $q->where('order_status_id', $data['order_status_id']);
        })->when($data['order_no'] ?? null, function ($q) use ($data) {
            $q->where('order_no', $data['order_no']);
        })->when($data['from_date'] ?? null, function ($q) use ($data) {
            $q->whereDate('created_at', '>=', $data['from_date']);
        })->when($data['to_date'] ?? null, function ($q) use ($data) {
            $q->whereDate('created_at', '<=', $data['to_date']);
        })

            ->with($relation)->orderByDesc('id');
        return getCaseCollection($orders, $data);
    }

    function findById($id, $relation = [])
    {
        return Order::with($relation)->findOrFail($id);
    }

    function DriverOrders($driver_id, $order_Status_id = null, $paginate, $relation = [])
    {
        return Order::with($relation)->whereDriverId($driver_id)
            ->when($order_Status_id ?? null, function ($q) use ($order_Status_id) {
                return $q->whereOrderStatusId($order_Status_id);
            })
            ->paginate($paginate);
    }

    function findBy($key, $value, $relation = [], $paginate = null)
    {
        if ($paginate ?? null) {
            return Order::query()->withCount('rate')->latest()->with($relation)->where($key, $value)->when(request('status') ?? null, function ($q) {
                return $q->whereIn('order_status_id', request('status'));
            })->paginate($paginate);
        }
        return Order::query()->withCount('rate')->latest()->with($relation)->where($key, $value)->when(request('status') ?? null, function ($q) {
            return $q->whereIn('order_status_id', request('status'));
        })->get();
    }

    function save($data)
    {
        $order = Order::create($data);
        $this->storeOrderDetails($order, $data['details']);
        $order = $this->calcOrderDetails($order, @$data['points_discount']);
        return $order;
    }




    function update($id, $data)
    {
        $Order = $this->findById($id);
        if (isset($data['order_status_id']) && $data['order_status_id'] == 5 && $Order['client_id'] ?? null) {
            // if order delivered successfully so now add points
            $checkSavedPoints = (new PointService())->findBy('order_id', $id);
            //check if points added before to this order
            if ($checkSavedPoints->count() < 1) {
                $pointsData = [
                    'client_id' => $Order->client_id,
                    'order_id' => $Order->id,
                    'points' => (int) $Order->subtotal,
                ];
                (new PointService())->save($pointsData);
            }
        }
        $Order->update($data);
        return $Order;
    }

    function delete($id)
    {
        $Order = $this->findById($id);
        $Order->delete();
    }

    function returnDiscount($order)
    {
        if ($order['discount_type'] == 1 && $order['coupon_id'] ?? null) {
            $coupon = (new CouponService())->findById($order['coupon_id']);
            $coupon->counter--;
            $coupon->save();
        } else if ($order['discount_type'] == 2) {
            $client = (new ClientService())->findById($order['client_id']);
            $client->balance += $order['discount'];
            $client->save();
        }
    }

    function storeOrderDetails($order, $details)
    {
        foreach ($details as $detail) {

            $price = SubService::query()->where('id',$detail['sub_service_id'])->first()['price'];
            $order_details = OrderDetails::create([
                'order_id' => $order->id,
                'sub_service_id' => $detail['sub_service_id'],
                'total' => $price * $detail['quantity'],
                'price' => $price,
                'quantity' => $detail['quantity'],
                'note' => isset($detail['note']) ? $detail['note'] : null
            ]);

        }
    }


    function calcOrderDetails($order,$points_discount,$orders_count = 1)
    {

        $data = [
            'subtotal' => $this->calcOrderSubTotal($order),
            'total' => $this->calcOrderTotal($order,$points_discount,$orders_count),
            'quantity' => $this->calcOrderQuantity($order)
        ];

        $order->update($data);
        return $order->fresh();
    }

    function calcOrderSubTotal($order)
    {
        return $order->details()->sum('total');
    }
    function calcOrderQuantity($order)
    {
        return $order->details()->sum('quantity');
    }

    function calcOrderTotal($order,$points_discount,$orders_count=1)
    {
        $base_total =  $order->details()->sum('total');
        $discount = 0;

        if ($order['coupon_id'] ?? null) {
            $coupon = Coupon::findOrFail($order['coupon_id']);
            $discount = $coupon->discount($base_total);

            $order->discount_type = Order::DISCOUNT_WITH_COUPON;
        } else {

            if ($points_discount) {
                // check if client has balance in his account
                $client = (new ClientService())->findById($order->client_id);
                if ($client['balance'] > 0) {
                    $order->discount_type = Order::DISCOUNT_WITH_POINTS;
                    // $discount = min($client['balance'], ($base_total + $tax + $delivery_fee));
                    $discount = min($client['balance'], ($base_total ));
                    $client->update(['balance' => $client['balance'] - $discount]);
                }
            }
        }
        $order->discount = $discount;

        $base_tax = getSetting('tax');
//        $tax = ( ($base_total + $delivery_fee - $discount) * $base_tax) / 100;
        $tax = ( ($base_total ) * $base_tax) / 100;
        $order->tax = $tax;

        $order->save();
        $total = $base_total + $tax - $discount;
        return $total >= 0 ? $total : 0;
    }


    function history($order_id)
    {
        return History::with('status')->whereOrderId($order_id)->get();
    }

    function historyStatusIds($order_id)
    {
        return History::whereOrderId($order_id)->pluck('order_status_id');
    }
    function historyStatus($order_id)
    {
        return History::with('status:id,title')->select('id', 'order_status_id', 'created_at')->whereOrderId($order_id)->get();
    }

}
