<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dashboard\ChangePasswordRequest;
use App\Http\Requests\Dashboard\LoginRequest;

class AuthController extends BaseController
{
    public function login(LoginRequest $request)
    {
        try {
            $data = $request->validated();
            if (auth()->attempt($data)) {
                $user = auth()->user();

                if (!$user->hasRole(['admin', 'super_admin'])) {
                    return $this->sendError('Unauthorized access. Admin privileges required.');
                }

                $token = $user->createToken('auth_token')->plainTextToken;
                return $this->sendSuccess($token);
            }

            return $this->sendError('Invalid credentials');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function logout()
    {
        try {
            auth()->user()->tokens()->delete();
            return $this->sendSuccess('Logged out successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function me()
    {
        try {
            $user = auth()->user();

            $roles = $user->getRoleNames()->implode(',');

            $data = $user->toArray();
            $data['roles'] = $roles;

            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $data = $request->validated();
            $user = auth()->user();
            if (!password_verify($data['old_password'], $user->password)) {
                return $this->sendError('Old password does not match');
            }
            $user->password = bcrypt($data['new_password']);
            $user->save();

            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
