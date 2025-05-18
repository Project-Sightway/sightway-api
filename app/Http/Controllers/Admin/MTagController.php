<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\StoreTagRequest;
use App\Models\MTag;
use Illuminate\Support\Str;


class MTagController extends BaseController
{
    public function index()
    {
        try {
            $data = MTag::all();
            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function store(StoreTagRequest $request)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['name']);
            $tag = MTag::create($data);
            return $this->sendSuccess($tag);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
