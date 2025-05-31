<?php

namespace App\Repositories;

use App\AbstractBases\AbstractBaseRepository;

use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ArrayTaskResource;

use App\Models\Task;


class TaskRepository extends AbstractBaseRepository
{

    public function __construct(Task $task)
    {
        parent::__construct($task);
    }

    public function getAllTasksByUser($perPage = 10)
    {
        $query = $this->model->where('user_id', Auth::user()->id);

        $collection = $query->paginate($perPage);

        return ArrayTaskResource::collection($collection);
    }
}
