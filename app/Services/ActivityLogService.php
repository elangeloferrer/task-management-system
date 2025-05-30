<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

use App\Repositories\ActivityLogRepository;

class ActivityLogService implements ActivityLogServiceInterface
{
    protected $activityLogRepository;

    public function __construct(
        ActivityLogRepository $activityLogRepository,
    ) {
        $this->activityLogRepository = $activityLogRepository;
    }

    public function log($data)
    {
        try {
            $log = [
                'user_id' => Auth::user()->id,
                'action' => Arr::get($data, 'action'),
                'user_type' => isset(Auth::user()->role->code) ? Auth::user()->role->code : "",
                'description' => Arr::get($data, 'description'),
                'old_data' => Arr::get($data, 'old_data'),
                'new_data' => Arr::get($data, 'new_data'),
            ];

            return $this->activityLogRepository->create($log);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw $th;
        }
    }
}
