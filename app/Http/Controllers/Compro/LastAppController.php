<?php

namespace App\Http\Controllers\Compro;

use App\Http\Controllers\BaseController;
use App\Models\AppHistory;

class LastAppController extends BaseController
{
    public function __invoke()
    {
        try {
            try {
                $data = AppHistory::latest()->get();
                return $this->sendSuccess($data);
            } catch (\Exception $e) {
                return $this->sendError($e->getMessage());
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
