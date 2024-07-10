<?php


namespace Modules\Order\DTO;


use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Order\Entities\Order;

class OrderDto
{

    public $client_id;
    public $coupon;
    public $items;
    public $notes;
    public $provider_id;
    public $reservation_date;
    public $reservation_time;
    public $details;


    public function __construct($request)
    {

        $this->client_id = Auth::id();
        if ($request->get('coupon'))$this->coupon = $request->get('coupon');
        if ($request->get('notes'))$this->notes = $request->get('notes');
        if ($request->get('reservation_date'))$this->reservation_date = $request->get('reservation_date');
        if ($request->get('reservation_time'))$this->reservation_time = $request->get('reservation_time');
        if ($request->get('notes'))$this->notes = $request->get('notes');
        $this->provider_id = $request->get('provider_id');
        $this->details = $request->get('details');
    }

    public function dataFromRequest()
    {
        $data =  json_decode(json_encode($this), true);
        $data['order_no'] = $this->generateOrderNo();
        $data['order_status_id'] = 1;
        return array_filter($data);
    }



//    private function getOrderNumber()
//    {
//        $latestOrder = Order::orderBy('created_at','DESC')->first();
//        $lastId = $latestOrder != null ? $latestOrder->id+1 : 1;
//        // return '#' . str_pad($lastId, 6, "0", STR_PAD_LEFT);
//        return '#0' . $lastId;
//    }



    private function generateOrderNo()
    {
        $serial = 'WD-';
        $today_orders_count = Order::whereDate('created_at', Carbon::today())->count() + 1;
        $serial .= 100 - date("y");
        $serial .= 100 - date("m");
        $serial .= 100 - date("d");
        $serial .= str_pad($today_orders_count, 4, '0', STR_PAD_LEFT);
        return $serial;
    }

}
