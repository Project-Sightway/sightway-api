<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\StorePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostController extends BaseController
{
    public function index()
    {
        try {
            $data = Post::with(['category', 'tags'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function store(StorePostRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = $request->file('thumbnail')->storeAs(
                    'posts/thumbnail',
                    Str::uuid() . '_' . $request->file('thumbnail')->getClientOriginalName(),
                    'public'
                );
            }

            $data['slug'] = Str::slug($request->title);
            $post = Post::create($data);
            DB::commit();
            return $this->sendSuccess($post);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    public function show($slug)
    {
        try {
            $data = Post::with(['category', 'tags'])
                ->where('slug', $slug)
                ->first();
            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function update(StorePostRequest $request, $slug)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $post = Post::where('slug', $slug)->first();
            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = $request->file('thumbnail')->storeAs(
                    'posts/thumbnail',
                    Str::uuid() . '_' . $request->file('thumbnail')->getClientOriginalName(),
                    'public'
                );
            }
            $post->update($data);
            DB::commit();
            return $this->sendSuccess($post);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    public function destroy($slug)
    {
        DB::beginTransaction();
        try {
            $post = Post::where('slug', $slug)->first();
            $post->delete();
            DB::commit();
            return $this->sendSuccess($post);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    public function addCountView($slug)
    {
        DB::beginTransaction();
        try {
            $post = Post::where('slug', $slug)->first();
            $post->count_view = $post->count_view + 1;
            $post->save();
            DB::commit();
            return $this->sendSuccess($post);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }
}
