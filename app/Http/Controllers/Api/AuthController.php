<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\UserResource;

class AuthController extends BaseController
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ]);

        $success['token'] = $user->createToken('BookEasyApp')->plainTextToken;
        $success['user'] = new UserResource($user);

        return $this->sendResponse($success, 'User registered successfully.');
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('BookEasyApp')->plainTextToken;
            $success['user'] = new UserResource($user);

            // Log activity
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'Login',
                'description' => 'User logged in via API',
                'ip_address' => $request->ip()
            ]);

            return $this->sendResponse($success, 'User logged in successfully.');
        } else {
            return $this->sendError('Unauthorized.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        
        // Log activity
        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'Logout',
            'description' => 'User logged out via API',
            'ip_address' => $request->ip()
        ]);

        $user->tokens()->delete();
        
        return $this->sendResponse([], 'Successfully logged out.');
    }
}
