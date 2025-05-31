<?php

namespace App\Services;

use App\Http\Resources\SingleTaskResource;

use App\Helpers\ApiResponse;
use App\Repositories\TaskRepository;

use App\Actions\CreateTaskAction;
use App\Actions\UpdateTaskAction;

class TaskService implements TaskServiceInterface
{

    protected $taskRepository;
    protected $createTaskAction;
    protected $updateTaskAction;

    public function __construct(
        TaskRepository $taskRepository,
        CreateTaskAction $createTaskAction,
        UpdateTaskAction $updateTaskAction,
    ) {
        $this->taskRepository = $taskRepository;
        $this->createTaskAction = $createTaskAction;
        $this->updateTaskAction = $updateTaskAction;
    }

    public function getAllTasksByUser($payload)
    {
        $items = $this->taskRepository->getAllTasksByUser($payload['per_page']);
        $data = [
            'tasks' => $items,
            'pagination' => [
                'current_page' => $items->currentPage(),
                'next_page_url' => $items->nextPageUrl(),
                'prev_page_url' => $items->previousPageUrl(),
                'per_page' => $items->perPage(),
                'total_items' => $items->total(),
                'total_pages' => $items->lastPage(),
            ],
        ];
        return ApiResponse::success($data, "Successfully fetched tasks", 200);
    }

    public function store($data)
    {
        try {
            $task = $this->createTaskAction->execute($data);
            return ApiResponse::success(new SingleTaskResource($task), "Successfully created task.", 201);
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage(), 400);
        }
    }

    public function show($id)
    {
        $task = $this->taskRepository->findById($id);
        return ApiResponse::success(new SingleTaskResource($task), "Successfully fetched task", 200);
    }

    public function update($data, $id)
    {
        try {
            $task = $this->updateTaskAction->execute($data, $id);
            return ApiResponse::success(new SingleTaskResource($task), "Successfully updated task.", 201);
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage(), 400);
        }
    }

    public function destroy($id)
    {
        try {
            $this->taskRepository->delete($id);
            ApiResponse::success([], "Successfully deleted task.", 200);
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage(), 400);
        }
    }
}
