<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Validator;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailAuthUser;

class AuthController extends Controller
{
    /**
     *
     */
    protected function validateForm($request, $type)
    {
        switch ($type) {
            case 'login':
                return Validator::make(
                    $request->all(),
                    [
                        'email' => 'required|email|max:191',
                        'password' => 'required|string|min:6|max:20'
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
                            Rule::unique('users')
                        ],
                        'password' => 'required|string|min:6|max:20|confirmed',
                    ]
                );
                break;
        }
    }

    /**
     *
     */
    public function login(Request $request)
    {
        $validator = $this->validateForm($request, 'login');

        if ($validator->fails()) {
            return response()->json(['message' => 'Error', 'errors' => $validator->errors()], 400);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
        } else {
            return response()->json(['message' => 'Unauthorised'], 401);
        }

        $roles = array_pluck($user->roles, 'name');
        $scope = '';

        foreach ($roles as $role) {
            $scope = str_finish($scope, ' ' . $role);
        }

        $credentials = [
            'grant_type' => 'password',
            'client_id' => env('PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSWORD_CLIENT_SECRET'),
            'username' => $request->input('email'),
            'password' => $request->input('password'),
            'scope' => trim($scope)
        ];

        $requestToken = Request::create('/oauth/token', 'POST', $credentials);

        return app()->handle($requestToken);
    }

    /**
     *
     */
    public function loginRefresh(Request $request)
    {
        $credentials = [
            'grant_type' => 'refresh_token',
            'client_id' => env('PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSWORD_CLIENT_SECRET'),
            'refresh_token' => $request->input('refresh_token')
        ];

        $requestToken = Request::create('/oauth/token', 'POST', $credentials);
        return app()->handle($requestToken);
    }

    /**
     *
     */
    public function logout(Request $request)
    {
        $accessToken = auth()->user()->token();

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();

        return response()->json(['message' => 'You are Logged out.'], 200);
    }

    /**
     *
     */
    public function register(Request $request)
    {
        $validator = $this->validateForm($request, 'register');

        if ($validator->fails()) {
            return response()->json(['message' => 'Error', 'errors' => $validator->errors()], 400);
        }

        $credentials = $request->only(['name', 'email', 'password']);
        $credentials['password'] = bcrypt($credentials['password']);
        $credentials['account_hash'] = bcrypt(today());

        DB::beginTransaction();

        try {
            $user = User::create($credentials);
            $role = Role::where('name', 'Usuário')->get()->first();
            $user->roles()->attach($role->id);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json(['message' => 'Internal server error.'], 500);
        }

        Mail::to($user->email)->send(new MailAuthUser($user));
        
        return response()->json([$user], 201);
    }
}
