<?php

namespace App\Http\Controllers\Compro;

use App\Http\Controllers\BaseController;
use App\Models\Post;

class SearchArticleController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        try {
            $query = Post::with(['category', 'tags'])
                ->select(['id', 'title', 'slug', 'views', 'created_at', 'content']);

            if (request()->has('q')) {
                $query->where('title', 'like', '%' . request('q') . '%');
            }

            if (request()->has('category')) {
                $query->whereHas('category', function ($q) {
                    $q->where('slug', request('category'));
                });
            }

            if (request()->has('tags')) {
                $tags = explode(',', request('tags'));
                foreach ($tags as $tag) {
                    $query->whereHas('tags', function ($q) use ($tag) {
                        $q->where('slug', trim($tag));
                    });
                }
            }

            $data = $query->paginate(10)
                ->through(function ($post) {
                    $words = str_word_count(strip_tags($post->content), 1);
                    $post->content = implode(' ', array_slice($words, 0, 10));
                    return $post;
                });

            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
