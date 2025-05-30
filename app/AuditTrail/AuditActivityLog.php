<?php

namespace App\AuditTrail;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

use App\Repositories\ActivityLogRepository;

class AuditActivityLog
{
    protected $payload;

    protected $activityLogRepository;

    public function __construct(
        ActivityLogRepository $activityLogRepository,
    ) {
        $this->activityLogRepository = $activityLogRepository;
    }

    public function call()
    {
        try {
            $log = [
                'user_id' => Auth::user()->id ?? 0,
                'action' => Arr::get($this->getPayload(), 'action'),
                'user_type' => Auth::user()->role->code ?? "system",
                'description' => Arr::get($this->getPayload(), 'description'),
                'old_data' => Arr::get($this->getPayload(), 'old_data'),
                'new_data' => Arr::get($this->getPayload(), 'new_data'),
            ];

            $result = $this->activityLogRepository->create($log);
            Log::debug('START: RESULT OF ACTIVITY LOG');
            Log::debug($result);
            Log::debug('END: RESULT OF ACTIVITY LOG');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw $th;
        }
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function setPayload(array $payload): AuditActivityLog
    {
        $this->payload = $payload;
        return $this;
    }
}
