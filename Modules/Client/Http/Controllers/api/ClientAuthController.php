<?php

namespace Modules\Client\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Modules\Client\DTO\ClientDto;
use Modules\Client\Entities\Client;
use Modules\Client\Service\ClientService;
use Modules\Client\Validation\ClientValidation;
use Modules\Common\Helper\SMSService;

class ClientAuthController extends Controller
{
    use ClientValidation;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:client', ['except' => ['login', 'register', 'verifyOtp', 'forgetPassword', 'verifyForgetPassword', 'newPassword']]);
    }

    public function login(Request $request)
    {

        $credentials = $request->only(['phone', 'password']);
        $credentials['is_active'] = 1;
        $validation = $this->validateLogin($credentials);
        if ($validation->fails()) return return_msg(
            false,
            'Validation Errors',
            ['validation_errors' => $validation->getMessageBag()],
            'validation_error'
        );
        if (!$token = auth('client')->attempt($credentials)) {
            return return_msg(false, 'Unauthorized', null, 'unauthorized');
        }
        if (auth('client')->user()['is_active'] == 0) {
            // send verify message
            return return_msg(false, 'Not Active need verify', null, 'temporary_redirect');
        }
        if ($request['fcm_token'] ?? null) {
            auth('client')->user()->update(['fcm_token' => $request->fcm_token]);
        }
        if($request['lang'] ?? null){
            auth('client')->user()->update(['lang'=>$request->lang]);
        }
        return $this->respondWithToken($token);
    }

    public function register(Request $request, ClientService $clientService)
    {

        $data = $request->all();
        $validation = $this->validateStoreClient($data);
        if ($validation->fails()) return return_msg(
            false,
            'Validation Errors',
            ['validation_errors' => $validation->getMessageBag()],
            'validation_error'
        );
        $data = (new ClientDto($request))->dataFromRequest();
        $client = $clientService->save($data);
//        $smsService = new SMSService();
//        $smsService->sendSMS($client->phone, $client->verify_code);
        return return_msg(true, 'Client Registered Successfully', $client);
    }

    public function verifyOtp(Request $request, ClientService $clientService)
    {
        $data = $request->all();
        $validation = $this->validateVerify($data);
        if ($validation->fails()) return return_msg(
            false,
            'Validation Errors',
            ['validation_errors' => $validation->getMessageBag()],
            'validation_error','api'
        );
        $client = $clientService->findBy('phone', $data['phone'])[0];
        if ($client && $client['verify_code'] == $data['otp']) {
            $clientService->update($client->id, ['is_active' => 1]);

            $token = auth('client')->login($client);
            if ($request['fcm_token'] ?? null) {
                auth('client')->user()->update(['fcm_token' => $request->fcm_token]);
            }
            if($request['lang'] ?? null){
                auth('client')->user()->update(['lang'=>$request->lang]);
            }
            return $this->respondWithToken($token);
        }
        return return_msg(false, 'Wrong OTP', null, 'unauthorized');
    }

    public function forgetPassword(Request $request, ClientService $clientService)
    {
        $data = $request->all();
        $validation = $this->validateForgetPassword($data);
        if ($validation->fails()) return return_msg(
            false,
            'Validation Errors',
            ['validation_errors' => $validation->getMessageBag()],
            'validation_error'
        );
        $client = $clientService->findBy('phone', $data['phone'])[0];
//        $verify_code = rand(1000,9999);
//         $clientService->update($client->id,['verify_code'=>$verify_code]);
        $clientService->update($client->id, ['verify_code' => 8888]);
//        $smsService = new SMSService();
//        $smsService->sendSMS($client->phone, $client->verify_code);
        return return_msg(true, 'Message Sent, please check your phone');
    }

    public function verifyForgetPassword(Request $request, ClientService $clientService)
    {
        $data = $request->all();
        $validation = $this->validateVerify($data);
        if ($validation->fails()) return return_msg(
            false,
            'Validation Errors',
            ['validation_errors' => $validation->getMessageBag()],
            'validation_error'
        );
        $client = $clientService->findBy('phone', $data['phone'])[0];
        if ($client && $client['verify_code'] == $data['otp']) {
            return return_msg(true, 'Valid OTP');
        }
        return return_msg(false, 'Wrong OTP', null, 'unauthorized');
    }

    public function newPassword(Request $request, ClientService $clientService)
    {
        $data = $request->all();
        $validation = $this->validateLogin($data);
        $client = $clientService->findBy('phone', $data['phone'])[0];
        // $clientService->update($client->id,['verify_code'=>rand(1000,9999)]);
        $clientService->update($client->id, ['password' => bcrypt($data['password'])]);

        return return_msg(true, 'Password Changed Successfully');
    }


    public function me()
    {
        exit;
        return return_msg(true, 'Logged User', auth('client')->user());
        //        return response()->json(auth()->user());
    }


    public function logout()
    {
        // Client::whereId(\auth('employee')->id())->update(['is_login'=>0]);
        auth('client')->logout();
        return return_msg(true, 'Successfully logged out');
        //        return response()->json(['message' => 'Successfully logged out']);
    }


    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('client')->factory()->getTTL() * 60,
            'client' => \auth('client')->user(),
        ];
        return return_msg(true, 'Authenticated User', $data);
    }
}
