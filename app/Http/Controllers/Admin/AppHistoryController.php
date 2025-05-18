<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\StoreAppHistoryControllerRequest;
use App\Models\AppHistory;
use Illuminate\Support\Str;

class AppHistoryController extends BaseController
{
    public function index()
    {
        try {
            $data = AppHistory::all();
            return $this->sendSuccess($data);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage());
        }
    }
    public function store(StoreAppHistoryControllerRequest $request)
    {
        try {
            $data = $request->validated();
            if ($request->hasFile('file_apk')) {
                $data['file_apk'] = $request->file('file_apk')->storeAs(
                    'app-history/apk',
                    Str::uuid() . '_' . $request->file('file_apk')->getClientOriginalName(),
                    'public'
                );
            }
            if ($request->hasFile('file_ipa')) {
                $data['file_ipa'] = $request->file('file_ipa')->storeAs(
                    'app-history/ipa',
                    Str::uuid() . '_' . $request->file('file_ipa')->getClientOriginalName(),
                    'public'
                );
            }
            $appHistory = AppHistory::create($data);
            return $this->sendSuccess($appHistory);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage());
        }
    }

    public function latest()
    {
        try {
            $data = AppHistory::latest()->first();
            return $this->sendSuccess($data);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage());
        }
    }
}
