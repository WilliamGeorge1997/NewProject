<?php

namespace Modules\Admin\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Client\Entities\Client;
use Modules\Driver\Entities\Driver;

class DriverReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'prevent-back-history','permission:Index-report']);
    }

    public function driverReport(){
        $popularDrivers = Driver::withCount('orders')->orderByDesc('orders_count')->take(10)->get();
        return view('admin::reports.drivers',compact('popularDrivers'));
    }
    

    public function driverChart(Request $request){
         $to = Carbon::parse($request['to']);
         $from = Carbon::parse($request['from']);
         // get client data from database and pass them to collection
        $drivers = Driver::query()->whereBetween('created_at',array($from,$to));
         // get number of difference days in dates
        $difference_in_days = $from->diffInDays($to);
        for ($x = 0; $x < $difference_in_days; $x++) {
            $total_all_drivers_count[$x] = (clone $drivers)->whereDate('created_at',$from->toDateString())->count();
            $total_active_drivers_count[$x] = (clone $drivers)->whereDate('created_at',$from->toDateString())->where('is_active',1)->count();
            $total_in_active_drivers_count[$x] = (clone $drivers)->whereDate('created_at',$from->toDateString())->where('is_active',0)->count();
            $dates[$x] = $from->format('m/d');
            $from->addDays(1);
        }
        return response()->json(['dates'=>$dates,'total_all_drivers_count' => $total_all_drivers_count,'total_active_drivers_count' => $total_active_drivers_count,'total_in_active_drivers_count' => $total_in_active_drivers_count]);
    }

  }
