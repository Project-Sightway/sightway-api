<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Models\LogPenyandangStatus;
use App\Models\Pemantau;
use App\Models\User;

class ManagePemantauController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $query = User::with('pemantau')
                ->whereHas('pemantau')
                ->select(['id', 'name', 'email', 'created_at']);

            if (request()->has('q')) {
                $query->where('name', 'like', '%' . request('q') . '%');
            }

            $query->orderBy('created_at', 'desc');
            $data = $query->paginate(10);
            return $this->sendSuccess($data);
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
            $pemantau = Pemantau::with('user')->where('user_id', $id)->first();
            $penyandang = $pemantau->penyandang()
                ->paginate(10);
            return $this->sendSuccess([
                'pemantau' => $pemantau,
                'penyandang' => $penyandang,
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function getLastMap(string $id)
    {
        try {
            $data = LogPenyandangStatus::where('penyandang_id', $id)->latest()->first();
            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
