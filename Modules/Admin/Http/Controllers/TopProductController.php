<?php

namespace Modules\Admin\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Branch\Entities\Branch;
use Modules\Product\Entities\Product;

class TopProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'prevent-back-history', 'permission:Index-report']);
    }

    public function productReport(Request $request)
    {
        $productsreport = Product::withCount('orderDetails')
            ->withSum('orderDetails', 'total')->orderByDesc('order_details_count')
            ->whereHas('orderDetails.order', function ($query) use ($request) {
                $query->whereOrderStatusId('5');
                if (!empty($request->branch))
                    $query->whereBranchId($request->branch);
                if (!empty($request->from_date) && !empty($request->to_date))
                    $query->whereDate('created_at', '>', $request->from_date)->whereDate('created_at', '<', $request->to_date);
            })
            ->paginate(50);

        return view('admin::reports.products', ['Branches' => Branch::get(), 'productsreport' => $productsreport]);
    }
}
