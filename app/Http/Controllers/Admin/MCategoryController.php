<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Models\MCategory;
use Illuminate\Support\Str;

class MCategoryController extends BaseController
{
    public function index()
    {
        try {
            $data = MCategory::all();
            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['name']);
            $category = MCategory::create($data);
            return $this->sendSuccess($category);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
