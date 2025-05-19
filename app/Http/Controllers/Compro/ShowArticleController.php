<?php

namespace App\Http\Controllers\Compro;

use App\Http\Controllers\BaseController;
use App\Models\Post;
use Illuminate\Http\Request;

class ShowArticleController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $slug)
    {
        try {
            $data = Post::with(['category', 'tags'])
                ->where("slug", $slug)->first();
            if (!$data) {
                return $this->sendError("Post tidak ditemukan");
            }

            $data->views += 1;
            $data->save();

            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
