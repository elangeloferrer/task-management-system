<?php

namespace App\Actions;

use App\Repositories\TaskRepository;

class UpdateTaskAction
{
    protected $repository;

    public function __construct(
        TaskRepository $repository,
    ) {
        $this->repository = $repository;
    }

    public function execute($data, $id)
    {
        $task = $this->repository->findById($id);
        $task = $this->repository->update(
            $task->id,
            [
                'title' => $data['title'],
                'description' => $data['description'],
                'status' => $data['status'],
                'priority' => $data['priority'],
                'order' => $data['order'],
            ]
        );
        return $task;
    }
}
