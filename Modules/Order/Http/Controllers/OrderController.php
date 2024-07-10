<?php

namespace Modules\Order\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\Admin;
use Modules\Client\Entities\Client;
use Modules\Client\Service\ClientService;
use Modules\Common\Helper\FCMService;
use Modules\Driver\Entities\Driver;
use Modules\Driver\Service\DriverService;
use Modules\Notification\Service\NotificationService;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderDetails;
use Modules\Order\Http\Requests\OrderRequest;
use Modules\Order\Service\OrderService;
use Modules\Order\Service\OrderStatusService;
use Modules\Order\ViewModel\OrderViewModel;

class OrderController extends Controller
{
    private $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->middleware(['auth:admin', 'prevent-back-history']);
        $this->orderService = $orderService;
        $this->middleware('permission:Index-order|Edit-order', ['only' => ['index']]);
        $this->middleware('permission:Edit-order', ['only' => ['edit', 'update']]);
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $data['paginated'] = 50;
        $relation = ['orderStatus' , 'provider'];
        $orders = $this->orderService->findAll($relation, $data);
        if ($request->ajax()) {
            return response()->json(['data' => $orders->items()]);
        }
        $viewModel = new OrderViewModel();
        return view('order::orders.index', ['orders' => $orders, 'viewModel' => $viewModel , 'request' => $request->all()]);
    }
    public function branchDrivers($branch_id)
    {
        $drivers = Driver::Active()
            //        ->where('branch_id', $branch_id)
            ->get();
        return response()->json($drivers);
    }
    public function show($id)
    {

        $relation = [

            // 'statuses.employee:id,name','statuses.status','paymentMethod', 'branch','city','address','driver', 'branch'
            'orderStatus',
            'details.product',
            'details.attributes.attribute',
            'details.attributes.attributeValue',
            'histories.historible',
            'histories.status',
            'client',
            'coupon',
            'provider'
        ];
        $order = $this->orderService->findById($id, $relation);
        $viewModel = new OrderViewModel();
        return view('order::orders.show', ['order' => $order, 'viewModel' => $viewModel]);
    }

    public function edit($id)
    {
        $viewModel = new OrderViewModel();
        $order = $this->orderService->findById($id);
        return view('order::orders.edit', compact('viewModel', 'order'));
    }

    // to change status from Admin Panel
    public function update(OrderRequest $request)
    {

        if ($request->has('next')) {
            $request['order_status_id'] = $request->next;

        } else if ($request->has('cancel')) {
            $request['order_status_id'] = 8;
        }
        $id = $request->order_id;
        $data = array_filter(['order_status_id' => $request['order_status_id'], 'driver_id' => @$request['driver_id']]);
        $order = $this->orderService->update($id, $data);
        if ($order->order_status_id == 8) {
            $this->orderService->returnDiscount($order);
        }
        $data = [
            'order_status_id' => $request['order_status_id'],
            'order_id' => $id,
            'notes' => @$request['notes'],
            'client_id' => Auth::id()
        ];
        saveHistory($data, Admin::class);
        if ($order['client_id'] ?? null)
            $this->sendNotificationToClient($id, $order->client_id, $request['order_status_id'], $order->order_method_id, $order->uuid);
        if ($request['order_status_id'] == 3 && isset($request['driver_id'])) {
            // send notification to driver
            $this->sendNotificationToDriver($id, $request['driver_id']);
        }
        return redirect('admin/orders')->with('updated', 'updated');
    }

    public function destroy($id)
    {
        $data = ['order_status_id' => 5, 'notes' => $request['notes'] ?? null];
        $this->orderService->update($id, $data);
        // $this->orderService->delete($id);
        return response()->json(['data' => 'success'], 200);
    }

    public function repeatOrderCronJob()
    {
        $this->orderService->repeatOrderCronJob();
        return response()->json(['data' => 'success'], 200);
    }

    function sendNotificationToClient($order_id, $client_id, $status_id, $order_method_id, $uuid = null)
    {
        $order = Order::query()->where('id', $order_id)->first();
        if ($status_id == 5) {
            // if order is Done then rate order
            $status = (new OrderStatusService())->findById($status_id);
            // $data['title'] = ['en' => 'Rate Service','ar' => 'تقيم الخدمة'];
            $data['title'] = ['en' => 'Your review makes the difference', 'ar' => 'تقييمك يصنع الفرق'];
            // $data['description'] = ['en' => 'Please Rate Service for order number ' . $order_id,'ar' => ' نرجو منك تقييم الخدمة للطلب رقم ' . $order_id];
            $data['description'] = ['en' => 'We care about your opinion and how satisfied you are with our service', 'ar' => 'يهمنا رائيك و مدى رضاك عن خدمتنا'];
            $data['order_id'] = $order_id;
            $data['uuid'] = $uuid;
            $data['user_id'] = $client_id;
            $data['order_method_id'] = $order_method_id;
            $data['type'] = 2; // refer to rate
            (new NotificationService())->save($data, Client::class);
        } else {
            $status = (new OrderStatusService())->findById($status_id);
            // $data['title'] = ['en' => 'Change Order Status','ar' => 'تغير حالة الطلب'];
            $data['title'] = ['en' => 'Your order status now', 'ar' => 'حالة طلبك الان'];
            $data['description'] = ['en' => 'Change Order Status Number ' . $order['order_no'] . ' to ' . $status->getTranslation('title', 'en'), 'ar' => 'تغير حالة الطلب رقم ' . $order['order_no'] . 'الي ' . $status->getTranslation('title', 'ar')];
            $data['order_id'] = $order_id;
            $data['uuid'] = $uuid;
            $data['order_method_id'] = $order_method_id;
            $data['user_id'] = $client_id;
            $data['type'] = 1; // refer to normal order status
            (new NotificationService())->save($data, Client::class);
        }

        $fcm = new FCMService;
        $client_token = (new ClientService())->findToken($client_id);
        if ($client_token ?? null)
            $fcm->sendNotification($data, [$client_token]);
    }
    function sendNotificationToDriver($order_id, $driver_id)
    {
        $order = Order::query()->where('id', $order_id)->first();

        $data['title'] = ['en' => 'New Order', 'ar' => 'طلب جديد'];
        $data['description'] = ['en' => ' Order Number ' . $order['order_no'] . ' Need to Deliver ', 'ar' => ' الطلب رقم ' . $order['order_no'] . 'يحتاج الي التوصيل '];
        $data['order_id'] = $order_id;
        $data['user_id'] = $driver_id;
        (new NotificationService())->save($data, Driver::class);
        $fcm = new FCMService;
        $driver_token = (new DriverService())->findToken($driver_id);
        if ($driver_token ?? null)
            $fcm->sendNotification($data, [$driver_token]);
    }
}
