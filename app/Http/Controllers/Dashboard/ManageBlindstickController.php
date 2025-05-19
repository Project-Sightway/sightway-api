<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dashboard\BlindstickStoreUpdateRequest;
use App\Models\BlindStick;

class ManageBlindstickController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $query = BlindStick::orderBy("created_at", "desc");

            if (request()->has('is_used')) {
                $query->where('is_used', request('is_used'));
            }

            $data = $query->paginate(10);
            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlindstickStoreUpdateRequest $request)
    {
        try {
            $data = $request->validated();
            $blindstick = BlindStick::create($data);
            return $this->sendSuccess($blindstick);
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
            $blindstick = BlindStick::find($id);

            $days = request('log_days') ?? 7;
            $logQuery = $blindstick->logBlindsticks();

            if (in_array($days, ['1', '3', '7'])) {
                $logQuery->where('created_at', '>=', now()->subDays((int)$days));
            }
            $logs = $logQuery->orderBy('created_at', 'desc')->paginate(10);

            return $this->sendSuccess([
                'blindstick' => $blindstick,
                'logs' => $logs,
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlindstickStoreUpdateRequest $request, string $id)
    {
        try {
            $data = $request->validated();
            $blindstick = BlindStick::find($id);
            $blindstick->update($data);
            return $this->sendSuccess($blindstick);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
