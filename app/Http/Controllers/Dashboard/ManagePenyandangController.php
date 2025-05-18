<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Models\BlindStick;
use App\Models\Penyandang;
use App\Models\User;
use Illuminate\Http\Request;

class ManagePenyandangController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $query = User::with('penyandang')
                ->whereHas('penyandang')
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
            $penyandang = Penyandang::with([
                'user:id,email,name',
                'blindstick'
            ])
                ->where('user_id', $id)
                ->first();
            $pemantau = $penyandang->pemantau()
                ->paginate(10);

            return $this->sendSuccess([
                'penyandang' => $penyandang,
                'pemantau' => $pemantau,
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function latestStatusBlindstick(string $id)
    {
        try {
            $data = BlindStick::find($id);
            $latestStatus = $data->logBlindstick()
                ->orderBy('created_at', 'desc')
                ->get(3);

            return $this->sendSuccess([
                'blindstick' => $data,
                'latest_status' => $latestStatus,
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
