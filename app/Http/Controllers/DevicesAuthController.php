<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class DevicesAuthController extends Controller
{

    use AuthenticatesUsers;
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'password' => 'required|min:6',
        ]);

        $device = Device::create([
            'name' => $request->name,
            'password' => bcrypt($request->password)
        ]);

        $token = $device->createToken('DeviceToken')->accessToken;

        return response()->json(['token' => $token], 200);
    }



    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = [
            'name' => $request->name,
            'password' => $request->password,
        ];

        if (auth('devices')->attempt($credentials)) {
            $device = auth('devices')->user();
            $token = $device->createToken('DeviceToken')->accessToken;
            return response()->json(['id' => $device->id, 'token' => $token], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }

    public function username() {
        return 'name';
    }
}
