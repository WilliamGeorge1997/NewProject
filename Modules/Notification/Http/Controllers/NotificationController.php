<?php

namespace Modules\Notification\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Client\Entities\Client;
use Modules\Client\Service\ClientService;
use Modules\Common\Helper\FCMService;
use Modules\Notification\Entities\Notification;
use Modules\Notification\Http\Requests\NotificationRequest;
use Modules\Notification\Service\NotificationService;
use Modules\Notification\ViewModel\NotificationViewModel;

class NotificationController extends Controller
{
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->middleware(['auth:admin', 'prevent-back-history']);
        $this->notificationService = $notificationService;
        $this->middleware('permission:Index-notification|Create-notification', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create-notification', ['only' => ['create', 'store']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $notifications = $this->notificationService->NotificationsInAdminPanel();
            return response()->json(['data' => $notifications]);
        }
        return view('notification::notifications.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $viewModel = new NotificationViewModel();
        return view('notification::notifications.create', compact('viewModel'));
    }

    public function store(NotificationRequest $request)
    {
        $data = $request->except('_token');
        $data['title'] = ['en' => $request->get('title_en'), 'ar' => $request->get('title_ar')];
        $data['description'] = ['en' => $request->get('description_en'), 'ar' => $request->get('description_ar')];
        $data['group_by'] = $this->getGroupByCounter();


        //all clients is checked
        if (isset($data['all_clients'])) {
            $clients_ids = Client::active()->whereNotNull('fcm_token')->pluck('id')->all();
            if (count($clients_ids) == 0) {
                return redirect()->back();
            }
            foreach ($clients_ids as $value) {
                $data['user_id'] = $value;
                $this->notificationService->save($data, Client::class);
            }
            $clients_tokens = Client::active()->where('allow_notification',1)->whereNotNull('fcm_token')->pluck('fcm_token')->all();
            $fcm = new FCMService;
            $fcm->sendNotification($data, $clients_tokens);
            return redirect('/admin/notifications')->with('created', 'created');
        } //all Clients Checkbox is not checked
        else {
            if (!isset($data['clients'])) {
                return redirect()->back();
            }
            foreach ($data['clients'] as $key => $value) {
                $data['user_id'] = $value;
                $this->notificationService->save($data, Client::class);
            }
            $clients_tokens = Client::active()->where('allow_notification',1)->whereNotNull('fcm_token')->whereIn('id', $data['clients'])->pluck('fcm_token')->all();
            $fcm = new FCMService;
            $fcm->sendNotification($data, $clients_tokens);
            return redirect('/admin/notifications')->with('created', 'created');
        }
    }

    public function readNotification($id)
    {
        $notification = $this->notificationService->findById($id);
        $notification->update(['read_at' => Carbon::now()]);
        return redirect('/admin/orders/' . $notification->order_id);
    }

    function getGroupByCounter()
    {
        $lastGroupBy = Notification::whereNotNull('group_by')->latest()->first();
        if ($lastGroupBy) return $lastGroupBy['group_by'] + 1;
        else return 1;
    }

    public function destroy($id)
    {
        $notification_number = Notification::findOrFail($id);
        if ($notification_number->group_by ?? null) {

            Notification::whereGroupBy($notification_number->group_by)->delete();
        } else {
            $notification_number->delete();
        }
        return response()->json(['data' => 'success'], 200);
    }

    function getCityClients($id = null)
    {
        if (!$id) {
            $clients = (new ClientService)->activeFcm();
            return response()->json($clients);
        }
        $clients = Client::where('city_id', $id)
            ->whereNotNull('fcm_token')
            ->get();
        return response()->json($clients);
    }
}
