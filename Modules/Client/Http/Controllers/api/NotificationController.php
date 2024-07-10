<?php

namespace Modules\Client\Http\Controllers\api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Modules\Client\Entities\Client;
use Modules\Client\Entities\Favourite;
use Modules\Client\Http\Requests\FavouriteRequest;
use Modules\Client\Service\FavouriteService;
use Modules\Notification\Entities\Notification;

class NotificationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:client');
    }

   public function index()
   {
    return return_msg(true,'Client Notifications',Auth::user()->notifications()->select('id','title','description','order_id','image','created_at','read_at')->orderByDesc('id')->paginate(5));
   }

    public function allow_notification()
    {
        $user = Auth::user();
        $user->allow_notification = !$user->allow_notification;
        $user->save();
        return return_msg(true,'Client Updated Successfully');
    }

   public function readNotification(Request $request)
   {
        Notification::whereIn('id',$request['notifications_ids'])->update(['read_at' =>Carbon::now()]);
        return return_msg(true,'Notification read successfully');
   }

   public function unReadNotificationsCount()
   {
    $unReadCount = Notification::whereNull('read_at')->whereHasMorph('notifiable',[Client::class],function($query){
                        $query->where('notifiable_id',Auth::id())->whereNull('order_id');
                    })->count();
    return return_msg(true,'un Read Notifications Count',$unReadCount);
   }
}
