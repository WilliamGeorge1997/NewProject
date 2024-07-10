<?php

namespace Modules\Provider\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Modules\Provider\Service\ProviderService;
use Modules\Provider\Validation\ProviderValidation;

class ProviderAuthController extends Controller
{
    use ProviderValidation;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:provider', ['except' => ['login', 'register', 'verifyOtp', 'forgetPassword', 'verifyForgetPassword', 'newPassword']]);
    }

    public function login(Request $request)
    {

        $credentials = $request->only(['phone', 'password']);
//         $credentials['is_active'] = 1;
        $validation = $this->validateLogin($credentials);
        if ($validation->fails()) return return_msg(
            false,
            'Validation Errors',
            ['validation_errors' => $validation->getMessageBag()],
            'validation_error'
        );
        if (!$token = auth('provider')->attempt($credentials)) {
            return return_msg(false, 'Unauthorized', null, 'unauthorized','api');
        }
        if (auth('provider')->user()['is_active'] == 0) {
            // send verify message
            return return_msg(false, 'Not Active need verify', null, 'temporary_redirect','api');
        }
        if ($request['fcm_token'] ?? null) {
            auth('provider')->user()->update(['fcm_token' => $request->fcm_token]);
        }
        return $this->respondWithToken($token);
    }

    public function verifyOtp(Request $request, ProviderService $providerService)
    {
        $data = $request->all();
        $validation = $this->validateVerify($data);
        if ($validation->fails()) return return_msg(
            false,
            'Validation Errors',
            ['validation_errors' => $validation->getMessageBag()],
            'validation_error'
        );
        $provider = $providerService->findBy('phone', $data['phone'])[0];
        if ($provider && $provider['verify_code'] == $data['otp']) {
            $providerService->update($provider->id, ['is_active' => 1]);

            $token = auth('provider')->login($provider);
            return $this->respondWithToken($token);
        }
        return return_msg(false, 'Wrong OTP', null, 'unauthorized','api');
    }

    public function forgetPassword(Request $request, ProviderService $providerService)
    {
        $data = $request->all();
        $validation = $this->validateForgetPassword($data);
        if ($validation->fails()) return return_msg(
            false,
            'Validation Errors',
            ['validation_errors' => $validation->getMessageBag()],
            'validation_error'
        );
        $provider = $providerService->findBy('phone', $data['phone'])[0];
        // $providerService->update($provider->id,['verify_code'=>rand(1000,9999)]);
        $providerService->update($provider->id, ['verify_code' => 8888]);
        return return_msg(true, 'Message Sent, please check your phone');
    }

    public function verifyForgetPassword(Request $request, ProviderService $providerService)
    {
        $data = $request->all();
        $validation = $this->validateVerify($data);
        if ($validation->fails()) return return_msg(
            false,
            'Validation Errors',
            ['validation_errors' => $validation->getMessageBag()],
            'validation_error'
        );
        $provider = $providerService->findBy('phone', $data['phone'])[0];
        if ($provider && $provider['verify_code'] == $data['otp']) {
            return return_msg(true, 'Valid OTP');
        }
        return return_msg(false, 'Wrong OTP', null, 'unauthorized','api');
    }

    public function newPassword(Request $request, ProviderService $providerService)
    {
        $data = $request->all();
        $validation = $this->validateLogin($data);
        $provider = $providerService->findBy('phone', $data['phone'])[0];
        // $providerService->update($provider->id,['verify_code'=>rand(1000,9999)]);
        $providerService->update($provider->id, ['password' => bcrypt($data['password'])]);

        return return_msg(true, 'Password Changed Successfully');
    }


    public function me()
    {
        exit;
        return return_msg(true, 'Logged User', auth('provider')->user());
        //        return response()->json(auth()->user());
    }


    public function logout()
    {
        auth('provider')->logout();
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
            'expires_in' => auth('provider')->factory()->getTTL() * 60,
            'provider' => \auth('provider')->user(),
        ];
        return return_msg(true, 'Authenticated User', $data);
    }
}
