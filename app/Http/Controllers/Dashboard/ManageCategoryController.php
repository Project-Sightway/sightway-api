<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dashboard\ManageCategoryStoreUpdateRequest;
use App\Models\MCategory;
use Illuminate\Support\Str;

class ManageCategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = MCategory::paginate(10);
            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ManageCategoryStoreUpdateRequest $request)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['name']);
            MCategory::create($data);
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
            $data = MCategory::where('slug', $slug)->first();
            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ManageCategoryStoreUpdateRequest $request, string $slug)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['name']);
            MCategory::where('slug', $slug)->update($data);
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
            MCategory::where('slug', $slug)->delete();
            return $this->sendSuccess(null);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
