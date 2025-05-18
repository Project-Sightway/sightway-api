<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dashboard\ManagePostStoreUpdateRequest;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ManagePostController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $orderDirection = request('order_direction', 'desc');
            $query = Post::select(['id', 'thumbnail', 'title', 'views', 'created_at']);


            // Handle search by post title if q parameter exists
            if (request()->has('q')) {
                $query->where('title', 'like', '%' . request('q') . '%');
            }

            // Handle sorting direction
            if (!in_array($orderDirection, ['asc', 'desc'])) {
                $orderDirection = 'desc';
            }

            $query->orderBy('created_at', $orderDirection);

            $data = $query->paginate(10);
            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ManagePostStoreUpdateRequest $request)
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

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        try {
            $data = Post::with(['category', 'tags'])->where('slug', $slug)->first();
            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ManagePostStoreUpdateRequest $request, string $slug)
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        try {
            try {
                $post = Post::where('slug', $slug)->first();
                $post->delete();
                return $this->sendSuccess($post);
            } catch (\Exception $e) {
                return $this->sendError($e->getMessage());
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
