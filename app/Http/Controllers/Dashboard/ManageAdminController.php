<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dashboard\ManageAdminResetRequest;
use App\Http\Requests\Dashboard\ManageAdminStoreUpdateRequest;
use App\Models\User;

class ManageAdminController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = User::role('admin')
                ->select(['id', 'name', 'email'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ManageAdminStoreUpdateRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = bcrypt($data['password']);
            $data['role'] = 'admin';

            $user = User::create($data);
            $user->assignRole('admin');
            return $this->sendSuccess($user);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = User::role('admin')
                ->select(['id', 'name', 'email'])
                ->find($id);

            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = User::find($id);
            $data->delete();
            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function resetPassword(ManageAdminResetRequest $request)
    {
        try {
            $data = $request->validated();
            $user = User::where('email', $data['email'])->first();
            $user->password = bcrypt($data['password']);
            $user->save();
            return $this->sendSuccess($user);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
