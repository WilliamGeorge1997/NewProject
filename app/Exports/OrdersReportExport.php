<?php

namespace App\Exports;

use Illuminate\Http\Request;
use Modules\Order\Entities\Order;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersReportExport implements FromArray
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function array(): array
    {
    
        $orders = [];
        $relations = ['branch', 'orderStatus', 'orderMethod', 'paymentMethod'];
        $ordersCollection = Order::with($relations)->when(!empty($this->request->from_date) && !empty($this->request->to_date), function ($query) {
            $query->whereDate('created_at', '>', $this->request->from_date)->whereDate('created_at', '<', $this->request->to_date);
        })
            ->when($this->request->order_method_id, function ($query)  {
                $query->whereOrderMethodId($this->request['order_method_id']);
            })
            ->when($this->request->payment_method_id, function ($query) {

                $query->wherePaymentMethodId($this->request['payment_method_id']);
            })
            ->when($this->request->order_status_id, function ($query)  {
                $query->whereOrderStatusId($this->request['order_status_id']);
            })
            ->when($this->request->branch_id, function ($query) {
                $query->whereBranchId($this->request['branch_id']);
            })
            ->latest()
            ->get();

        $orders[] = ['رقم الطلب', 'الفرع', 'حالة الطلب', 'طريقة الطلب', 'طريقة الدفع', 'الاجمالى'];
        $orders[] = [' ', ' ', ' ', ' ', ' ', ' '];
        foreach ($ordersCollection as $order) {
            $orders[] = [$order->uuid, $order->branch->title, $order->orderStatus->title, $order->orderMethod->title, $order->paymentMethod->title, $order->subtotal];
        }
        return $orders;
    }
}
