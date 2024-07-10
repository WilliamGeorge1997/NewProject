<?php

namespace Modules\Admin\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Client\Entities\Client;

class ClientReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'prevent-back-history', 'permission:Index-report']);
    }

    public function clinetReport()
    {
        $popularClients = Client::withCount('orders')->orderByDesc('orders_count')->take(10)->get();
        return view('admin::reports.clients', compact('popularClients'));
    }


    public function clinetChart(Request $request)
    {
        $to = Carbon::parse($request['to']);
        $from = Carbon::parse($request['from']);
        // get client data from database and pass them to collection
        $clients = Client::query()->whereBetween('created_at', array($from, $to));
        // get number of difference days in dates
        $difference_in_days = $from->diffInDays($to);
        for ($x = 0; $x < $difference_in_days; $x++) {
            $total_all_clients_count[$x] = (clone $clients)->whereDate('created_at', $from->toDateString())->count();
            $total_active_clients_count[$x] = (clone $clients)->whereDate('created_at', $from->toDateString())->where('is_active', 1)->count();
            $total_in_active_clients_count[$x] = (clone $clients)->whereDate('created_at', $from->toDateString())->where('is_active', 0)->count();
            $dates[$x] = $from->format('m/d');
            $from->addDays(1);
        }
        return response()->json(['dates' => $dates, 'total_all_clients_count' => $total_all_clients_count, 'total_active_clients_count' => $total_active_clients_count, 'total_in_active_clients_count' => $total_in_active_clients_count]);
    }

    public function clinetChartOld(Request $request)
    {
        $to = Carbon::parse($request['to']);
        $from = Carbon::parse($request['from']);
        // get client data from database and pass them to collection
        $clients = collect(Client::query()->whereBetween('created_at', array($from, $to))->get());
        // get number of difference days in dates
        $difference_in_days = $from->diffInDays($to);
        for ($x = 0; $x <= $difference_in_days; $x++) {
            $total_all_clients_count[$x] = $clients->filter(function ($client) use ($from) {
                return $client->created_at->isSameDay($from);
            })->count();
            $total_active_clients_count[$x] = $clients->filter(function ($client) use ($from) {
                return $client->created_at->isSameDay($from);
            })->where('is_active', 1)->count();
            $total_in_active_clients_count[$x] = $clients->filter(function ($client) use ($from) {
                return $client->created_at->isSameDay($from);
            })->where('is_active', 0)->count();
            $dates[$x] = $from->format('m/d');
            $from->addDays(1);
        }

        return response()->json(['dates' => $dates, 'total_all_clients_count' => $total_all_clients_count, 'total_active_clients_count' => $total_active_clients_count, 'total_in_active_clients_count' => $total_in_active_clients_count]);
    }
}
