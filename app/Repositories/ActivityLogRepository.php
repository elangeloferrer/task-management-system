<?php

namespace App\Repositories;

use App\AbstractBases\AbstractBaseRepository;

use App\Models\ActivityLog;

class ActivityLogRepository extends AbstractBaseRepository
{

    public function __construct(ActivityLog $activityLog)
    {
        parent::__construct($activityLog);
    }
}
