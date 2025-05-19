<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dashboard\AppHistoryStoreRequest;
use App\Models\AppHistory;
use Illuminate\Support\Str;

class AppHistoryController extends BaseController
{
    public function index()
    {
        try {
            $data = AppHistory::select(['id', 'name', 'created_at'])
                ->orderBy("created_at", "desc")->paginate(10);
            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = AppHistory::find($id);
            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function store(AppHistoryStoreRequest $request)
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
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $data = AppHistory::find($id);
            $data->delete();
            return $this->sendSuccess(null);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
