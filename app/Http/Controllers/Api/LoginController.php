<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    protected function validateForm($request, $type)
    {
        switch ($type) {
            case 'login':
                return Validator::make(
                    $request->all(),
                    [
                        'email' => 'required|email|max:191',
                        'password' => 'required|string|min:6|max:191'
                    ]
                );
                break;
            case 'register':
                return Validator::make(
                    $request->all(),
                    [
                        'name' => 'required|string|max:191',
                        'email' => [
                            'required',
                            'email',
                            'max:191',
                            Rule::unique('users')->ignore($id)
                        ],
                        'password' => 'required|string|min:6|max:20|confirmed',
                    ]
                );
                break;
        }
    }

    public function login(Request $request)
    {
        $validator = $this->validateForm($request, 'login');

        if ($validator->fails()) {
            return response()->json(['message' => 'Error', 'errors' => $validator->errors()], 400);
        }

        $credentials = [
            'grant_type' => 'password',
            'client_id' => env('PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSWORD_CLIENT_SECRET'),
            'username' => $request->input('email'),
            'password' => $request->input('password'),
            'scope' => ''
        ];

        $requestToken = Request::create('/oauth/token', 'POST', $credentials);
        return app()->handle($requestToken);

        // try {
        //     if (Auth::attempt($credentials)) {
        //         $user = Auth::user();
        //         $personal_client_name = env('PERSONAL_CLIENT_NAME');
        //         $token = $user->createToken($personal_client_name)->accessToken;

        //         return response()->json(['token' => $token], 200);
        //     } else {
        //         return response()->json(['message' => 'Unauthorised'], 401);
        //     }
        // } catch (\Exception $e) {
        //     return response()->json(['message' => 'Internal server error'], 500);
        // }
    }

    public function loginRefresh(Request $request)
    {
        $credentials = [
            'grant_type' => 'refresh_token',
            'client_id' => env('PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSWORD_CLIENT_SECRET'),
            'refresh_token' => $request->input('refresh_token'),
            'scope' => ''
        ];

        $requestToken = Request::create('/oauth/token', 'POST', $credentials);
        return app()->handle($requestToken);
    }

    public function logout(Request $request)
    {
        $accessToken = auth()->user()->token();

        $refreshToken = DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();

        return response()->json(['message' => 'You are Logged out.'], 200);

        // $request->user()->token()->revoke();

        // return response()->json(['message' => 'You are Logged out.'], 200);
    }

    public function register()
    {
        $validator = $this->validateForm($request, 'register');

        if ($validator->fails()) {
            return response()->json(['message' => 'Error', 'errors' => $validator->errors()], 400);
        }

        $credentials = $request->only(['name', 'email', 'password']);
        $data['password'] = Hash::make($data['password']);

        try {
            $user = User::create($data);

            return response()->json([$user], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
}
