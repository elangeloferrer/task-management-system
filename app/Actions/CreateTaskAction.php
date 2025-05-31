<?php

namespace App\Actions;

use App\Repositories\TaskRepository;

class CreateTaskAction
{
    protected $repository;

    public function __construct(
        TaskRepository $repository,
    ) {
        $this->repository = $repository;
    }

    public function execute($data)
    {
        $task = $this->repository->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
            'priority' => $data['priority'],
            'order' => $data['order'],
            'user_id' => $data['user_id'],
        ]);
        return $task;
    }
}
