<?php

namespace App\Repositories;

use App\AbstractBases\AbstractBaseRepository;

use App\Http\Resources\UserWithTasksResource;

use App\Models\User;


class UserRepository extends AbstractBaseRepository
{

    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function getAllUsersWithTasks($perPage = 10)
    {
        $query = $this->model->whereHas('role', fn($q) => $q->where('code', 'user'));

        $query = $query->withCount([
            'tasks as pending_tasks_count' => fn($q) => $q->where('status', 'pending'),
            'tasks as in_progress_tasks_count' => fn($q) => $q->where('status', 'in-progress'),
            'tasks as completed_tasks_count' => fn($q) => $q->where('status', 'completed'),
        ]);

        $collection = $query->paginate($perPage);

        return UserWithTasksResource::collection($collection);
    }
}
