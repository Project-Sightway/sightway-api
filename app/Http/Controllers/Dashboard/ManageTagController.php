<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\MTagStoreUpdateRequest;
use App\Models\MTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ManageTagController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = MTag::paginate(10);
            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MTagStoreUpdateRequest $request)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['name']);
            MTag::create($data);
            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        try {
            $data = MTag::where('slug', $slug)->first();
            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MTagStoreUpdateRequest $request, string $slug)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['name']);
            MTag::where('slug', $slug)->update($data);
            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        try {
            MTag::where('slug', $slug)->delete();
            return $this->sendSuccess(null);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
