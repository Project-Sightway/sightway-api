<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Models\LogUser;
use App\Models\MCategory;
use App\Models\MTag;
use App\Models\Post;
use App\Models\User;

class DashboardController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        try {
            $data = [
                'total_posts' => Post::count(),
                'total_categories' => MCategory::count(),
                'total_tags' => MTag::count(),
                'total_users' => User::count(),
                'recent_activity' => LogUser::with('user')->orderBy('created_at', 'desc')->take(5)->get(),
            ];

            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
