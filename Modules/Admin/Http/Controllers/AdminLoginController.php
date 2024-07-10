<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use Illuminate\Support\Facades\File;
use Modules\Admin\Service\AdminService;
use Modules\Common\Helper\UploaderHelper;

class AdminLoginController extends Controller
{
    use ValidatesRequests,UploaderHelper;

    public function __construct()
    {
        $this->middleware('guest:admin',['except' => ['logout','EditProfile','updateProfile']]);
    }
    public function showLoginForm()
    {
        return view('admin::login');
    }

    public function login(Request $request){
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if (Auth::guard('admin')->attempt(['email' => $request['email'],'password' => $request['password'],'is_active' => 1],$request->remember)){
            return redirect()->intended(route('admin.dashboard'));
        }
        return redirect()->back()->withInput($request->only('email','remember'));

    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function EditProfile(){
        $admin = (new AdminService())->findById(\Illuminate\Support\Facades\Auth::id());
        return view('admin::editProfile',compact('admin'));
    }

    public function updateProfile(Request $request){
        $data = $request->except('_token');
        $admin = (new AdminService())->findById(\Illuminate\Support\Facades\Auth::id());
        if (request()->hasFile('image')){
            File::delete(public_path('uploads/admin/'.$admin->image));
            $image = request()->file('image');
            $imageName = $this->upload($image, 'admin');
            $data['image'] = $imageName;
        }
        if ($data['password'] ?? null){
            $data['password'] =  bcrypt($request->get('password'));
        }
        $data = array_filter($data);
        $admin->update($data);
        return redirect()->intended(route('admin.dashboard'));
    }
}
