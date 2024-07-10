<?php


namespace Modules\Notification\Service;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Common\Helper\UploaderHelper;
use Modules\Notification\Entities\Notification;
use Modules\Order\Entities\OrderMethod;

class NotificationService
{
   
    use UploaderHelper;

    function findAll(){
        return Notification::all();
    }


    function findById($id){
        return Notification::findOrFail($id);
    }

    function findBy($key, $value)
    {
        return Notification::with('notifiable')->where($key, $value)->get();
    }

    function NotificationsInAdminPanel()
    {
        return Notification::groupBy('group_by')->whereNull('order_id')->select('id','group_by','created_at','title', DB::raw('count(*) as total'),DB::raw("count(DISTINCT(read_at)) as readCount"))->get();
    }

    function save($data,$model)
    {
            if (request()->hasFile('image')){
            $image = request()->file('image');
            $imageName = $this->upload($image, 'notification');
            $data['image'] = $imageName;
        }
        
        Notification::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => @$data['image'],
            'notifiable_id' => @$data['user_id'],
            'notifiable_type' => $model,
            'order_id' => @$data['order_id'],
            'group_by' => @$data['group_by']
        ]);
    }

   
}
