<?php

namespace Modules\Admin\Http\Controllers;

use App\Exports\OrdersReportExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Order\Entities\Order;
use Illuminate\Routing\Controller;
use Modules\Branch\Entities\Branch;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Order\Entities\OrderMethod;
use Modules\Order\Entities\OrderStatus;
use Modules\Order\Entities\PaymentMethod;
use Modules\Admin\ViewModel\AdminViewModel;

class OrdersReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'prevent-back-history', 'permission:Index-report']);
    }

    public function ordersReport(Request $request)
    {
        session(['report_request' => $request->all()]);
        $orders = Order::when(!empty($request->from_date) && !empty($request->to_date), function ($query) use ($request) {
            $query->whereDate('created_at', '>', $request->from_date)->whereDate('created_at', '<', $request->to_date);
        })
            ->when($request->order_method_id, function ($query) use ($request) {
                $query->whereOrderMethodId($request['order_method_id']);
            })
            ->when($request->payment_method_id, function ($query) use ($request) {

                $query->wherePaymentMethodId($request['payment_method_id']);
            })
            ->when($request->order_status_id, function ($query) use ($request) {
                $query->whereOrderStatusId($request['order_status_id']);
            })
            ->when($request->branch_id, function ($query) use ($request) {
                $query->whereBranchId($request['branch_id']);
            })
            ->latest();

        $orders_count = $orders->count();
        $orders_sum = $orders->sum('total');
        $orders = $orders->paginate(50);
        $viewModel = new AdminViewModel();

        return view('admin::reports.orders', compact('orders', 'viewModel', 'orders_count','orders_sum'));
    }
    public function exportExcel()
    {
        $request = new Request(session('report_request'));

        return Excel::download(new OrdersReportExport($request), 'orders.xlsx');
    }
}
