<?php

namespace App\Http\Controllers\Compro;

use App\Http\Controllers\BaseController;
use App\Models\Post;
use Illuminate\Http\Request;

class GetLastArticleController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $data = Post::with(['category', 'tags'])
                ->select(['id', 'title', 'slug', 'views', 'created_at'])
                ->orderBy('created_at', 'desc')
                ->take(3)->get();
            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
