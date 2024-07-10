<?php

namespace Modules\Client\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Client\DTO\ClientDto;
use Modules\Client\Service\ClientService;
use Modules\Order\Entities\Order;

class ClientController extends Controller
{

    private $clientService;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(ClientService $clientService)
    {
        $this->middleware('auth:client')->only('changeLang','deActivate','statics','updateProfile');
        $this->clientService = $clientService;
    }

    public function changeLang()
    {
        $this->clientService->changeLang(Auth::id());
        return return_msg(true,'Language Changed Successfully');
    }

    public function deActivate()
    {
        $this->clientService->update(Auth::id(),['is_active' => 0]);
        return return_msg(true,'Client DeActivated Successfully');
    }

    public function updateProfile(Request $request)
    {
        $data = $request->only('name','gender');
        $this->clientService->update(Auth::id(),$data);
        return return_msg(true,'Client Updated Successfully');
    }

    public function statics()
    {
        $client = Auth::user();
        $data['balance'] = $client['balance'];
        $data['orders_count'] = Order::whereClientId($client['id'])->count();
        $data['opened_orders_count'] = Order::whereClientId($client['id'])->whereIn('order_status_id',[1,2,3,4,6])->count();
        $data['closed_orders_count'] = Order::whereClientId($client['id'])->whereIn('order_status_id',[5,7,8])->count();
        return return_msg(true,'Client Statics',$data);
    }

}
