<?php

namespace Modules\Common\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Modules\Client\Entities\Client;
use Modules\Common\Entities\Setting;
use Illuminate\Support\Facades\Mail;
use App\Mail\contactUs;
use Modules\Common\Http\Requests\ContactUsRequest;
use Spatie\Activitylog\Models\Activity;

class CommonController extends Controller
{
    public function setting()
    {
        $settings = Setting::all();
        return view('common::setting.index', ['settings' => $settings]);
    }

    public function savesetting(Request $request)
    {
        $data = $request->except('_token');
        foreach ($data as $key => $datum) {
            if ($key == 'logo' && isset($datum)) {
                $old_image = Setting::where('key', 'logo')->first()['value'];
                File::delete(public_path('uploads/setting/' . $old_image));
                $image = $request->file('logo');
                $imageName = $this->upload($image, 'setting');
                $datum = $imageName;
            }
            Setting::where('key', $key)->update(['value' => $datum]);
        }
        return back()->with('updated', 'updated');
    }

    public function logs()
    {
        $logs = Activity::with('causer')->latest()->paginate(50);
        return view('common::logs.index', compact('logs'));
    }
    public function viewOrderNotify(Request $request)
    {
        return redirect()->to("admin/orders/$request->OrderId");

    }
//     public function test()
//     {
//         ini_set('max_execution_time', 5000); //3 minutes
//         foreach (User::cursor() as $user) {
//             if(!Client::wherePhone($user->mobile)->first()){
//                 Client::create([
//                     'name' => $user->fname . ' ' . $user->lname,
//                     'phone' => $user->mobile,
//                     'password' => bcrypt($user->copypassword),
//                     'is_active' => $user->active,
//                 ]);
//                 $user->delete();
//             }
//
//         }
//         return 'Done';
//     }
}
